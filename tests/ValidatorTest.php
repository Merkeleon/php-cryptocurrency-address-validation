<?php

declare(strict_types=1);

namespace Tests;

use Merkeleon\PhpCryptocurrencyAddressValidation\Enums\CurrencyEnum;
use Merkeleon\PhpCryptocurrencyAddressValidation\Validator;

/**
 * @coversDefaultClass \Merkeleon\PhpCryptocurrencyAddressValidation\Validator
 */
class ValidatorTest extends TestCase
{
    /**
     * @covers ::isValid
     * @dataProvider currencyAddressProvider
     *
     * @param CurrencyEnum $currency
     * @param string       $net
     * @param bool         $expected
     * @param string       $address
     *
     * @return void
     */
    public function test_currency_validator(CurrencyEnum $currency, string $net, bool $expected, string $address): void
    {
        $validator = new Validator($currency->value, $net === 'mainnet');

        $this->assertEquals(
            $expected,
            $validator->isValid($address),
            "[{$currency->value}] address [{$address}] is invalid"
        );
    }

    public function currencyAddressProvider(): array
    {
        return [
            'Beacon #1' => [CurrencyEnum::BEACON, 'mainnet', true, 'bnb1fnd0k5l4p3ck2j9x9dp36chk059w977pszdgdz'],
            'Beacon #2' => [CurrencyEnum::BEACON, 'mainnet', true, 'bnb1xd8cn4w7q4hm4fc9a68xtpx22kqenju7ea8d3v'],
            'Beacon #3' => [CurrencyEnum::BEACON, 'testnet', true, 'tbnb1nuxna8asq69jf05cldcxpx9ee0m7drd9qz3aru'],
            'Beacon #4' => [CurrencyEnum::BEACON, 'mainnet', false, 'bnb1nuxna8asq69jf05cldcxpx9ee0m7drd9qz3aru'],
            'Beacon #5' => [CurrencyEnum::BEACON, 'testnet', false, 'bnb1nuxna8asq69jf05cldcxpx9ee0m7drd9qz3aru'],
            //
            'BitcoinCash #1' => [CurrencyEnum::BITCOIN_CASH, 'mainnet', true, 'bitcoincash:qp009ldhprp75mgn4kgaw8jvrpadnvg8qst37j42kx'],
            'BitcoinCash #2' => [CurrencyEnum::BITCOIN_CASH, 'mainnet', true, 'bitcoincash:qz7032ylhvxmndkx438pd8kjd7k7zcqxzsf26q0lvr'],
            'BitcoinCash #3' => [CurrencyEnum::BITCOIN_CASH, 'mainnet', true, '32uLhn19ZasD5bsVhLdDthhM37JhJHiEE2'],
            'BitcoinCash #4' => [CurrencyEnum::BITCOIN_CASH, 'mainnet', true, 'qz52zsruu43sq7ed0srym3g0ktpyjkdkxcm949pl2z'],
            'BitcoinCash #5' => [CurrencyEnum::BITCOIN_CASH, 'mainnet', true, 'qpf8eq7ygvhqjwydk9n29f6nyc8rcjhlwcuwngn6xk'],
            'BitcoinCash #6' => [CurrencyEnum::BITCOIN_CASH, 'testnet', true, 'bchtest:qp2vjh349lcd22hu0hv6hv9d0pwlk43f6u04d5jk36'],
            'BitcoinCash #7' => [CurrencyEnum::BITCOIN_CASH, 'testnet', true, 'qp2vjh349lcd22hu0hv6hv9d0pwlk43f6u04d5jk36'],
            'BitcoinCash #8' => [CurrencyEnum::BITCOIN_CASH, 'testnet', false, '1KADKOasjxpNKzbfcKjnigLYWjEFPcMXqf'],
            'BitcoinCash #9' => [CurrencyEnum::BITCOIN_CASH, 'mainnet', true, 'qpnxwdu09eq4gqxv0ala37yj5evmmakf5vpp770edu'],
            'BitcoinCash #10' => [CurrencyEnum::BITCOIN_CASH, 'mainnet', true, 'bitcoincash:qpnxwdu09eq4gqxv0ala37yj5evmmakf5vpp770edu'],
            'BitcoinCash #11' => [CurrencyEnum::BITCOIN_CASH, 'testnet', false, 'bchtest:qpnxwdu09eq4gqxv0ala37yj5evmmakf5vpp770edu'],
            'BitcoinCash #12' => [CurrencyEnum::BITCOIN_CASH, 'testnet', false, 'bchreg:qpnxwdu09eq4gqxv0ala37yj5evmmakf5vpp770edu'],
            'BitcoinCash #13' => [CurrencyEnum::BITCOIN_CASH, 'mainnet', true, 'bitcoincash:pwqwzrf7z06m7nn58tkdjyxqfewanlhyrpxysack85xvf3mt0rv02l9dxc5uf'],
            'BitcoinCash #14' => [CurrencyEnum::BITCOIN_CASH, 'mainnet', true, 'bitcoincash:qr6m7j9njldwwzlg9v7v53unlr4jkmx6eylep8ekg2'],
            //
            'Bitcoin #1' => [CurrencyEnum::BITCOIN, 'mainnet', true, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2'],
            'Bitcoin #2' => [CurrencyEnum::BITCOIN, 'mainnet', true, 'bc1q6v096h88xmpl662af0nc7wd3vta56zv6pyccl8'],
            'Bitcoin #3' => [CurrencyEnum::BITCOIN, 'testnet', true, 'tb1q27dglj7x4l34mj7j2x7e6fqsexk6vf8kew6qm0'],
            'Bitcoin #4' => [CurrencyEnum::BITCOIN, 'testnet', false, 'tb1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq'],
            'Bitcoin #5' => [CurrencyEnum::BITCOIN, 'mainnet', false, 'tb1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq'],
            'Bitcoin #6' => [CurrencyEnum::BITCOIN, 'testnet', false, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2'],
            'Bitcoin #7' => [CurrencyEnum::BITCOIN, 'testnet', false, 'bc1q6v096h88xmpl662af0nc7wd3vta56zv6pyccl8'],
            'Bitcoin #8' => [CurrencyEnum::BITCOIN, 'mainnet', true, 'BC1QL2725QLXHGWQ7F7XLJ8363FJCUF25XZ35SWRU5'],
            'Bitcoin #9' => [CurrencyEnum::BITCOIN, 'mainnet', true, 'bc1p5gyty9x2lrk65yndaeh242zm6xklgrv9nze9477dg0kyv6yvfljq0lqjkh'],
            //
            'Cardano #1' => [CurrencyEnum::CARDANO, 'mainnet', true, 'addr1v9ywm0h3r8cnxrs04gfy7c3s2j44utjyvn5ldjdca0c2ltccgqdes'],
            'Cardano #2' => [CurrencyEnum::CARDANO, 'mainnet', false, 'stake1u9f9v0z5zzlldgx58n8tklphu8mf7h4jvp2j2gddluemnssjfnkzz'],
            'Cardano #3' => [CurrencyEnum::CARDANO, 'mainnet', true, 'addr1qxy3w62dupy9pzmpdfzxz4k240w5vawyagl5m9djqquyymrtm3grn7gpnjh7rwh2dy62hk8639lt6kzn32yxq960usnq9pexvt'],
            'Cardano #4' => [CurrencyEnum::CARDANO, 'mainnet', true, 'Ae2tdPwUPEYwNguM7TB3dMnZMfZxn1pjGHyGdjaF4mFqZF9L3bj6cdhiH8t'],
            'Cardano #5' => [CurrencyEnum::CARDANO, 'mainnet', true, 'DdzFFzCqrht2KYLcX8Vu53urCG52NxpgrGQvP9Mcp15Q8BkB9df9GndFDBRjoWTPuNkLW3yeQiFVet1KA7mraEkJ84AK2RwcEh3khs12'],
            'Cardano #6' => [CurrencyEnum::CARDANO, 'testnet', true, '37btjrVyb4KBbrmcxh3qQzswqDB4SCU8L68vYBJshaeYQ8rHVBfrAfuXZNyFHtR8QXUKR4CtytMyX4DwhsPYKKgFSpq8f5KxNz2s6Guqr6c6LzcHck'],
            'Cardano #7' => [CurrencyEnum::CARDANO, 'testnet', true, '2cWKMJemoBaipAW1NGegM2qWevSgpL9baiizayY4NnTBvxRGyppr2uym7F9eEtRLehFek'],
            'Cardano #8' => [CurrencyEnum::CARDANO, 'testnet', true, 'addr_test1qzfst6x8f4r47vm4qfeuj7g8r5pgkjnv5cuzjk94u8p7sd3gtlpjssk2fy95k4z5lr48tu48fcqstnzte44d8f8v8vhs9pwu4x'],
            //
            'Dashcoin #1' => [CurrencyEnum::DASHCOIN, 'mainnet', true, 'XpESxaUmonkq8RaLLp46Brx2K39ggQe226'],
            'Dashcoin #2' => [CurrencyEnum::DASHCOIN, 'mainnet', true, 'XmZQkfLtk3xLtbBMenTdaZMxsUBYAsRz1o'],
            'Dashcoin #3' => [CurrencyEnum::DASHCOIN, 'testnet', true, 'yNpxAuCGxLkDmVRY12m4qEWx1ttgTczSMJ'],
            'Dashcoin #4' => [CurrencyEnum::DASHCOIN, 'testnet', true, 'yi7GRZLiUGrJfX2aNDQ3v7pGSCTrnLa87o'],
            //
            'Dogecoin #1' => [CurrencyEnum::DOGECOIN, 'mainnet', true, 'DFrGqzk4ZnTcK1gYtxZ9QDJsDiVM8v8gwV'],
            'Dogecoin #2' => [CurrencyEnum::DOGECOIN, 'mainnet', true, 'DMzanBYjj3yYHtCcnEucn7H8LHNY9fARB8'],
            'Dogecoin #3' => [CurrencyEnum::DOGECOIN, 'testnet', true, 'mketxxXxaBeH7AhCBMatdH5ATVad2XHQdj'],
            'Dogecoin #4' => [CurrencyEnum::DOGECOIN, 'testnet', false, 'n3TZFrdPvwGqfPC7vBb8PGgbFwc1Cnxq9h'],
            'Dogecoin #5' => [CurrencyEnum::DOGECOIN, 'testnet', true, 'nd5N1KW1waCicK1vqfwtTcBSbQCHBLv2Um'],
            'Dogecoin #6' => [CurrencyEnum::DOGECOIN, 'testnet', false, 'DFundMr7W8PjB6ZmVwGv1L1WtZ2X3m3KgQ'],
            'Dogecoin #7' => [CurrencyEnum::DOGECOIN, 'mainnet', false, 'n3TZFrdPvwGqfPC7vBb8PGgbFwc1Cnxq9h'],
            //
            'Ethereum #1' => [CurrencyEnum::ETHEREUM, 'mainnet', true, '0xe80b351948D0b87EE6A53e057A91467d54468D91'],
            'Ethereum #2' => [CurrencyEnum::ETHEREUM, 'testnet', true, '0x799aD3Ff7Ef43DfD1473F9b8a8C4237c22D8113F'],
            'Ethereum #3' => [CurrencyEnum::ETHEREUM, 'mainnet', false, '0xe80b351948d0b87ee6a53e057a91467d54468d91'],
            'Ethereum #4' => [CurrencyEnum::ETHEREUM, 'testnet', false, '0x799ad3ff7ef43dfd1473f9b8a8c4237c22d8113f'],
            //
            'Litecoin #1' => [CurrencyEnum::LITECOIN, 'mainnet', true, 'MF5yqnMuNoiCiCXbZft7iFgLK5BPG5QKbE'],
            'Litecoin #2' => [CurrencyEnum::LITECOIN, 'mainnet', false, '1QLbGuc3WGKKKpLs4pBp9H6jiQ2MgPkXRp'],
            'Litecoin #3' => [CurrencyEnum::LITECOIN, 'mainnet', true, '3CDJNfdWX8m2NwuGUV3nhXHXEeLygMXoAj'],
            'Litecoin #4' => [CurrencyEnum::LITECOIN, 'mainnet', true, 'LbTjMGN7gELw4KbeyQf6cTCq859hD18guE'],
            'Litecoin #5' => [CurrencyEnum::LITECOIN, 'mainnet', true, 'MK9xC9sbktt6DHMF6XwA3eZPJ2Vx32AXFT'],
            'Litecoin #6' => [CurrencyEnum::LITECOIN, 'testnet', true, 'mpQA36uSXDGxySjknqHFVMdsLPgPnbm7ku'],
            'Litecoin #7' => [CurrencyEnum::LITECOIN, 'mainnet', true, 'ltc1qf6wcq8kc0unt3wuaszlkms3zkuerxlfaz07zmj'],
            //
            'Ripple #1' => [CurrencyEnum::RIPPLE, 'mainnet', true, 'r4dgY6Mzob3NVq8CFYdEiPnXKboRScsXRu'],
            //
            'Tron #1' => [CurrencyEnum::TRON, 'mainnet', true, 'TC9fKEGcBTfmvXKXLHq5MJDC8P7dhZQM92'],
            'Tron #2' => [CurrencyEnum::TRON, 'testnet', true, 'TRALQkt1v9MjUVn3gT7csfpodJDmnC6q8s'],
            //
            'Zcash #1' => [CurrencyEnum::ZCASH, 'mainnet', true, 't1YQV51DKzKP63xJcynXuRfryMjfmgTJ7Jc'],
            'Zcash #2' => [CurrencyEnum::ZCASH, 'mainnet', true, 't1VJhyyvbi63Cu6nEVVgNHSCokDRa3repZB'],
            'Zcash #3' => [CurrencyEnum::ZCASH, 'testnet', true, 't1VJhyyvbi63Cu6nEVVgNHSCokDRa3repZB'],
            //
            'EOS #1' => [CurrencyEnum::EOS, 'mainnet', true, 'atticlabeosb'],
            'EOS #2' => [CurrencyEnum::EOS, 'mainnet', true, 'bitfinexeos1'],
        ];
    }
}
