<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace After;

/**
 * MyServer is a ConcreteThing with RMI server capabilities
 */
class MyServer extends ConcreteThing implements RMIServer
{

    use RMIServerImpl;
}