<?php


namespace Directa24\Directa24Test;


class PaymentMethodsTest extends GenericTest
{
    public function testGetPaymentMethods()
    {
        $data = $this->directa24->paymentMethods('BR');
        foreach ($data as $paymentMethodResponse) {
            $paymentMethodResponse->country;
        }
        $this->assertGreaterThan(0, count($data));
    }
}
