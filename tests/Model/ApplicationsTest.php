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

use Doctrine\Common\Collections\ArrayCollection;
use Fnayou\InstapushPHP\Model\Application;
use Fnayou\InstapushPHP\Model\Applications;
use Fnayou\InstapushPHP\Model\FromArrayInterface;
use Fnayou\InstapushPHP\Test\FakeParameters;

/**
 * Class ApplicationsTest.
 */
final class ApplicationsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test implement FromArrayInterface.
     */
    public function testImplementFromArrayInterface()
    {
        $reflection = new \ReflectionClass(Applications::class);

        $this->assertTrue($reflection->implementsInterface(FromArrayInterface::class));
    }

    /**
     * test extend ArrayCollection.
     */
    public function testInstanceOfArrayCollection()
    {
        $reflection = new \ReflectionClass(Applications::class);

        $this->assertTrue($reflection->isSubclassOf(ArrayCollection::class));
    }

    /**
     * test static method fromArray.
     */
    public function testStaticFromArray()
    {
        $applicationsParameters = FakeParameters::getApplicationsParameters();

        $applications = Applications::fromArray($applicationsParameters);

        /** @var \Fnayou\InstapushPHP\Model\Application $element */
        $element = $applications->first();

        $this->assertInstanceOf(Applications::class, $applications);
        $this->assertSame(count($applicationsParameters), $applications->count());
        $this->assertInstanceOf(Application::class, $element);
        $this->assertSame($applicationsParameters[0], $element->toArray());
    }
}
