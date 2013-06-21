<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace Tests\Trismegiste\Observer;

/**
 * SplSubjectImplTest tests the SplSubjectImpl trait
 */
class SplSubjectImplTest extends \PHPUnit_Framework_TestCase
{

    protected $subject;
    protected $observer;

    protected function setUp()
    {
        $this->observer = $this->getMock('SplObserver');
        $this->subject = new SubjectExample();
    }

    public function testSubscribe()
    {
        $this->subject->attach($this->observer);
        $this->observer
                ->expects($this->once())
                ->method('update')
                ->with($this->subject);
        // notify observer
        $this->subject->notify();
    }

}


