<?php
/**
 * This file is part of the fnayou/instapush-php project.
 *
 * Copyright (c) 2017. Aymen FNAYOU <fnayou.aymen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fnayou\InstapushPHP\Model;

/**
 * Interface FromArrayInterface.
 */
interface FromArrayInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public static function fromArray(array $data);
}
