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

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Property injection is not defined
     */
    public function testPropInjection()
    {
        $this->object->injection = 666;
        $this->object->getInjection();
    }

    public function testMotherPropInSubclass()
    {
        $obj = new Daughter();
        $obj->setAnswer(42);
        $this->assertEquals(42, $obj->getAnswer());
    }

    public function testDaughterPropInSubclass()
    {
        $obj = new Daughter();
        $obj->setData(666);
        $this->assertEquals(666, $obj->getData());
    }

}

class Container
{

    use \Trismegiste\Magic\GetterSetter;

    protected $answer;

}

class Daughter extends Container
{

    protected $data;

}