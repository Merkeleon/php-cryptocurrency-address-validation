<?php

declare(strict_types=1);

use Merkeleon\PhpCryptocurrencyAddressValidation\DriverConfig;
use Merkeleon\PhpCryptocurrencyAddressValidation\Drivers;
use Merkeleon\PhpCryptocurrencyAddressValidation\Enums\CurrencyEnum;

return [
    CurrencyEnum::BEACON->value => [
        new DriverConfig(
            Drivers\Bech32Driver::class,
            ['bnb' => null],
            ['tbnb' => null]
        ),
    ],
    CurrencyEnum::BITCOIN_CASH->value => [
        new DriverConfig(
            Drivers\Base32Driver::class,
            ['bitcoincash:' => null],
            ['bchtest:' => null, 'bchreg:' => null,]
        ),
        new DriverConfig(
            Drivers\DefaultBase58Driver::class,
            ['1' => '00', '3' => '05'],
            ['2' => 'C4', 'm' => '6F']
        ),
    ],
    CurrencyEnum::BITCOIN->value => [
        new DriverConfig(
            Drivers\DefaultBase58Driver::class,
            ['1' => '00', '3' => '05'],
            ['2' => 'C4', 'm' => '6F']
        ),
        new DriverConfig(
            Drivers\Bech32Driver::class,
            ['bc' => null],
            ['tb' => null, 'bcrt' => null]
        ),
        new DriverConfig(
            Drivers\Base32Driver::class,
            ['bitcoincash:' => null],
            ['bchtest:' => null, 'bchreg:' => null,]
        ),
        new DriverConfig(
            Drivers\DefaultBase58Driver::class,
            ['1' => '00', '3' => '05'],
            ['2' => 'C4', 'm' => '6F']
        ),
    ],
    CurrencyEnum::CARDANO->value => [
        new DriverConfig(
            Drivers\CardanoDriver::class,
            ['addr' => null],
            ['addr_test' => null],
        ),
        new DriverConfig(
            Drivers\CborDriver::class,
            ['A' => 33, 'D' => 66],
            ['2' => 40, '3' => 73],
        )
    ],
    CurrencyEnum::DASHCOIN->value => [
        new DriverConfig(
            Drivers\DefaultBase58Driver::class,
            ['X' => '4C', '7' => '10'],
            ['y' => '8C', '8' => '13']
        ),
    ],
    CurrencyEnum::DOGECOIN->value => [
        new DriverConfig(
            Drivers\DefaultBase58Driver::class,
            ['D' => '1E', '9' => '16', 'A' => '16'],
            ['n' => '71', 'm' => '6F', '2' => 'C4',],
        ),
    ],
    CurrencyEnum::EOS->value => [
        new DriverConfig(Drivers\EosDriver::class),
    ],
    CurrencyEnum::ETHEREUM->value => [
        new DriverConfig(Drivers\KeccakStrictDriver::class),
    ],
    CurrencyEnum::LITECOIN->value => [
        new DriverConfig(
            Drivers\DefaultBase58Driver::class,
            ['L' => '30', 'M' => '32', '3' => '05'],
            ['m' => '6F', 'n' => '6F', '2' => 'C4', 'Q' => '3A']
        ),
        new DriverConfig(
            Drivers\Bech32Driver::class,
            ['ltc' => null],
            ['tltc' => null, 'rltc' => null]
        )
    ],
    CurrencyEnum::RIPPLE->value => [
        new DriverConfig(
            Drivers\XrpBase58Driver::class,
            ['r' => '00']
        ),
        new DriverConfig(
            Drivers\XrpXAddressDriver::class,
            ['X' => null],
            ['T' => null],
        ),
    ],
    CurrencyEnum::TRON->value => [
        new DriverConfig(
            Drivers\DefaultBase58Driver::class,
            ['T' => '41'],
        ),
    ],
    CurrencyEnum::ZCASH->value => [
        new DriverConfig(
            Drivers\DefaultBase58Driver::class,
            ['t' => '1C'],
        ),
    ],
    CurrencyEnum::TON->value => [
        new DriverConfig(
            Drivers\Base64Crc16Driver::class,
            ['T' => '41'],
        ),
    ],

    CurrencyEnum::ARBITRUM->value => [
        new DriverConfig(Drivers\KeccakStrictDriver::class),
    ],

    CurrencyEnum::BASE->value => [
        new DriverConfig(Drivers\KeccakStrictDriver::class),
    ],

    CurrencyEnum::OPTIMISM->value => [
        new DriverConfig(Drivers\KeccakStrictDriver::class),
    ],

    CurrencyEnum::POLYGON->value => [
        new DriverConfig(Drivers\KeccakStrictDriver::class),
    ],

    CurrencyEnum::BNB->value => [
        new DriverConfig(Drivers\KeccakStrictDriver::class),
    ],

    CurrencyEnum::SOLANA->value => [
        new DriverConfig(Drivers\SolanaDriver::class),
    ],

    CurrencyEnum::SUI->value => [
        new DriverConfig(Drivers\SuiDriver::class),
    ],
];
