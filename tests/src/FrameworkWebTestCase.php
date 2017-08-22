<?php

/*
 * This file is part of the Symfony-Util package.
 *
 * (c) Jean-Bernard Addor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrameworkWebTestCase extends WebTestCase
{
    protected static function getKernelClass()
    {
        return FrameworkKernel::class;
    }
}
