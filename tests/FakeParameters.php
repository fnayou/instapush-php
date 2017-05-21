<?php
/**
 * This file is part of the fnayou/instapush-php project.
 *
 * Copyright (c) 2017. Aymen FNAYOU <fnayou.aymen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fnayou\InstapushPHP\Test;

use Fnayou\InstapushPHP\Model\Application;
use GuzzleHttp\Psr7\Response;

/**
 * Class FakeParameters.
 */
class FakeParameters
{
    /**
     * @return array
     */
    public static function getApiErrorParameters()
    {
        return [
            'msg' => 'some message',
            'status' => '123',
        ];
    }

    /**
     * @return array
     */
    public static function getApplicationParameters()
    {
        $applicationsParameters = static::getApplicationsParameters();

        return $applicationsParameters[0];
    }

    /**
     * @return array
     */
    public static function getApplicationsParameters()
    {
        return [
            [
                'title' => 'the title',
                'appID' => '123456789',
                'appSecret' => 'a1b2c3d4e5f6g7h8i9',
             ],
            [
                'title' => 'the title',
                'appID' => '123456789',
                'appSecret' => 'a1b2c3d4e5f6g7h8i9',
            ],
        ];
    }

    /**
     * @return array
     */
    public static function getEventParameters()
    {
        $applicationsParameters = static::getEventsParameters();

        return $applicationsParameters[0];
    }

    /**
     * @return array
     */
    public static function getEventsParameters()
    {
        return [
            [
                'title' => 'the title',
                'message' => 'some message with {trackerOne} and {trackerTwo}',
                'trackers' => ['trackerOne', 'trackerTwo'],
            ],
            [
                'title' => 'the title',
                'message' => 'some message with {trackerOne} and {trackerTwo}',
                'trackers' => ['trackerOne', 'trackerTwo'],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function getNotificationParameters()
    {
        return [
            'event' => 'the event',
            'trackers' => [
                'trackerOne' => 'valueOne',
                'trackerTwo' => 'valueTwo',
            ],
        ];
    }

    /**
     * @return array
     */
    public static function getModelTransformerParameters()
    {
        $responseWithWrongBody = new Response(
            200,
            [],
            "full wrong fake body"
        );

        $responseWithCorrectBody = new Response(
            200,
            [],
            \json_encode(static::getApplicationParameters())
        );

        return [
            'withWrongBody' => $responseWithWrongBody,
            'withCorrectBody' => $responseWithCorrectBody,
            'correctClass' => Application::class,
        ];
    }
}
