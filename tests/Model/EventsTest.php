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
use Fnayou\InstapushPHP\Model\Event;
use Fnayou\InstapushPHP\Model\Events;
use Fnayou\InstapushPHP\Model\FromArrayInterface;
use Fnayou\InstapushPHP\Test\FakeParameters;

/**
 * Class EventsTest.
 */
final class EventsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test implement FromArrayInterface.
     */
    public function testImplementFromArrayInterface()
    {
        $reflection = new \ReflectionClass(Events::class);

        $this->assertTrue($reflection->implementsInterface(FromArrayInterface::class));
    }

    /**
     * test extend ArrayCollection.
     */
    public function testInstanceOfArrayCollection()
    {
        $reflection = new \ReflectionClass(Events::class);

        $this->assertTrue($reflection->isSubclassOf(ArrayCollection::class));
    }

    /**
     * test static method fromArray.
     */
    public function testStaticFromArray()
    {
        $eventsParameters = FakeParameters::getEventsParameters();

        $events = Events::fromArray($eventsParameters);

        /** @var \Fnayou\InstapushPHP\Model\Event $element */
        $element = $events->first();

        $this->assertInstanceOf(Events::class, $events);
        $this->assertSame(count($eventsParameters), $events->count());
        $this->assertInstanceOf(Event::class, $element);
        $this->assertSame($eventsParameters[0], $element->toArray());
    }
}
