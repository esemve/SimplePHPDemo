<?php

namespace Libs;

use PDO;

class Database implements DatabaseInterface
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

    /**
     * Kapcsolódik az adatbázishoz PDO-val, majd
     * elcacheli magának a PDO -t
     *
     * @throws \Exception
     */
    protected function connect(): void
    {
        if ($this->pdo instanceof PDO) {
            throw new \Exception('Database connect call only once!');
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

    /**
     * Az élő kapcsolattal rendelkező PDO -t adja vissza
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}