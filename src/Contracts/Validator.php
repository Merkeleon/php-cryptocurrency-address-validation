<?php

declare(strict_types=1);

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Contracts;

use Merkeleon\PhpCryptocurrencyAddressValidation\Exception\AddressValidationException;

interface Validator
{
    public function isValid(?string $address): bool;

    /**
     * @param string|null $address
     *
     * @return void
     *
     * @throws AddressValidationException
     */
    public function validate(?string $address): void;
}
