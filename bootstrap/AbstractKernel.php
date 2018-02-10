<?php

namespace Bootstrap;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

abstract class AbstractKernel
{
    protected $container;

    abstract public function run(): void;

    protected function getContainer(): ContainerInterface
    {
        if (empty($this->container)) {
            $builder = new ContainerBuilder();
            $container = $builder->build();

            require_once __DIR__ . '/../config/services.php';

            $this->container = $container;
        }

        return $this->container;
    }

}