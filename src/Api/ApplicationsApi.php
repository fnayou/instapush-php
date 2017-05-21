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

use Fnayou\InstapushPHP\Model\Application;
use Fnayou\InstapushPHP\Model\Applications;

/**
 * Class ApplicationsApi.
 */
class ApplicationsApi extends AbstractApi
{
    /**
     * @return \Fnayou\InstapushPHP\Model\Applications
     */
    public function list()
    {
        $applicationsApi = $this->doGet('/apps/list');

        // full absurdity
        if ('null' === $applicationsApi->getResponse()->getBody()->__toString()) {
            return new Applications();
        }

        return $this->transformResponse(Applications::class);
    }

    /**
     * @param \Fnayou\InstapushPHP\Model\Application $application
     *
     * @return \Fnayou\InstapushPHP\Model\Application
     */
    public function add(Application $application)
    {
        $this->doPost('/apps/add', $application->toArray());

        /** @var \Fnayou\InstapushPHP\Model\Applications $applications */
        $applications = $this->list();

        return $applications->last();
    }
}
