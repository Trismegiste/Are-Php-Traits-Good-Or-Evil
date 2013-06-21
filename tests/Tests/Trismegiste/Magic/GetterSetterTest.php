<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace Tests\Trismegiste\Magic;

/**
 * GetterSetterTest tests GetterSetter trait
 */
class GetterSetterTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        $this->object = new Container();
    }

    public function testSetter()
    {
        $this->object->setAnswer(42);
        $this->assertAttributeEquals(42, 'answer', $this->object);
    }

    public function testGetter()
    {
        $this->object->setAnswer(42);
        $this->assertEquals(42, $this->object->getAnswer());
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method unknowMethod is unknown
     */
    public function testFailedCall()
    {
        $this->object->unknowMethod(42);
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Property unknown is not defined
     */
    public function testUnknownProp()
    {
        $this->object->getUnknown();
    }

}


class Container
{

    use \Trismegiste\Magic\GetterSetter;

    protected $answer;

}