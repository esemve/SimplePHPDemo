<?php

namespace Libs\Test;

use Bootstrap\TestKernel;
use Interop\Container\ContainerInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function getContainer(): ContainerInterface
    {
        return TestKernel::getStaticContainer();
    }

}