<?php

namespace Libs;

interface ConfigInterface {

    /**
     * Beállítja a konfigurációs adatokat
     *
     * @param array $config
     * @return ConfigInterface
     */
    public function setConfigArray(array $config): ConfigInterface;

    /**
     * Visszaad egy értéket dotted key alapján
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null);

}