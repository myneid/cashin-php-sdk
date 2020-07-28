<?php


namespace Directa24\Directa24Test;


class CreateRefundTest extends GenericTest
{

    private $create_refund_request;

    public function __construct()
    {

        $bank_account = new \Directa24\model\BankAccount();
        $bank_account->bank_code = "01";
        $bank_account->account_number = "3242342";
        $bank_account->account_type = "SAVING";
        $bank_account->beneficiary = "Ricardo Carlos";
        $bank_account->branch = "12";


        $create_refund_request = new \Directa24\request\CreateRefundRequest();
        $create_refund_request->deposit_id = 300532800;
        $create_refund_request->merchant_invoice_id = '1000';
        $create_refund_request->merchant_invoice_id = '84024';
        $create_refund_request->amount = 12;
        $create_refund_request->bank_account = $bank_account;
        $create_refund_request->comments = 'test';
        $create_refund_request->notification_url = "https://yoursite.com/deposit/108/confirm";

        $this->create_refund_request = $create_refund_request;
        parent::__construct();
    }
}
