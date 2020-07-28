<?php


namespace Directa24\request;

class CreateDepositRequest
{
    public $invoice_id;

    public $amount;

    public $currency;

    public $country;

    public $payer;

    public $payment_method;

    public $payment_type;

    public $bank_account;

    public $early_release;

    public $fee_on_payer;

    public $surcharge_on_payer;

    public $bonus_amount;

    public $bonus_relative;

    public $strikethrough_price;

    public $description;

    public $client_ip;

    public $device_id;

    public $language;

    public $back_url;

    public $success_url;

    public $error_url;

    public $notification_url;

    public $logo;

    public $test;

    public $mobile;
}
