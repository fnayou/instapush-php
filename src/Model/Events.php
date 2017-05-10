<?php
/**
 * This file is part of the fnayou/instapush-php project.
 *
 * Copyright (c) 2017. Aymen FNAYOU <fnayou.aymen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fnayou\InstapushPHP\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Fnayou\InstapushPHP\Model\FromArrayInterface;

/**
 * Model Events.
 */
class Events extends ArrayCollection implements FromArrayInterface
{
    /**
     * @param Event $event
     *
     * @return $this
     */
    public function addEvent(Event $event)
    {
        $this->add($event);

        return $this;
    }

    /**
     * @param Event $event
     */
    public function removeEvent(Event $event)
    {
        $this->removeElement($event);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data)
    {
        $events = [];

        foreach ($data as $datum) {
            $events[] = Event::fromArray($datum);
        }

        return new static($events);
    }
}
