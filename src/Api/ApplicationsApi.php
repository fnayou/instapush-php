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

use Fnayou\InstapushPHP\Model\Applications;

/**
 * Class ApplicationsApi.
 */
class ApplicationsApi extends AbstractApi
{
    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function list()
    {
        $response = $this->doGet('/apps/list');

        return $this->transformResponse($response, Applications::class);
    }
}
