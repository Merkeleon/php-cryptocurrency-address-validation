<?php

declare(strict_types=1);

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Drivers;

use function bcadd;
use function bccomp;
use function bcdiv;
use function bcmul;
use function preg_match;
use function str_split;
use function strlen;
use function strpos;

class SolanaDriver extends AbstractDriver
{
    private const BASE58_ALPHABET = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

    private const SOLANA_ADDRESS_BYTES = 32;

    public function match(string $address): bool
    {
        return preg_match('/^[1-9A-HJ-NP-Za-km-z]{32,44}$/', $address) === 1;
    }

    public function check(string $address): bool
    {
        $leadingOnes = 0;
        $length = strlen($address);

        while ($leadingOnes < $length && $address[$leadingOnes] === '1') {
            $leadingOnes++;
        }

        $number = '0';
        foreach (str_split($address) as $char) {
            $index = strpos(self::BASE58_ALPHABET, $char);

            if ($index === false) {
                return false;
            }

            $number = bcadd(bcmul($number, '58', 0), (string) $index, 0);
        }

        $byteLength = 0;
        while (bccomp($number, '0') === 1) {
            $byteLength++;
            $number = bcdiv($number, '256', 0);
        }

        return ($leadingOnes + $byteLength) === self::SOLANA_ADDRESS_BYTES;
    }
}
