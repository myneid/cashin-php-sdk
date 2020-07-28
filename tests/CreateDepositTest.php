<?php

namespace Directa24\Directa24Test;

use Directa24\model\Address;
use Directa24\model\BankAccount;
use Directa24\model\Payer;
use Directa24\request\CreateDepositRequest;

class CreateDepositTest extends GenericTest
{

    private $create_deposit_request;

    public function __construct()
    {
        $address = new Address();
        $address->street = "Rua Dr. Franco Ribeiro, 52";
        $address->city = "Rio Branco";
        $address->state = "AC";
        $address->zip_code = "11600-234";


        $payer = new Payer();
        $payer->id = "4-9934519";
        $payer->address = $address;
        $payer->document = "72697858059";
        $payer->document_type = "CPF";
        $payer->email = "juanCarlos@hotmail.com";
        $payer->first_name = "Ricardo";
        $payer->last_name = "Carlos";
        $payer->phone = "+598 99730878";


        $bank_account = new BankAccount();
        $bank_account->bank_code = "01";
        $bank_account->account_number = "3242342";
        $bank_account->account_type = "SAVING";
        $bank_account->beneficiary = "Ricardo Carlos";
        $bank_account->branch = "12";


        $create_deposit_request = new CreateDepositRequest();
        $create_deposit_request->invoice_id = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8 / strlen($x)))), 1, 8);
        $create_deposit_request->amount = 100;
        $create_deposit_request->country = "BR";
        $create_deposit_request->currency = "BRL";
        $create_deposit_request->language = "en";
        $create_deposit_request->payer = $payer;
        $create_deposit_request->payment_method = "BB";
        $create_deposit_request->bank_account = $bank_account;
        $create_deposit_request->early_release = false;
        $create_deposit_request->fee_on_payer = false;
        $create_deposit_request->surcharge_on_payer = false;
        $create_deposit_request->bonus_amount = 0.1;
        $create_deposit_request->bonus_relative = false;
        $create_deposit_request->strikethrough_price = 0.1;
        $create_deposit_request->description = "Test";
        $create_deposit_request->client_ip = "186.51.171.84";
        $create_deposit_request->device_id = "00000000-00000000-01234567-89ABCDEF";
        $create_deposit_request->back_url = "https://yoursite.com/deposit/108/cancel";
        $create_deposit_request->success_url = "https://yoursite.com/deposit/108/confirm";
        $create_deposit_request->error_url = "https://yoursite.com/deposit/108/error";
        $create_deposit_request->notification_url = "https://yoursite.com/ipn";
        $create_deposit_request->test = true;
        $create_deposit_request->mobile = false;
        $this->create_deposit_request = $create_deposit_request;
        parent::__construct();
    }

    /**
     * Test that true does in fact equal true
     */
    public function testCheckOneShot()
    {
        $data = $this->directa24->createDeposit($this->create_deposit_request);
        $this->assertObjectHasAttribute('checkout_type', $data);
        $this->assertEquals('ONE_SHOT', $data->checkout_type);
    }

    /**
     * Test that true does in fact equal true
     */
    public function testCheckBankTransfer()
    {
        $data = $this->directa24->createDeposit($this->create_deposit_request);
        $this->assertObjectHasAttribute('payment_info', $data);
        $this->assertObjectHasAttribute('type', $data->payment_info);
        $this->assertEquals('BANK_TRANSFER', $data->payment_info->type);
        $this->assertObjectHasAttribute('redirect_url', $data);
    }

    /**
     * Test that true does in fact equal true
     */
    public function testVoucher()
    {
        $this->create_deposit_request->payment_method = 'BL';
        $data = $this->directa24->createDeposit($this->create_deposit_request);
        $this->assertObjectHasAttribute('payment_info', $data);
        $this->assertObjectHasAttribute('type', $data->payment_info);
        $this->assertEquals('VOUCHER', $data->payment_info->type);
        $this->assertObjectHasAttribute('metadata', $data->payment_info);
        $this->assertObjectHasAttribute('qr_code', $data->payment_info->metadata);
    }


    public function testHosted()
    {
        $create_deposit_request = new \Directa24\request\CreateDepositRequest();
        $create_deposit_request->invoice_id = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8/strlen($x)) )),1,8);
        $create_deposit_request->amount = 100;
        $create_deposit_request->country = "BR";
        $create_deposit_request->currency = "BRL";
        $create_deposit_request->language = "en";
        $data = $this->directa24->createDeposit($create_deposit_request);
        $this->assertObjectHasAttribute('checkout_type', $data);
        $this->assertEquals('HOSTED', $data->checkout_type);
        $this->assertObjectHasAttribute('redirect_url', $data);
    }
}
