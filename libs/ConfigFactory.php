<?php

namespace Libs;

class ConfigFactory
{
    protected $configInternalCache;

    public function create(): ConfigInterface
    {
        if (empty($this->configInternalCache)) {
            $this->configInternalCache = new Config(require(__DIR__ . '/../config/config.php'));
        }

        return $this->configInternalCache;
    }
}