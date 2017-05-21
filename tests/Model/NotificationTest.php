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

use Fnayou\InstapushPHP\Model\FromArrayInterface;
use Fnayou\InstapushPHP\Model\Notification;
use Fnayou\InstapushPHP\Test\FakeParameters;

/**
 * Class NotificationTest.
 */
final class NotificationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test implement FromArrayInterface.
     */
    public function testImplementFromArrayInterface()
    {
        $reflection = new \ReflectionClass(Notification::class);

        $this->assertTrue($reflection->implementsInterface(FromArrayInterface::class));
    }

    /**
     * test constructor.
     */
    public function testConstructor()
    {
        $classname = Notification::class;

        $notificationParameters = FakeParameters::getNotificationParameters();

        $mock = $this->getMockBuilder($classname)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('setEvent')
            ->with(
                $this->equalTo($notificationParameters['event'])
            )
            ->will($this->returnSelf());

        $mock->expects($this->once())
            ->method('setTrackers')
            ->with(
                $this->equalTo($notificationParameters['trackers'])
            )
            ->will($this->returnSelf());

        // now call the constructor
        $reflectedClass = new \ReflectionClass($classname);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke(
            $mock,
            $notificationParameters['event'],
            $notificationParameters['trackers']
        );
    }

    /**
     * test static method fromArray.
     */
    public function testStaticFromArray()
    {
        $notificationParameters = FakeParameters::getNotificationParameters();

        $notification = Notification::fromArray($notificationParameters);

        $this->assertInstanceOf(Notification::class, $notification);
        $this->assertSame($notificationParameters['event'], $notification->getEvent());
        $this->assertSame($notificationParameters['trackers'], $notification->getTrackers());
    }

    /**
     * test method toArray.
     */
    public function testToArray()
    {
        $notificationParameters = FakeParameters::getNotificationParameters();

        $notification = Notification::fromArray($notificationParameters);

        $this->assertInstanceOf(Notification::class, $notification);
        $this->assertSame($notificationParameters, $notification->toArray());
    }
}
