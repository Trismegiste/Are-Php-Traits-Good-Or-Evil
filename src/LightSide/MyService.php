<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace LightSide;

/**
 * MyService is specialized service
 */
class MyService extends ConcreteThing implements Service
{

    use ServiceImpl;
}