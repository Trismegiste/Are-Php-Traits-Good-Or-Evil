<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace Tests\Before;

use Before\MyServer;
use Before\RMIServerImpl;

/**
 * MyServerTest tests MyServer
 */
class MyServerTest extends \PHPUnit_Framework_TestCase
{

    protected $server;

    protected function setUp()
    {
        $this->server = new MyServer(new RMIServerImpl());
    }

    public function testCall()
    {
        $this->server->newClient(42);
    }

}