<?php


namespace Directa24\response;

class DepositStatusResponse
{
    public $user_id;

    public $deposit_id;

    public $invoice_id;

    public $country;

    public $currency;

    public $usd_amount;

    public $local_amount;

    public $bonus_amount;

    public $bonus_relative;

    public $payment_method;

    public $payment_type;

    public $status;

    public $card_detail;
}
