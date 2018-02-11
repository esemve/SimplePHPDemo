<?php

namespace Libs;

class Config implements ConfigInterface
{
    protected $config;

    public function setConfigArray(array $config): ConfigInterface
    {
        $this->config = $config;

        return $this;
    }

    public function get(string $key, $default = null)
    {
        $key = explode('.', $key);
        $test = $this->config;

        foreach ($key AS $part) {
            if (isset($test[$part])) {
                $test = $test[$part];
            } else {
                return $default;
            }
        }

        return $test;
    }

}