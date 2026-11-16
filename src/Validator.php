<?php

declare(strict_types=1);

namespace Merkeleon\PhpCryptocurrencyAddressValidation;

use Generator;
use Merkeleon\PhpCryptocurrencyAddressValidation\Contracts\Driver;
use Merkeleon\PhpCryptocurrencyAddressValidation\Enums\CurrencyEnum;
use Merkeleon\PhpCryptocurrencyAddressValidation\Exception\AddressValidationException;
use function app;
use function config;

readonly class Validator implements Contracts\Validator
{
    public function __construct(
        private string $chain,
        private array  $options,
        private bool   $isMainnet = true
    ) {
    }

    public static function make(CurrencyEnum $currency): Validator
    {
        $isMAinNet  = app()->isProduction() || app()->environment('demo');
        return new Validator($currency->value, config("address_validation.$currency->value"), $isMAinNet);
    }

    public function isValid(?string $address): bool
    {
        if (!$address) {
            return false;
        }

        $drivers = $this->getDrivers();
        // if there is no drivers we force address to be valid
        if (null === $drivers || !$drivers->valid()) {
            return true;
        }

        return (bool) $this->getDriver($drivers, $address)?->check($address);
    }

    public function validate(?string $address): void
    {
        if (!$address) {
            return;
        }

        $drivers = $this->getDrivers();
        // if there is no drivers we force address to be valid
        if (null === $drivers || !$drivers->valid()) {
            return;
        }

        $driver = $this->getDriver($drivers, $address);

        if ($driver === null) {
            throw new AddressValidationException($this->chain, $address, false);
        }

        if (!$driver->check($address)) {
            throw new AddressValidationException($this->chain, $address, true);
        }
    }

    /**
     * @return Generator<int, Driver>|null
     */
    protected function getDrivers(): ?Generator
    {
        /** @var DriverConfig $driverConfig */
        foreach ($this->options as $driverConfig) {
            if ($driver = $driverConfig->makeDriver($this->isMainnet)) {
                yield $driver;
            }
        }

        return null;
    }

    protected function getDriver(iterable $drivers, string $address): ?Driver
    {
        /** @var Driver $driver */
        foreach ($drivers as $driver) {
            if ($driver->match($address)) {
                return $driver;
            }
        }

        return null;
    }
}