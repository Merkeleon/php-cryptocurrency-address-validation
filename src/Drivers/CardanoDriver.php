<?php

declare(strict_types=1);

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Drivers;

use Merkeleon\PhpCryptocurrencyAddressValidation\Exception\Bech32Exception;
use Merkeleon\PhpCryptocurrencyAddressValidation\Utils\Bech32Decoder;
use function array_keys;
use function implode;
use function preg_match;

class CardanoDriver extends AbstractDriver
{
    public function match(string $address): bool
    {
        $prefix =  implode('|', array_keys($this->options));
        $expr = sprintf('/^((%s)(0([ac-hj-np-z02-9]{39}|[ac-hj-np-z02-9]{59})|1[ac-hj-np-z02-9]{8,}))$/', $prefix);

        return preg_match($expr, $address) === 1;
    }

    public function check(string $address): bool
    {
        try {
            $decoded = (new Bech32Decoder())->decodeRaw($address);

            return array_key_exists($decoded[0], $this->options);
        } catch (Bech32Exception) {
            return false;
        }
    }
}
