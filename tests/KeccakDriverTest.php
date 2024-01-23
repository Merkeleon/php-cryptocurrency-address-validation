<?php

declare(strict_types=1);

namespace Tests;

use Merkeleon\PhpCryptocurrencyAddressValidation\DriverConfig;
use Merkeleon\PhpCryptocurrencyAddressValidation\Drivers\KeccakDriver;
use Merkeleon\PhpCryptocurrencyAddressValidation\Enums\CurrencyEnum;
use Merkeleon\PhpCryptocurrencyAddressValidation\Validator;

/**
 * @coversDefaultClass \Merkeleon\PhpCryptocurrencyAddressValidation\Drivers\KeccakDriver
 */
class KeccakDriverTest extends TestCase
{
    /**
     * @covers ::check
     * @dataProvider addressesProvider
     *
     * @param string $net
     * @param bool   $expected
     * @param string $address
     *
     * @return void
     */
    public function test_keccak_driver(string $net, bool $expected, string $address): void
    {
        $config = [new DriverConfig(KeccakDriver::class)];

        $validator = new Validator(CurrencyEnum::ETHEREUM->value, $net === 'mainnet', $config);

        self::assertEquals($expected, $validator->isValid($address));
    }

    public function addressesProvider(): array
    {
        return [
            'Ethereum #1' => ['mainnet', true, '0xe80b351948D0b87EE6A53e057A91467d54468D91'],
            'Ethereum #2' => ['testnet', true, '0x799aD3Ff7Ef43DfD1473F9b8a8C4237c22D8113F'],
            'Ethereum #3' => ['mainnet', true, '0xe80b351948d0b87ee6a53e057a91467d54468d91'],
            'Ethereum #4' => ['testnet', true, '0x799ad3ff7ef43dfd1473f9b8a8c4237c22d8113f'],
        ];
    }
}
