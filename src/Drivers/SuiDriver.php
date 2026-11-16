<?php

declare(strict_types=1);

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Drivers;

use function preg_match;

class SuiDriver extends AbstractDriver
{
    private const ADDRESS_PATTERN = '/^0x[0-9a-f]{64}\z/';

    public function match(string $address): bool
    {
        return preg_match(self::ADDRESS_PATTERN, $address) === 1;
    }

    public function check(string $address): bool
    {
        return $this->match($address);
    }
}
