<?php


namespace Directa24\client;


use Directa24\util\Curl;
use Directa24\interfaces\IDirectaRequest;
use Directa24\util\Helpers;
use Directa24\exception\Directa24Exception;

class Directa24Client implements IDirectaRequest
{

    private static $DEPOSIT_V3_PATH = "/v3/deposits/";

    private static $PAYMENT_METHODS_V3_PATH = "/v3/payment_methods";

    private static $BANKS_V3_PATH = "/v3/banks";

    private static $CURRENCY_EXCHANGE_V3_PATH = "/v3/exchange_rates";

    private static $REFUND_V3_PATH = "/v3/refunds/";

    private $deposit_key;

    private $api_key;

    private $secret_key;

    private $base_url;

    private $httpClient;

    private $idempotency_key;

    public function setBaseUrl($url){
        $this->base_url = $url;
    }

    public function __construct($deposit_key, $apiKey, $secretKey, $baseUrl, $idempotency_key)
    {
        $this->deposit_key = $deposit_key;
        $this->api_key = $apiKey;
        $this->secret_key = $secretKey;
        $this->base_url = $baseUrl;
        $this->idempotency_key = $idempotency_key;
    }


    public function createDeposit($createDepositRequest)
    {
        $createDepositArray = json_decode(mb_convert_encoding(json_encode($createDepositRequest), 'UTF-8', 'ISO-8859-1'), true);
        $this->httpClient = Curl::post($this->base_url . self::$DEPOSIT_V3_PATH, $createDepositArray);
        $this->httpClient->httpHeader('X-Date', Helpers::getCurrentDate());
        $this->httpClient->httpHeader('Authorization', Helpers::buildDepositKeySignature($this->secret_key, Helpers::getCurrentDate(), $this->deposit_key, $createDepositArray));
        $this->httpClient->httpHeader('X-Login', $this->deposit_key);
        if (!empty($this->idempotency_key)) {
            $this->httpClient->httpHeader('X-Idempotency-Key', $this->idempotency_key);
        }
        return $this->makeRequest();
    }

    public function depositStatus($id)
    {
        $this->httpClient = Curl::get($this->base_url . self::$DEPOSIT_V3_PATH . $id);
        $this->httpClient->httpHeader('X-Date', Helpers::getCurrentDate());
        $this->httpClient->httpHeader('Authorization', Helpers::buildDepositKeySignature($this->secret_key, Helpers::getCurrentDate(), $this->deposit_key));
        $this->httpClient->httpHeader('X-Login', $this->deposit_key);
        return $this->makeRequest();
    }

    public function paymentMethods($country)
    {
        $countryArray = array('country' => $country);
        $this->httpClient = Curl::get($this->base_url . self::$PAYMENT_METHODS_V3_PATH, $countryArray);
        $this->httpClient->httpHeader('Authorization', Helpers::buildApiKeySignature($this->api_key));
        return $this->makeRequest();
    }


    public function currencyExchange($country, $amount)
    {
        $exchangeArray = array('country' => $country, 'amount' => $amount);
        $this->httpClient = Curl::get($this->base_url . self::$CURRENCY_EXCHANGE_V3_PATH, $exchangeArray);
        $this->httpClient->httpHeader('Authorization', Helpers::buildApiKeySignature($this->api_key));
        return $this->makeRequest();
    }


    public function refund($create_refund_request)
    {
        $create_refund_request_array = json_decode(json_encode($create_refund_request), true);
        $this->httpClient = Curl::post($this->base_url . self::$REFUND_V3_PATH, $create_refund_request_array);
        $this->httpClient->httpHeader('X-Date', Helpers::getCurrentDate());
        $this->httpClient->httpHeader('Authorization', Helpers::buildDepositKeySignature($this->secret_key, Helpers::getCurrentDate(), $this->deposit_key, $create_refund_request_array));
        $this->httpClient->httpHeader('X-Login', $this->deposit_key);
        if (!empty($this->idempotency_key)) {
            $this->httpClient->httpHeader('X-Idempotency-Key', $this->idempotency_key);
        }
        return $this->makeRequest()->refund_id;
    }

    public function refundStatus($refund_id)
    {
        $this->httpClient = Curl::get($this->base_url . self::$REFUND_V3_PATH . $refund_id);
        $this->httpClient->httpHeader('X-Date', Helpers::getCurrentDate());
        $this->httpClient->httpHeader('Authorization', Helpers::buildDepositKeySignature($this->secret_key, Helpers::getCurrentDate(), $this->deposit_key));
        $this->httpClient->httpHeader('X-Login', $this->deposit_key);
        return $this->makeRequest();
    }

    public function banks($country)
    {
        $countryArray = array('country' => $country);
        $this->httpClient = Curl::get($this->base_url . self::$BANKS_V3_PATH, $countryArray);
        $this->httpClient->httpHeader('Authorization', Helpers::buildApiKeySignature($this->api_key));
        return $this->makeRequest();
    }


    private function makeRequest()
    {
        $this->httpClient->httpHeader('Content-type', 'application/json');
        try {
            $response = $this->httpClient->call();
            if ($response->result !== false) {
                return $response->result;
            } else {
                throw new Directa24Exception($response->error, $response->error_code);
            }
        } catch (\Exception $e) {
            throw new Directa24Exception($e->getMessage(), $e->getCode());
        }
    }

}
