<?php


namespace Directa24;

use Directa24\client\Directa24Client;
use Directa24\request\CreateDepositResponse;

class Directa24
{

    private static $directa_24_client;

    private static $is_production;

    private static $SANDBOX_URL = 'https://api-stg.directa24.com/';

    private static $PRODUCTION_URL = 'https://api.directa24.com/';

    public static function getInstance($x_login, $api_key, $secret_key, $idempotency = '')
    {
        if (!self::$is_production) {
            return self::$directa_24_client = new Directa24Client($x_login, $api_key, $secret_key, self::$SANDBOX_URL, $idempotency);
        } else {
            return self::$directa_24_client = new Directa24Client($x_login, $api_key, $secret_key, self::$PRODUCTION_URL, $idempotency);
        }
    }

    public static function setProductionMode($production_mode)
    {
        self::$is_production = $production_mode;
        if (self::$directa_24_client !== null) {
            if ($production_mode === true) {
                self::$directa_24_client->setBaseUrl(self::$PRODUCTION_URL);
            } else {
                self::$directa_24_client->setBaseUrl(self::$SANDBOX_URL);
            }
        }
    }
}
