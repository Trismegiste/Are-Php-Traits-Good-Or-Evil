<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace Before;

/**
 * MyServer is a ConcreteThing with RMI server capabilities
 */
class MyServer extends ConcreteThing implements RMIServer
{

    protected $wrapped;

    public function __construct(RMIServer $rmi)
    {
        $this->wrapped = $rmi;
    }

    public function newClient($credentials)
    {
        return $this->wrapped->newClient($credentials);
    }

}