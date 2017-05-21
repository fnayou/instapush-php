<?php
/**
 * This file is part of the fnayou/instapush-php project.
 *
 * Copyright (c) 2017. Aymen FNAYOU <fnayou.aymen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fnayou\InstapushPHP\Http;

use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;

/**
 * Configure an HTTP client.
 */
class HttpClientConfigurator extends AbstractHttpClientConfigurator implements HttpClientConfiguratorInterface
{
    const USER_AGENT = 'fnayou/instapush-php';

    /**
     * @var string
     */
    private $endpoint = 'http://api.instapush.im/v1';

    /**
     * @var string
     */
    private $apiUserToken;

    /**
     * @var string
     */
    private $apiAppIdentifier;

    /**
     * @var string
     */
    private $apiAppSecret;

    /**
     * @return \Http\Client\HttpClient
     */
    public function createConfiguredClient()
    {
        $plugins = $this->getPrependPlugins();
        $plugins[] = new Plugin\AddHostPlugin($this->getUriFactory()->createUri($this->getEndpoint()));
        $plugins[] = new Plugin\HeaderDefaultsPlugin($this->getHeaders());

        return new PluginClient($this->getHttpClient(), \array_merge($plugins, $this->getAppendPlugins()));
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     *
     * @return $this
     */
    public function setEndpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiUserToken()
    {
        return $this->apiUserToken;
    }

    /**
     * @param string $apiUserToken
     *
     * @return $this
     */
    public function setApiUserToken(string $apiUserToken = null)
    {
        $this->apiUserToken = $apiUserToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiAppIdentifier()
    {
        return $this->apiAppIdentifier;
    }

    /**
     * @param string $apiAppIdentifier
     *
     * @return $this
     */
    public function setApiAppIdentifier(string $apiAppIdentifier = null)
    {
        $this->apiAppIdentifier = $apiAppIdentifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiAppSecret()
    {
        return $this->apiAppSecret;
    }

    /**
     * @param string $apiAppSecret
     *
     * @return $this
     */
    public function setApiAppSecret(string $apiAppSecret = null)
    {
        $this->apiAppSecret = $apiAppSecret;

        return $this;
    }

    /**
     * @return array
     */
    private function getHeaders()
    {
        $headers = [
            'User-Agent' => static::USER_AGENT,
        ];

        if (null !== $this->getApiUserToken()) {
            $headers['X-INSTAPUSH-TOKEN'] = $this->getApiUserToken();
        }

        if (null !== $this->getApiAppIdentifier()) {
            $headers['X-INSTAPUSH-APPID'] = $this->getApiAppIdentifier();
        }

        if (null !== $this->getApiAppSecret()) {
            $headers['X-INSTAPUSH-APPSECRET'] = $this->getApiAppSecret();
        }

        return $headers;
    }
}
