<?php

namespace Libs;

interface DatabaseInterface
{
    public function getPdo(): \PDO;
}