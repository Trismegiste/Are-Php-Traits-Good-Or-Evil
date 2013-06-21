<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace After;

/**
 * RMIServer is a RMI server
 */
interface RMIServer
{

    public function newClient($credentials);
}


