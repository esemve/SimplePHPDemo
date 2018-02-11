<?php

namespace Bootstrap;

use Interop\Container\ContainerInterface;

class TestKernel extends AbstractKernel
{

    /**
     * @var ContainerInterface
     */
    protected static $staticContainer;

    /**
     * @var \Psr\Container\ContainerInterface
     */
    public function __construct()
    {
        $this->container = $this->getContainer();
        self::$staticContainer = $this->container;
    }

    static function getStaticContainer(): ContainerInterface
    {
        return self::$staticContainer;
    }

    public function run(): void
    {
    }
}