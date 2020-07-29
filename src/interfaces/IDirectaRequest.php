<?php

namespace Directa24\interfaces;

use Directa24\exception\Directa24Exception;
use Directa24\request\CreateRefundRequest;
use Directa24\response\CreateDepositResponse;
use Directa24\response\BanksResponse;
use Directa24\response\CurrencyExchangeResponse;
use Directa24\response\DepositStatusResponse;
use Directa24\response\PaymentMethodResponse;
use Directa24\response\RefundStatus;

interface IDirectaRequest
{
    /**
     * Creates a deposit.
     *
     * @param $create_deposit_request $createDepositRequest Deposit Info
     * @return CreateDepositResponse object
     * @throws Directa24Exception if underlying service fails
     */
    public function createDeposit($create_deposit_request);

    /**
     * Returns a deposit status.
     *
     * @param int $id
     * @return DepositStatusResponse object
     * @throws Directa24Exception if underlying service fails
     */
    public function depositStatus($id);

    /**
     * Returns payment methods.
     *
     * @param string $country_code Country code
     * @return PaymentMethodResponse[]
     * @throws Directa24Exception if underlying service fails
     */
    public function paymentMethods($country_code);


    /**
     * Returns currency exchange.
     *
     * @param string $country Country code
     * @param int $amount
     * @return CurrencyExchangeResponse object
     * @throws Directa24Exception if underlying service fails
     */
    public function currencyExchange($country, $amount);

    /**
     * Generate Refund. Returns refund_id
     *
     * @param CreateRefundRequest $create_refund_request
     * @return int $refund_id
     * @throws Directa24Exception if underlying service fails
     */
    public function refund($create_refund_request);

    /**
     * Returns refund status.
     *
     * @param int $id_refund
     * @return RefundStatus object
     * @throws Directa24Exception if underlying service fails
     */
    public function refundStatus($id_refund);

    /**
     * Returns banks.
     *
     * @param string $country_code Country code
     * @return BanksResponse[] object
     * @throws Directa24Exception if underlying service fails
     */
    public function banks($country_code);
}
