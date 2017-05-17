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

use Fnayou\InstapushPHP\Model\Event;
use Fnayou\InstapushPHP\Model\Events;

/**
 * Class EventsApi.
 */
class EventsApi extends AbstractApi
{
    /**
     * @return \Fnayou\InstapushPHP\Model\Events
     */
    public function list()
    {
        $eventsApi = $this->doGet('/events/list');

        // full absurdity
        if ('null' === $eventsApi->getResponse()->getBody()->__toString()) {
            return new Events();
        }

        return $eventsApi->transformResponse(Events::class);
    }

    /**
     * @param \Fnayou\InstapushPHP\Model\Event $event
     *
     * @return \Fnayou\InstapushPHP\Model\Event
     */
    public function add(Event $event)
    {
        $this->doPost('/events/add', $event->toArray());

        /** @var \Fnayou\InstapushPHP\Model\Events $events */
        $events = $this->list();

        return $events->last();
    }
}
