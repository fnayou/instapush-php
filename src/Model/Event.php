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
 * Model Event.
 */
class Event implements FromArrayInterface
{
    /** @var string */
    private $title;

    /** @var string */
    private $message;

    /** @var array */
    private $trackers;

    /**
     * @param string $title
     * @param string $message
     * @param array  $trackers
     */
    public function __construct(string $title, string $message, array $trackers)
    {
        $this->title = $title;
        $this->trackers = $trackers;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
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
        return new static($data['title'], $data['message'], $data['trackers']);
    }
}
