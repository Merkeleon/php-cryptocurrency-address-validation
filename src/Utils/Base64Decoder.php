<?php

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Utils;

class Base64Decoder
{
    public function urlDecode(string $data): string
    {
        $base64 = strtr($data, '-_', '+/');

        $base64 = str_pad($base64, ceil(strlen($base64) / 4) * 4, '=', STR_PAD_RIGHT);

        return base64_decode($base64);
    }


    public function urlEncode(string $data): string
    {
        $base64 = base64_encode($data);

        return rtrim(strtr($base64, '+/', '-_'), '=');
    }

    public function isBase64UrlSafe(string $address): bool
    {
        return (bool)preg_match('/^[A-Za-z0-9\-_]+$/', $address);
    }
}