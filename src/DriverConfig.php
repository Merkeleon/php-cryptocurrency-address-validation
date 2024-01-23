<?php

declare(strict_types=1);

namespace Merkeleon\PhpCryptocurrencyAddressValidation;

use Merkeleon\PhpCryptocurrencyAddressValidation\Drivers\AbstractDriver;
use function class_exists;

final readonly class DriverConfig
{
    /**
     * @param class-string<AbstractDriver> $driver
     * @param array $mainnet
     * @param array $testnet
     */
    public function __construct(
        private string $driver,
        private array $mainnet = [],
        private array $testnet = []
    ) {
    }

    public function makeDriver(bool $isMainNet): ?AbstractDriver
    {
        if (!class_exists($this->driver)) {
            return null;
        }

        return new $this->driver($this->getDriverOptions($isMainNet));

    }

    private function getDriverOptions(bool $isMainNet): array
    {
        if ($isMainNet) {
            return $this->mainnet;
        }

        return $this->testnet
            ?: $this->mainnet
                ?: [];
    }
}
