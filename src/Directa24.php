<?php


namespace Directa24;

use Directa24\client\Directa24Client;
use Directa24\exception\Directa24Exception;
use Directa24\interfaces\IDirectaRequests;
use Directa24\request\CreateDepositRequest;
use Directa24\request\CreateDepositResponse;

class Directa24 implements IDirectaRequests
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

    public function createDeposit($createDepositRequest)
    {
        self::$directa_24_client->createDeposit($createDepositRequest);
    }


    public function depositStatus($id)
    {
        return $this->directa_24_client->depositStatus($id);
    }


    public function paymentMethods($country_code)
    {
        return $this->directa_24_client->paymentMethods($country_code);
    }


    public function currencyExchange($country, $amount)
    {
        return $this->directa_24_client->currencyExchange($country, $amount);
    }


    public function refund($create_refund_request)
    {
        return $this->directa_24_client->refund($create_refund_request);
    }


    public function refundStatus($refund_id)
    {
        return $this->directa_24_client->refundStatus($refund_id);
    }


    public function banks($country_code)
    {
        return $this->directa_24_client->banks($country_code);
    }
}
