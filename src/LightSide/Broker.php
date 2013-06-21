<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace LightSide;

/**
 * Broker uses MyService
 */
class Broker
{

    public function useService(Service $srv)
    {
        return $srv->getAnswer();
    }

}