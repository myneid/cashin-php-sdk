<?php

namespace Directa24\util;

class Helpers
{
    private static $DATE_TIME_FORMATTER = "Y-m-d\TH:i:s\Z";

    public static $BEARER_AUTHORIZATION_SCHEME = "Bearer ";

    public static $D24_AUTHORIZATION_SCHEME = "D24 ";

    public static function getCurrentDate()
    {
        date_default_timezone_set('UTC');
        return date(self::$DATE_TIME_FORMATTER);
    }

    public static function buildApiKeySignature($apiKey)
    {
        return self::$BEARER_AUTHORIZATION_SCHEME . $apiKey;
    }

    public static function buildDepositKeySignature($secretKey, $date, $depositKey, $payload = '')
    {
        $payload = empty($payload) ? '' : json_encode($payload);
        return self::$D24_AUTHORIZATION_SCHEME . hash_hmac('sha256', $date . $depositKey . $payload, $secretKey);
    }

    public static function generateRandomString($length)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }


}