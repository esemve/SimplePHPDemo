<?php

namespace Libs;

interface ConfigInterface {

    /**
     * Visszaad egy értéket dotted key alapján
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null);

}