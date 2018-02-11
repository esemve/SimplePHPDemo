<?php

namespace Libs;

interface DatabaseInterface
{
    /**
     * Az élő kapcsolattal rendelkező PDO -t adja vissza
     *
     * @return \PDO
     */
    public function getPdo(): \PDO;
}