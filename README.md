# Directa 24 Php client library

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

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

```php
$deposit_key_sbx = "1955f2d";
$api_key_sbx = "eJ3Ldt6Xma";
$secret_key_sbx = "4lph0ns3";

$directa24 = new Directa24Test($deposit_key_sbx, $api_key_sbx, $secret_key_sbx);
```
#### Deposit Status 

``` php

```

#### Create Hosted

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
} catch (Directa24Exception $ex){
    echo $ex;
}
```



## Documentation

Please see the [API docs][api-docs] for the most up-to-date documentation.



[ico-version]: https://img.shields.io/packagist/v/:vendor/:package_name.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/:vendor/:package_name/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/:vendor/:package_name.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/:vendor/:package_name.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/:vendor/:package_name.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/:vendor/:package_name
[link-travis]: https://travis-ci.org/:vendor/:package_name
[link-scrutinizer]: https://scrutinizer-ci.com/g/:vendor/:package_name/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/:vendor/:package_name
[link-downloads]: https://packagist.org/packages/:vendor/:package_name
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
[directa24]: https://directa24.com
[api-docs]: https://docs.directa24.com/deposits-api