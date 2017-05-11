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
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\UriFactory;

/**
 * Class AbstractHttpClientConfigurator.
 */
abstract class AbstractHttpClientConfigurator
{
    /**
     * @var \Http\Message\UriFactory
     */
    protected $uriFactory;

    /**
     * @var \Http\Client\HttpClient
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $prependPlugins = [];

    /**
     * @var array
     */
    protected $appendPlugins = [];

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
     * @return UriFactory
     */
    public function getUriFactory()
    {
        return $this->uriFactory;
    }

    /**
     * @param UriFactory $uriFactory
     */
    public function setUriFactory(UriFactory $uriFactory)
    {
        $this->uriFactory = $uriFactory;
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return array
     */
    public function getPrependPlugins()
    {
        return $this->prependPlugins;
    }

    /**
     * @return array
     */
    public function getAppendPlugins()
    {
        return $this->appendPlugins;
    }

    /**
     * @param \Http\Client\Common\Plugin ...$plugins
     *
     * @return $this
     */
    public function appendPlugin(Plugin ...$plugins)
    {
        foreach ($plugins as $plugin) {
            $this->appendPlugins[] = $plugin;
        }

        return $this;
    }

    /**
     * @param \Http\Client\Common\Plugin ...$plugins
     *
     * @return $this
     */
    public function prependPlugin(Plugin ...$plugins)
    {
        $plugins = \array_reverse($plugins);

        foreach ($plugins as $plugin) {
            \array_unshift($this->prependPlugins, $plugin);
        }

        return $this;
    }
}
