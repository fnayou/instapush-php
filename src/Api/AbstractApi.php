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

use Fnayou\InstapushPHP\Exception\ApiException;
use Fnayou\InstapushPHP\InstapushClient;
use Fnayou\InstapushPHP\Model\ApiError;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractApi.
 */
abstract class AbstractApi
{
    /** @var \Fnayou\InstapushPHP\InstapushClient */
    protected $instapushClient;

    /** @var \Psr\Http\Message\RequestInterface */
    protected $request;

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

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     */
    protected function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string                              $class
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function transformResponse(ResponseInterface $response, $class)
    {
        // return \GuzzleHttp\Psr7\Response
        if (!$this->getInstapushClient()->getTransformer()) {
            return $response;
        }

        // handle exception
        if (200 !== $response->getStatusCode() && 201 !== $response->getStatusCode()) {
            return $this->handleException($response);
        }

        // transform response according to class
        return $this->getInstapushClient()->getTransformer()->transform($response, $class);
    }

    /**
     * @param string $path
     * @param array  $parameters
     * @param array  $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function doGet(string $path, array $parameters = [], array $headers = [])
    {
        if (0 < \count($parameters)) {
            $path .= '?'.\http_build_query($parameters);
        }

        $request = $this
            ->getInstapushClient()
            ->getRequestFactory()
            ->createRequest('GET', $path, $headers);

        $this->setRequest($request);

        return $this->instapushClient->getHttpClient()->sendRequest($request);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     */
    protected function handleException(ResponseInterface $response)
    {
        if (true !== $response->hasHeader('Content-Type')
            || 'application/json' !== $response->getHeaderLine('Content-Type')
        ) {
            throw new ApiException(
                \sprintf(
                    'Waiting for json response but %s given',
                    $response->getHeaderLine('Content-Type')
                ),
                $this->getRequest(),
                $response
            );
        }

        if (false === $this->getInstapushClient()->isHandleException()) {
            return $this->getInstapushClient()->getTransformer()->transform($response, ApiError::class);
        }

        $content = \json_decode($response->getBody()->getContents(), true);

        if (true === isset($content['msg'])) {
            $message = $content['msg'];
        } else {
            $message = 'An unexpected/unknown error occurred : '.$content;
        }

        throw new ApiException($message, $this->getRequest(), $response);
    }
}
