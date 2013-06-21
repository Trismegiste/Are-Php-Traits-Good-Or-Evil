<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace DarkSide;

/**
 * Broker uses MyService
 */
class Broker
{

    public function useService(ConcreteThing $srv)
    {
        if (in_array('DarkSide\Service', class_uses($srv))) {
            return $srv->getAnswer();
        }
    }

}