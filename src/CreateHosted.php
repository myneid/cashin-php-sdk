<?php

namespace Directa24;

require_once "../vendor/autoload.php";

use Directa24\exception\Directa24Exception;
use Directa24\request\CreateDepositRequest;
use Directa24\util\Helpers;

$create_deposit_request = new CreateDepositRequest();
$create_deposit_request->invoice_id = Helpers::generateRandomString(8);
$create_deposit_request->amount = 100;
$create_deposit_request->country = "BR";
$create_deposit_request->currency = "BRL";
$create_deposit_request->language = "en";



$directa24 = Directa24::getInstance("fUEhPEKrUt", "lTMZgRTakW", "wSHTfsMMdNskTppilncuZPEklgLmdUAOg");

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