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

use Fnayou\InstapushPHP\Model\ApiError;
use Fnayou\InstapushPHP\Model\FromArrayInterface;
use Fnayou\InstapushPHP\Test\FakeParameters;

/**
 * Class ApiErrorTest.
 */
final class ApiErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test implement FromArrayInterface.
     */
    public function testImplementFromArrayInterface()
    {
        $reflection = new \ReflectionClass(ApiError::class);

        $this->assertTrue($reflection->implementsInterface(FromArrayInterface::class));
    }

    /**
     * test constructor.
     */
    public function testConstructor()
    {
        $classname = ApiError::class;

        $apiErrorParameters = FakeParameters::getApiErrorParameters();

        $mock = $this->getMockBuilder($classname)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('setMessage')
            ->with(
                $this->equalTo($apiErrorParameters['msg'])
            )
            ->will($this->returnSelf());

        $mock->expects($this->once())
            ->method('setStatus')
            ->with(
                $this->equalTo($apiErrorParameters['status'])
            )
            ->will($this->returnSelf());

        // now call the constructor
        $reflectedClass = new \ReflectionClass($classname);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, $apiErrorParameters['msg'], $apiErrorParameters['status']);
    }

    /**
     * test static method fromArray.
     */
    public function testStaticFromArray()
    {
        $apiErrorParameters = FakeParameters::getApiErrorParameters();

        $apiError = ApiError::fromArray($apiErrorParameters);

        $this->assertInstanceOf(ApiError::class, $apiError);
        $this->assertSame($apiErrorParameters['msg'], $apiError->getMessage());
        $this->assertSame($apiErrorParameters['status'], $apiError->getStatus());
    }
}
