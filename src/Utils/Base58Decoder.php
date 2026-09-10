<?php

declare(strict_types=1);

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Utils;

use function bcadd;
use function bccomp;
use function bcdiv;
use function bcmod;
use function bcmul;
use function strlen;
use function strpos;
use function strrev;
use function substr;

class Base58Decoder
{
    public static function decode(string $base58, string $alphabet): string
    {
        $origbase58 = $base58;

        $return = "0";
        for ($i = 0, $iMax = strlen($base58); $i < $iMax; $i++)
        {
            $current = (string)strpos($alphabet, $base58[$i]);
            $return  = bcmul($return, "58", 0);
            $return  = bcadd($return, $current, 0);
        }

        $return = HexDecoder::encode($return);

        //leading zeros
        for ($i = 0; $i < strlen($origbase58) && $origbase58[$i] === $alphabet[0]; $i++)
        {
            $return = "00" . $return;
        }

        if (strlen($return) % 2 !== 0)
        {
            $return = "0" . $return;
        }

        return $return;
    }

    public static function encode(string $hex, string $alphabet): string
    {
        $orighex = $hex;

        $hex    = HexDecoder::decode($hex);
        $return = "";
        while (bccomp($hex, "0") === 1)
        {
            $dv     = bcdiv($hex, "58", 0);
            $rem    = (int) bcmod($hex, "58");
            $hex    = $dv;
            $return .= $alphabet[$rem];
        }
        $return = strrev($return);

        //leading zeros
        for ($i = 0; $i < strlen($orighex) && substr($orighex, $i, 2) === "00"; $i += 2)
        {
            $return = "1" . $return;
        }

        return $return;
    }
}
