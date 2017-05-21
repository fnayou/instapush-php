<?php
/**
 * This file is part of the fnayou/instapush-php project.
 *
 * Copyright (c) 2017. Aymen FNAYOU <fnayou.aymen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fnayou\InstapushPHP\Test\Model;

use Fnayou\InstapushPHP\Model\Event;
use Fnayou\InstapushPHP\Model\FromArrayInterface;
use Fnayou\InstapushPHP\Test\FakeParameters;

/**
 * Class EventTest.
 */
final class EventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test implement FromArrayInterface.
     */
    public function testImplementFromArrayInterface()
    {
        $reflection = new \ReflectionClass(Event::class);

        $this->assertTrue($reflection->implementsInterface(FromArrayInterface::class));
    }

    /**
     * test constructor.
     */
    public function testConstructor()
    {
        $classname = Event::class;

        $eventParameters = FakeParameters::getEventParameters();

        $mock = $this->getMockBuilder($classname)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('setTitle')
            ->with(
                $this->equalTo($eventParameters['title'])
            )
            ->will($this->returnSelf());

        $mock->expects($this->once())
            ->method('setMessage')
            ->with(
                $this->equalTo($eventParameters['message'])
            )
            ->will($this->returnSelf());

        $mock->expects($this->once())
            ->method('setTrackers')
            ->with(
                $this->equalTo($eventParameters['trackers'])
            )
            ->will($this->returnSelf());

        // now call the constructor
        $reflectedClass = new \ReflectionClass($classname);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke(
            $mock,
            $eventParameters['title'],
            $eventParameters['message'],
            $eventParameters['trackers']
        );
    }

    /**
     * test static method fromArray.
     */
    public function testStaticFromArray()
    {
        $eventParameters = FakeParameters::getEventParameters();

        $event = Event::fromArray($eventParameters);

        $this->assertInstanceOf(Event::class, $event);
        $this->assertSame($eventParameters['title'], $event->getTitle());
        $this->assertSame($eventParameters['message'], $event->getMessage());
        $this->assertSame($eventParameters['trackers'], $event->getTrackers());
    }

    /**
     * test method toArray.
     */
    public function testToArray()
    {
        $eventParameters = FakeParameters::getEventParameters();

        $event = Event::fromArray($eventParameters);

        $this->assertInstanceOf(Event::class, $event);
        $this->assertSame($eventParameters, $event->toArray());
    }
}
