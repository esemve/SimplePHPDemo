<?php

namespace Libs\Test;

use Bootstrap\TestKernel;
use Interop\Container\ContainerInterface;

use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\TestCaseTrait;

abstract class DBTestCase extends \PHPUnit\Framework\TestCase
{
    use TestCaseTrait {
        TestCaseTrait::setUp AS dbSetUp;
        TestCaseTrait::tearDown AS dbTearDown;
    }

    protected $conn;

    protected static $pdo;

    protected static $config;

    public function setUp() {

        $this->getContainer()->get('libs.cache')->flushAll();
        $this->dbSetUp();
    }

    public function tearDown()
    {
        $this->getContainer()->get('libs.cache')->flushAll();
        $this->dbTearDown();
    }

    public function getContainer(): ContainerInterface
    {
        return TestKernel::getStaticContainer();
    }

    /**
     * Returns the test database connection.
     *
     * @return Connection
     */
    protected function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$config = require __DIR__.'/../../config/config_test.php';
                self::$pdo = new \PDO(
                    sprintf(
                        'mysql:host=%s;dbname=%s',
                        self::$config['database']['host'],
                        self::$config['database']['database']
                    ),
                    self::$config['database']['user'],
                    self::$config['database']['password'],
                    [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
                );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, self::$config['database']['database']);
        }

        return $this->conn;
    }


}