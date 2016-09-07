<?php

namespace Fnayou\Instapush\Subscriber;

use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\UriTemplate;

class VersionSubscriber implements SubscriberInterface
{
    protected $apiVersion;

    public function __construct($apiVersion)
    {
        $this->apiVersion = $apiVersion;
    }

    public function getEvents()
    {
        return ['prepared' => ['onPrepared']];
    }

    public function onPrepared(PreparedEvent $event)
    {
        $request = $event->getRequest();

        $uriTemplate = new UriTemplate();

        $request->setUrl(
            $uriTemplate->expand(urldecode($request->getUrl()), ['apiVersion' => 'v'.$this->apiVersion])
        );
    }
}
