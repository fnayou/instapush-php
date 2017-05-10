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
 * Model Application.
 */
class Application implements FromArrayInterface
{
    /** @var string */
    private $title;

    /** @var string */
    private $appId;

    /** @var string */
    private $appSecret;

    /**
     * @param string $title
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct(
        string $title,
        string $appId = null,
        string $appSecret = null
    ) {
        $this
            ->setTitle($title)
            ->setAppId($appId)
            ->setAppSecret($appSecret);
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
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param string $appId
     *
     * @return $this
     */
    public function setAppId(string $appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * @param string $appSecret
     *
     * @return $this
     */
    public function setAppSecret(string $appSecret)
    {
        $this->appSecret = $appSecret;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data)
    {
        return new static(
            $data['title'],
            $data['appID'],
            $data['appSecret']
        );
    }
}
