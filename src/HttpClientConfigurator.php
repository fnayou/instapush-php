<?php
/**
 * This file is part of the fnayou/instapush-php project.
 *
 * Copyright (c) 2017. Aymen FNAYOU <fnayou.aymen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fnayou\InstapushPHP;

use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\UriFactory;

/**
 * Configure an HTTP client.
 */
class HttpClientConfigurator
{
    const USER_AGENT = 'fnayou/instapush-php';

    /**
     * @var string
     */
    private $endpoint = 'https://api.instapush.im/v1';

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
     * @var \Http\Message\UriFactory
     */
    private $uriFactory;

    /**
     * @var \Http\Client\HttpClient
     */
    private $httpClient;

    /**
     * @var array
     */
    private $prependPlugins = [];

    /**
     * @var array
     */
    private $appendPlugins = [];

    /**
     * @param \Http\Client\HttpClient  $httpClient
     * @param \Http\Message\UriFactory $uriFactory
     */
    public function __construct(HttpClient $httpClient = null, UriFactory $uriFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->uriFactory = $uriFactory ?: UriFactoryDiscovery::find();
    }

    /**
     * @return \Http\Client\HttpClient
     */
    public function createConfiguredClient()
    {
        $plugins = $this->prependPlugins;
        $plugins[] = new Plugin\AddHostPlugin($this->uriFactory->createUri($this->getEndpoint()));

        $plugins[] = new Plugin\HeaderDefaultsPlugin([
            'User-Agent' => static::USER_AGENT,
            'X-INSTAPUSH-TOKEN' => $this->apiUserToken,
            'X-INSTAPUSH-APPID' => $this->apiAppIdentifier,
            'X-INSTAPUSH-APPSECRET' => $this->apiAppSecret,
        ]);

        return new PluginClient($this->httpClient, array_merge($plugins, $this->appendPlugins));
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
     * @param string $userToken
     * @param string $appIdentifier
     * @param string $appSecret
     *
     * @return $this
     */
    public function setApiCredentials(string $userToken, string $appIdentifier, string $appSecret)
    {
        $this->apiUserToken = $userToken;
        $this->apiAppIdentifier = $appIdentifier;
        $this->apiAppSecret = $appSecret;

        return $this;
    }

    /**
     * @param \Http\Client\Common\Plugin ...$plugin
     *
     * @return $this
     */
    public function appendPlugin(Plugin ...$plugin)
    {
        foreach ($plugin as $p) {
            $this->appendPlugins[] = $p;
        }

        return $this;
    }

    /**
     * @param \Http\Client\Common\Plugin ...$plugin
     *
     * @return $this
     */
    public function prependPlugin(Plugin ...$plugin)
    {
        $plugin = \array_reverse($plugin);
        foreach ($plugin as $p) {
            \array_unshift($this->prependPlugins, $p);
        }

        return $this;
    }
}
