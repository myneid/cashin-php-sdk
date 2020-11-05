<?php

namespace Directa24;

require_once "../vendor/autoload.php";

use Directa24\model\Address;
use Directa24\model\Payer;
use Directa24\model\BankAccount;
use Directa24\request\CreateDepositRequest;
use Directa24\util\Helpers;

$address = new Address();
$address->street = "Rua Dr. Franco Ribeiro, 52";
$address->city = "Rio Branco";
$address->state = "AC";
$address->zip_code = "11600-234";


$payer = new  Payer();
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
$create_deposit_request->invoice_id = Helpers::generateRandomString(8);
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


$directa24 = Directa24::getInstance("fUEhPEKrUt", "lTMZgRTakW", "wSHTfsMMdNskTppilncuZPEklgLmdUAOg");

try {
    $response = $directa24->createDeposit($create_deposit_request);


    if ($response->checkout_type === 'ONE_SHOT') {
        $payment_info = $response->payment_info;

        if ($payment_info->type === 'CREDIT_CARD') {
            header('Location: ' . $response->redirect_url);
        }

        // Referenced transfer
        if ($payment_info->type === 'BANK_TRANSFER') {
            header('Location: ' . $response->redirect_url);
        }

        // Bank deposit
        if ($payment_info->type === 'BANK_DEPOSIT') {
            echo '<pre>';
            print_r($payment_info->metadata);
            echo '</pre>';
        }

        // Several types of payment methods: Boleto, Picpay, Oxxo
        if ($payment_info->type === 'VOUCHER') {
            $metadata = $payment_info->metada;
            if (isset($metadata->qr_code)) {
                echo '<img src="' . $metadata->qr_code . '"/>';
            } else if (isset($metadata->digital_line) || isset($metadata->barcode)) {
                echo '<pre>';
                print_r($metadata);
                echo '</pre>';
            }
        }
    }

} catch (\Directa24Exception $ex) {
    echo $ex;
}