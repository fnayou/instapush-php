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

/**
 * Class Notification.
 */
class Notification implements FromArrayInterface
{
    /** @var string */
    private $event;

    /** @var array */
    private $trackers;

    /**
     * @param string $event
     * @param array  $trackers
     */
    public function __construct(string $event, array $trackers)
    {
        $this
            ->setEvent($event)
            ->setTrackers($trackers);
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     *
     * @return $this
     */
    public function setEvent(string $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return array
     */
    public function getTrackers()
    {
        return $this->trackers;
    }

    /**
     * @param array $trackers
     *
     * @return $this
     */
    public function setTrackers(array $trackers)
    {
        $this->trackers = $trackers;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data)
    {
        return new static($data['event'], $data['trackers']);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'event' => $this->getEvent(),
            'trackers' => $this->getTrackers(),
        ];
    }
}
