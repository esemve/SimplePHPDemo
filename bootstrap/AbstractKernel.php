<?php

namespace Bootstrap;

use DI\Container;
use DI\ContainerBuilder;
use Libs\CacheFactory;
use Libs\ConfigInterface;
use Predis\Client;
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

            $configFilePath = $this->getConfigPath();
            require_once __DIR__ . '/../config/services.php';

            $this->container = $container;
        }
        $this->registerCache();

        return $this->container;
    }

    protected function getConfig(): ConfigInterface
    {
        return $this->container->get('libs.config');
    }

    protected function isDebug(): bool
    {
        return $this->getConfig()->get('debug', false);
    }

    protected function enableDebugMode(): void
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }

    protected function registerCache(): void
    {
        $this->container->get('libs.cache')->setClient(
            new Client($this->getConfig()->get('redis'))
        )->setPrefix($this->getConfig()->get('cachePrefix'));
    }

    abstract protected function getConfigPath(): string;

}