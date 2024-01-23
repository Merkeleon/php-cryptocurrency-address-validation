<?php

declare(strict_types=1);

namespace Merkeleon\PhpCryptocurrencyAddressValidation;

use Generator;
use Merkeleon\PhpCryptocurrencyAddressValidation\Contracts\Driver;
use Merkeleon\PhpCryptocurrencyAddressValidation\Enums\CurrencyEnum;
use Merkeleon\PhpCryptocurrencyAddressValidation\Exception\AddressValidationException;

class Validator implements Contracts\Validator
{
    private const CONFIG_PATH = __DIR__ . '/../config/address_validation.php';

    /**
     * @param DriverConfig[] $options
     */
    public function __construct(
        private readonly string $chain,
        private readonly bool $isMainnet = true,
        private ?array $options = null,
    ) {
        $this->options = $options ?? $this->resolveConfigForCurrency(CurrencyEnum::from($this->chain));
    }

    public static function make(CurrencyEnum $currency, bool $isMainnet = true, ?array $config = null): self
    {
        return new self($currency->value, $isMainnet, $config);
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
        foreach ($this->options as $driverConfig) {
            if ($driver = $driverConfig->makeDriver($this->isMainnet)) {
                yield $driver;
            }
        }

        return null;
    }

    /**
     * @param Driver[] $drivers
     */
    protected function getDriver(iterable $drivers, string $address): ?Driver
    {
        foreach ($drivers as $driver) {
            if ($driver->match($address)) {
                return $driver;
            }
        }

        return null;
    }

    /**
     * @return DriverConfig[]
     */
    protected function resolveConfigForCurrency(CurrencyEnum $currency): array
    {
        /** @var array<string, DriverConfig[]> $config */
        $config = require self::CONFIG_PATH;

        return $config[$currency->value];
    }
}
