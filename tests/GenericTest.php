<?php


namespace Directa24\Directa24Test;


use Directa24\Directa24;
use Directa24\Directa24Sandbox;

class GenericTest extends \PHPUnit\Framework\TestCase
{

    protected $directa24;


    public function __construct()
    {
        $this->directa24 = Directa24::getInstance("fUEhPEKrUt", "lTMZgRTakW", "wSHTfsMMdNskTppilncuZPEklgLmdUAOg");
        parent::__construct();
    }

    public function testTrueIsTrue(){
        $this->assertTrue(true);
    }
}
