<?php


namespace Directa24\Directa24Test;

class CurrencyExchangeTest extends GenericTest
{
    public function testCurrencyExchange()
    {
        $data = $this->directa24->currencyExchange('BR', 100);
        $this->assertObjectHasAttribute('converted_amount', $data);
    }
}
