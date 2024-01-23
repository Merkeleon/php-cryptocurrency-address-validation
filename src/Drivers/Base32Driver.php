<?php

declare(strict_types=1);

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Drivers;

use Merkeleon\PhpCryptocurrencyAddressValidation\Utils\Base32Decoder;
use RuntimeException;
use Throwable;
use function array_flip;
use function array_key_exists;
use function array_keys;
use function array_slice;
use function implode;
use function pack;
use function preg_match;
use function str_contains;
use function sprintf;
use function strtolower;

class Base32Driver extends AbstractDriver
{
    protected static array $hashBits = [
        160 => 0,
        192 => 1,
        224 => 2,
        256 => 3,
        320 => 4,
        384 => 5,
        448 => 6,
        512 => 7,
    ];

    public function match(string $address): bool
    {
        $address = strtolower($address);

        $prefix = implode('|', array_keys($this->options));
        $pattern = sprintf('/^((%s)?([qp])[a-z0-9]{41,120})/', $prefix);

        return preg_match($pattern, $address) === 1;
    }

    public function check(string $address, array $networks = []): bool
    {
        try {
            $hasPrefix = false;

            foreach (array_keys($this->options) as $key) {
                if (str_contains($address, (string) $key)) {
                    $hasPrefix = true;
                    break;
                }
            }

            $address = strtolower($address);

            [,$words] = Base32Decoder::decode($address, $hasPrefix);

            $numWords = count($words);
            $bytes = Base32Decoder::fromWords($numWords, $words);
            $numBytes = count($bytes);

            $this->extractPayload($numBytes, $bytes);

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * @return string[] - script type and hash
     */
    protected function extractPayload(int $numBytes, array $payloadBytes): array
    {
        if ($numBytes < 1) {
            throw new RuntimeException("Empty base32 string");
        }

        [$scriptType, $hashLengthBits] = $this->decodeVersion($payloadBytes[0]);

        if (($hashLengthBits / 8) !== $numBytes - 1) {
            throw new RuntimeException("Hash length does not match version");
        }

        $hash = "";

        foreach (array_slice($payloadBytes, 1) as $byte) {
            $hash .= pack("C*", $byte);
        }

        return [$scriptType, $hash];
    }


    protected function decodeVersion(int $version): array
    {
        if (($version >> 7) & 1) {
            throw new RuntimeException("Invalid version - MSB is reserved");
        }

        $scriptMarkerBits = ($version >> 3) & 0x1f;
        $hashMarkerBits = ($version & 0x07);

        $hashBitsMap = array_flip(self::$hashBits);
        if (!array_key_exists($hashMarkerBits, $hashBitsMap)) {
            throw new RuntimeException("Invalid version or hash length");
        }
        $hashLength = $hashBitsMap[$hashMarkerBits];

        $scriptType = match ($scriptMarkerBits) {
            0 => "pubkeyhash",
            1 => "scripthash",
            default => throw new RuntimeException('Invalid version or script type'),
        };

        return [$scriptType, $hashLength];
    }
}
