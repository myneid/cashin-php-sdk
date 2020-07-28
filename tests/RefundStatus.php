<?php


namespace Directa24\Directa24Test;

class RefundStatus extends GenericTest
{

    public function testRefundStatus()
    {
        $data = $this->directa24->refundStatus(168250);
        $this->assertEquals('CANCELLED', $data->status);
    }
}
