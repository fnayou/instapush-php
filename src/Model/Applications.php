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

use Doctrine\Common\Collections\ArrayCollection;
use Fnayou\InstapushPHP\Model\FromArrayInterface;

/**
 * Model Applications.
 */
class Applications extends ArrayCollection implements FromArrayInterface
{
    /**
     * @param Application $application
     *
     * @return $this
     */
    public function addApplication(Application $application)
    {
        $this->add($application);

        return $this;
    }

    /**
     * @param Application $application
     */
    public function removeApplication(Application $application)
    {
        $this->removeElement($application);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data)
    {
        $applications = [];

        foreach ($data as $datum) {
            $applications[] = Application::fromArray($datum);
        }

        return new static($applications);
    }
}
