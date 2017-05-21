<?php
/**
 * This file is part of the fnayou/instapush-php project.
 *
 * Copyright (c) 2017. Aymen FNAYOU <fnayou.aymen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fnayou\InstapushPHP\Test\Exception;

use Fnayou\InstapushPHP\Exception\ExceptionInterface;
use Fnayou\InstapushPHP\Exception\TransformerException;

/**
 * Class TransformerExceptionTest.
 */
final class TransformerExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test implement ExceptionInterface.
     */
    public function testImplementExceptionInterface()
    {
        $reflection = new \ReflectionClass(TransformerException::class);

        $this->assertTrue($reflection->implementsInterface(ExceptionInterface::class));
    }

    /**
     * test extend RuntimeException.
     */
    public function testInstanceOfRuntimeException()
    {
        $reflection = new \ReflectionClass(TransformerException::class);

        $this->assertTrue($reflection->isSubclassOf(\RuntimeException::class));
    }
}
