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
        $this
            ->setTitle($title)
            ->setMessage($message)
            ->setTrackers($trackers);
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
     *
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
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
     *
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

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
        return new static($data['title'], $data['message'], $data['trackers']);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->getTitle(),
            'message' => $this->getMessage(),
            'trackers' => $this->getTrackers(),
        ];
    }
}
