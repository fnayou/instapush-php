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
 * Class ApiError.
 */
class ApiError implements FromArrayInterface
{
    /** @var string */
    private $message;

    /** @var string */
    private $status;

    /**
     * @param string $message
     * @param string $status
     */
    public function __construct(
        string $message,
        string $status
    ) {
        $this
            ->setMessage($message)
            ->setStatus($status);
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
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data)
    {
        return new static(
            $data['msg'],
            $data['status']
        );
    }
}
