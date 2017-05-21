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

use Fnayou\InstapushPHP\Exception\TransformerException;
use Fnayou\InstapushPHP\Model\Application;
use Fnayou\InstapushPHP\Test\FakeParameters;
use Fnayou\InstapushPHP\Transformer\ModelTransformer;
use Fnayou\InstapushPHP\Transformer\TransformerInterface;

/**
 * Class ModelTransformerTest.
 */
final class ModelTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test implement TransformerInterface.
     */
    public function testImplementTransformerInterface()
    {
        $reflection = new \ReflectionClass(ModelTransformer::class);

        $this->assertTrue($reflection->implementsInterface(TransformerInterface::class));
    }

    /**
     * test bad json response should throw exception
     */
    public function testBadJsonResponseShouldThrowException()
    {
        $this->expectException(TransformerException::class);

        $modelTransformerParameters = FakeParameters::getModelTransformerParameters();
        $modelTransformer = new ModelTransformer();

        $modelTransformer->transform(
            $modelTransformerParameters['withWrongBody'],
            $modelTransformerParameters['correctClass']
        );
    }

    /**
     * test bad json response should throw exception
     */
    public function testCorrectParametersShouldSuccess()
    {
        $modelTransformerParameters = FakeParameters::getModelTransformerParameters();
        $modelTransformer = new ModelTransformer();

        $application = $modelTransformer->transform(
            $modelTransformerParameters['withCorrectBody'],
            $modelTransformerParameters['correctClass']
        );

        $applicationParameters = FakeParameters::getApplicationParameters();

        $this->assertInstanceOf(Application::class, $application);
        $this->assertSame($applicationParameters['title'], $application->getTitle());
        $this->assertSame($applicationParameters['appID'], $application->getAppId());
        $this->assertSame($applicationParameters['appSecret'], $application->getAppSecret());
    }
}
