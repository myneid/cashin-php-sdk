<?php


namespace Directa24\Directa24Test;

class DepositStatus extends GenericTest
{

    public function testGetPaymentMethods()
    {
        $data = $this->directa24->refundStatus(168250);
        $this->assertEquals('CANCELLED', $data->status);
    }
}
