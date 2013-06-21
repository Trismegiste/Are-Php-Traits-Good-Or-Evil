<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace Tests\LightSide;

use LightSide\MyService;
use LightSide\Broker;

/**
 * MyServiceTest tests MyServiceTest
 */
class MyServiceTest extends \PHPUnit_Framework_TestCase
{

    protected $broker;

    protected function setUp()
    {
        $this->broker = new Broker();
    }

    public function testCallOk()
    {
        $this->assertEquals(42, $this->broker->useService(new MyService()));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCallFail()
    {
        $this->broker->useService(new \LightSide\ConcreteThing());
    }

}