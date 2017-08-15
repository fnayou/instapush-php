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

use Fnayou\InstapushPHP\Model\Application;
use Fnayou\InstapushPHP\Model\FromArrayInterface;
use Fnayou\InstapushPHP\Test\FakeParameters;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationTest.
 */
final class ApplicationTest extends TestCase
{
    /**
     * test implement FromArrayInterface.
     */
    public function testImplementFromArrayInterface()
    {
        $reflection = new \ReflectionClass(Application::class);

        $this->assertTrue($reflection->implementsInterface(FromArrayInterface::class));
    }

    /**
     * test constructor.
     */
    public function testConstructor()
    {
        $classname = Application::class;

        $applicationParameters = FakeParameters::getApplicationParameters();

        $mock = $this->getMockBuilder($classname)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('setTitle')
            ->with(
                $this->equalTo($applicationParameters['title'])
            )
            ->will($this->returnSelf());

        $mock->expects($this->once())
            ->method('setAppId')
            ->with(
                $this->equalTo($applicationParameters['appID'])
            )
            ->will($this->returnSelf());

        $mock->expects($this->once())
            ->method('setAppSecret')
            ->with(
                $this->equalTo($applicationParameters['appSecret'])
            )
            ->will($this->returnSelf());

        // now call the constructor
        $reflectedClass = new \ReflectionClass($classname);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke(
            $mock,
            $applicationParameters['title'],
            $applicationParameters['appID'],
            $applicationParameters['appSecret']
        );
    }

    /**
     * test static method fromArray.
     */
    public function testStaticFromArray()
    {
        $applicationParameters = FakeParameters::getApplicationParameters();

        $application = Application::fromArray($applicationParameters);

        $this->assertInstanceOf(Application::class, $application);
        $this->assertSame($applicationParameters['title'], $application->getTitle());
        $this->assertSame($applicationParameters['appID'], $application->getAppId());
        $this->assertSame($applicationParameters['appSecret'], $application->getAppSecret());
    }

    /**
     * test method toArray.
     */
    public function testToArray()
    {
        $applicationParameters = FakeParameters::getApplicationParameters();

        $application = Application::fromArray($applicationParameters);

        $this->assertInstanceOf(Application::class, $application);
        $this->assertSame($applicationParameters, $application->toArray());
    }
}
