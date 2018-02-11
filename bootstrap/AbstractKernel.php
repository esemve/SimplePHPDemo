<?php

namespace Bootstrap;

use DI\Container;
use DI\ContainerBuilder;
use Libs\ConfigInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractKernel
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var ConfigInterface
     */
    protected $config;

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


    protected function loadConfig(): void
    {
        $this->config = $this->getConfig()->setConfigArray(require(__DIR__.'/../config/config.php'));
    }

    protected function getConfig(): ConfigInterface
    {
        return $this->container->get('libs.config');
    }

    protected function isDebug(): bool
    {
        return $this->config->get('debug', false);
    }

    protected function enableDebugMode(): void
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }

}