# Directa 24 Php client library

[![Latest Version on Packagist][ico-version]][link-packagist]

The official [Directa 24][directa24] Java client library.


### Requirements

- PHP 5.6 or later

## Install

Via Composer

``` bash
$ composer require directa24/cashin
```

## Usage

#### Credentials
Example below exposes sandbox credentials

```php
$x_login = "fUEhPEKrUt";
$api_key = "lTMZgRTakW";
$secret_key = "wSHTfsMMdNskTppilncuZPEklgLmdUAOg";

$directa24 = Directa24::getInstance($$x_login, $api_key, $secret_key);
```
#### Set Production Environment
Before remember to  specify production credentials. See [API docs][api-docs] 
``` php
Directa24::setProductionMode(true);
```

#### Deposit Creations

##### Hosted Creation

``` php
$create_deposit_request = new CreateDepositRequest();
$create_deposit_request->invoice_id = Helpers::generateRandomString(8);
$create_deposit_request->amount = 100;
$create_deposit_request->country = "BR";
$create_deposit_request->currency = "BRL";
$create_deposit_request->language = "en";

try {
    $response = $directa24->createDeposit($create_deposit_request);

    if ($response->checkout_type === 'HOSTED') {
        $redirect_url = $response->redirect_url;
        $response->deposit_id;
        $response->user_id;
        $response->merchant_invoice_id;
        header('Location: '. $redirect_url);
    }
    echo json_encode($response);
} catch (Directa24Exception $ex){
    echo $ex;
}
```

##### One Shot Creation

``` php
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
```

#### Refund Creation
``` php
$bank_account = new BankAccount();
$bank_account->bank_code = "01";
$bank_account->account_number = "3242342";
$bank_account->account_type = "SAVING";
$bank_account->beneficiary = "Ricardo Carlos";
$bank_account->branch = "12";


$create_refund_request = new CreateRefundRequest();
$create_refund_request->deposit_id = 300533180;
$create_refund_request->invoice_id = 'MP_b451645f30b8415ba833d37f3fa21209';
$create_refund_request->amount = 1;
$create_refund_request->bank_account = $bank_account;
$create_refund_request->comments = 'test';
$create_refund_request->notification_url = "https://yoursite.com/deposit/108/confirm";


$directa24 = Directa24::getInstance("fUEhPEKrUt", "lTMZgRTakW", "wSHTfsMMdNskTppilncuZPEklgLmdUAOg");

try {
    $refund_id = $directa24->refund($create_refund_request);
    echo $refund_id;
} catch (\Directa24Exception $ex) {
    echo $ex;
}
```

#### Basic Query status

``` php
$depositId = 300533668;
$directa24->depositStatus($depositId);
```

``` php
$refundId = 168250;
$directa24->refundStatus($refundId);
```


## Documentation

Please see the [API docs][api-docs] for the most up-to-date documentation.



[ico-version]: https://img.shields.io/packagist/v/directa24/cashin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/directa24/cashin
[directa24]: https://directa24.com
[api-docs]: https://docs.directa24.com/deposits-api