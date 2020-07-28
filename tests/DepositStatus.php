<?php


namespace Directa24\Directa24Test;

class DepositStatus extends GenericTest
{

    public function testGetPaymentMethods()
    {
        $data = $this->directa24->depositStatus(300533668);
        $this->assertEquals('CANCELLED', $data->status);
    }
}
