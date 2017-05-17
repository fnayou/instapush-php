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
use Fnayou\InstapushPHP\Model\Notification;

/**
 * Class NotificationApi.
 */
class NotificationApi extends AbstractApi
{
    /**
     * @param \Fnayou\InstapushPHP\Model\Notification $notification
     *
     * @throws \Fnayou\InstapushPHP\Exception\ApiException
     *
     * @return bool
     */
    public function post(Notification $notification)
    {
        $notificationApi = $this->doPost('/post', $notification->toArray());

        if (200 !== $notificationApi->getResponse()->getStatusCode()
            && 201 !== $notificationApi->getResponse()->getStatusCode()) {
            throw new ApiException('cannot send notification', $this->getRequest(), $this->getResponse());
        }

        return true;
    }
}
