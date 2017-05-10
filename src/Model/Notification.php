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
        $this->event = $event;
        $this->trackers = $trackers;
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
     */
    public function setEvent(string $event)
    {
        $this->event = $event;
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
     */
    public function setTrackers(array $trackers)
    {
        $this->trackers = $trackers;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data)
    {
        return new static($data['event'], $data['trackers']);
    }
}
