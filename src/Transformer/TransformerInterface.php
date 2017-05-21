<?php
/**
 * This file is part of the fnayou/instapush-php project.
 *
 * Copyright (c) 2017. Aymen FNAYOU <fnayou.aymen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fnayou\InstapushPHP\Transformer;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface TransformerInterface.
 */
interface TransformerInterface
{
    /**
     * @param ResponseInterface $response
     * @param string            $class
     *
     * @return mixed
     */
    public function transform(ResponseInterface $response, string $class);
}
