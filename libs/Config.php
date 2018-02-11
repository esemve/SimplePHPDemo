<?php

namespace Libs;

class Config implements ConfigInterface
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
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