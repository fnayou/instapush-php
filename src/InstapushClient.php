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

use Fnayou\InstapushPHP\Transformer\ModelTransformer;
use Fnayou\InstapushPHP\Transformer\TransformerInterface;
use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;

/**
 * Class InstapushClient.
 */
final class InstapushClient
{
    /** @var \Http\Client\HttpClient */
    private $httpClient;

    /** @var \Http\Message\RequestFactory */
    private $requestFactory;

    /** @var \Fnayou\InstapushPHP\Transformer\TransformerInterface */
    private $transformer;

    /**
     * @param \Http\Client\HttpClient                                    $httpClient
     * @param \Http\Message\RequestFactory|null                          $requestFactory
     * @param \Fnayou\InstapushPHP\Transformer\TransformerInterface|null $transformer
     */
    public function __construct(
        HttpClient $httpClient,
        RequestFactory $requestFactory = null,
        TransformerInterface $transformer = null
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
        $this->transformer = $transformer ?: new ModelTransformer();
    }

    /**
     * @param \Fnayou\InstapushPHP\HttpClientConfigurator                $httpClientConfigurator
     * @param \Http\Message\RequestFactory|null                          $requestFactory
     * @param \Fnayou\InstapushPHP\Transformer\TransformerInterface|null $hydrator
     *
     * @return $this
     */
    public static function configure(
        HttpClientConfigurator $httpClientConfigurator,
        RequestFactory $requestFactory = null,
        TransformerInterface $hydrator = null
    ) {
        $httpClient = $httpClientConfigurator->createConfiguredClient();

        return new static($httpClient, $hydrator, $requestFactory);
    }

    /**
     * @param string $userToken
     * @param string $appIdentifier
     * @param string $appSecret
     *
     * @return $this
     */
    public static function create(string $userToken, string $appIdentifier, string $appSecret)
    {
        $httpClientConfigurator = new HttpClientConfigurator();
        $httpClientConfigurator->setApiCredentials($userToken, $appIdentifier, $appSecret);

        return static::configure($httpClientConfigurator);
    }
}
