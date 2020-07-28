<?php


namespace Directa24\request;

class CreateRefundRequest
{
    public $deposit_id;

    public $merchant_invoice_id;

    public $amount;

    public $bank_account;

    public $comments;

    public $notification_url;
}
