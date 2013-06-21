<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace Tests\DarkSide;

use DarkSide\MyService;
use DarkSide\Broker;

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

    public function testCallFail()
    {
        $this->assertNull($this->broker->useService(new \DarkSide\ConcreteThing()));
    }

}