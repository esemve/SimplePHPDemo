<?php

namespace Libs;

use PDO;

class Database
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var PDO
     */
    protected $pdo;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;

        $this->connect();
    }

    protected function connect()
    {
        if ($this->pdo instanceof PDO) {
            return;
        }

        $this->pdo = new PDO(
            sprintf(
                'mysql:host=%s;dbname=%s',
                $this->config->get('database.host'),
                $this->config->get('database.database')
            ),
            $this->config->get('database.user'),
            $this->config->get('database.password'),
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
        );
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}