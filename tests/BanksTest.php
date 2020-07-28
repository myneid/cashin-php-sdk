<?php


namespace Directa24\Directa24Test;


class BanksTest extends GenericTest
{
    public function testGetPaymentMethods()
    {
        $data = $this->directa24->banks('BR');
        $this->assertGreaterThan(0, count($data));
    }
}
