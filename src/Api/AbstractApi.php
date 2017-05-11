<?php
/**
 * This file is part of the fnayou/instapush-php project.
 *
 * Copyright (c) 2017. Aymen FNAYOU <fnayou.aymen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fnayou\InstapushPHP\Api;

use Fnayou\InstapushPHP\InstapushClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractApi.
 */
abstract class AbstractApi
{
    /** @var \Fnayou\InstapushPHP\InstapushClient */
    protected $instapushClient;

    /**
     * @param \Fnayou\InstapushPHP\InstapushClient $instapushClient
     */
    public function __construct(InstapushClient $instapushClient)
    {
        $this->instapushClient = $instapushClient;
    }

    /**
     * @return \Fnayou\InstapushPHP\InstapushClient
     */
    protected function getInstapushClient()
    {
        return $this->instapushClient;
    }

    /**
     * @param \Fnayou\InstapushPHP\InstapushClient $instapushClient
     */
    protected function setInstapushClient(InstapushClient $instapushClient)
    {
        $this->instapushClient = $instapushClient;
    }

    protected function transformResponse(ResponseInterface $response, $class)
    {
        if (!$this->getInstapushClient()->getTransformer()) {
            return $response;
        }

        //TODO: handle errors

        return $this->getInstapushClient()->getTransformer()->transform($response, $class);
    }

    protected function doGet(string $path, array $parameters = [], array $headers = [])
    {
        if (count($parameters) > 0) {
            $path .= '?'.\http_build_query($parameters);
        }

        $request = $this
            ->getInstapushClient()
            ->getRequestFactory()
            ->createRequest('GET', $path, $headers);

        return $this->instapushClient->getHttpClient()->sendRequest($request);
    }
}
