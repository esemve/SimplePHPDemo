<?php

namespace Libs;

class ConfigFactory
{
    protected $configInternalCache;

    protected $configPath = null;

    public function create(): ConfigInterface
    {
        if (empty($this->configInternalCache)) {
            $this->configInternalCache = new Config(require($this->getConfigPath()));
        }

        return $this->configInternalCache;
    }

    public function getConfigPath(): string
    {
        return $this->configPath;
    }

    public function setConfigPath($configPath): void
    {
        $this->configPath = $configPath;
    }
}