<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace Tests\After;

use After\MyServer;

/**
 * MyServerTest tests MyServer
 */
class MyServerTest extends \PHPUnit_Framework_TestCase
{

    protected $server;

    protected function setUp()
    {
        $this->server = new MyServer();
    }

    public function testCall()
    {
        $this->server->newClient(42);
    }

}