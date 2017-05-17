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
    private $instapushClient;

    /** @var \Psr\Http\Message\RequestInterface */
    private $request;

    /** @var \Psr\Http\Message\ResponseInterface */
    private $response;

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
    public function getInstapushClient()
    {
        return $this->instapushClient;
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param \Fnayou\InstapushPHP\InstapushClient $instapushClient
     *
     * @return $this
     */
    protected function setInstapushClient(InstapushClient $instapushClient)
    {
        $this->instapushClient = $instapushClient;

        return $this;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return $this
     */
    protected function setRequest(RequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return $this
     */
    protected function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @param string $path
     * @param array  $parameters
     * @param array  $headers
     *
     * @return $this
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

        $response = $this
            ->getInstapushClient()
            ->getHttpClient()
            ->sendRequest($request);

        $this->setResponse($response);

        return $this;
    }

    /**
     * @param string $path
     * @param array  $parameters
     * @param array  $headers
     *
     * @return $this
     */
    protected function doPost(string $path, array $parameters = [], array $headers = [])
    {
        $body = \json_encode($parameters);

        $request = $this
            ->getInstapushClient()
            ->getRequestFactory()
            ->createRequest('POST', $path, $headers, $body);

        $this->setRequest($request);

        $response = $this
            ->getInstapushClient()
            ->getHttpClient()
            ->sendRequest($request);

        $this->setResponse($response);

        return $this;
    }

    /**
     * @param string $class
     *
     * @return mixed
     */
    protected function transformResponse(string $class = null)
    {
        // handle exception
        if (200 !== $this->getResponse()->getStatusCode()
            && 201 !== $this->getResponse()->getStatusCode()
        ) {
            return $this->handleException();
        }

        if (null === $this->getInstapushClient()->getTransformer() || null === $class) {
            return \json_decode($this->getResponse()->getBody()->getContents(), true);
        }

        return $this->getInstapushClient()->getTransformer()->transform($this->getResponse(), $class);
    }

    /**
     * @throws \Fnayou\InstapushPHP\Exception\ApiException
     *
     * @return \Fnayou\InstapushPHP\Model\ApiError
     */
    protected function handleException()
    {
        $this->handleNotJsonException($this->getResponse());

        if (false === $this->getInstapushClient()->isHandleException()) {
            return $this
                ->getInstapushClient()
                ->getTransformer()
                ->transform($this->getResponse(), ApiError::class);
        }

        $content = \json_decode($this->getResponse()->getBody()->__toString(), true);

        $message = true === isset($content['msg']) ? $content['msg'] : 'An unexpected error occurred : '.$content;

        throw new ApiException($message, $this->getRequest(), $this->getResponse());
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws \Fnayou\InstapushPHP\Exception\ApiException
     */
    protected function handleNotJsonException(ResponseInterface $response)
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
    }
}
