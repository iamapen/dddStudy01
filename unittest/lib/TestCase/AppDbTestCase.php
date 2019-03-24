<?php
declare(strict_types=1);

namespace Acme\Shop\TestCase;

abstract class AppDbTestCase extends \PHPUnit\DbUnit\TestCase {
    protected function getConnection()
    {
        static $pdo;
        if($pdo !== null) {
            return $this->createDefaultDBConnection($pdo);
        }

        $pdoOpts = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_AUTOCOMMIT => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND  => "SET SESSION sql_mode='TRADITIONAL,NO_AUTO_VALUE_ON_ZERO,ONLY_FULL_GROUP_BY'",
            //\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
        ];
        $pdo = new \PDO(UNITTEST_MYSQL_DSN, UNITTEST_MYSQL_USERNAME, UNITTEST_MYSQL_PASSWORD, $pdoOpts);

        return $this->createDefaultDBConnection($pdo);
    }


    public function getSetUpOperation()
    {
        //return \PHPUnit\DbUnit\Operation\Factory::NONE();
        //return \PHPUnit\DbUnit\Operation\Factory::CLEAN_INSERT();

        return new \PHPUnit\DbUnit\Operation\Composite([
            \PHPUnit\DbUnit\Operation\Factory::TRUNCATE(),
            new \Iamapen\CommentableDataSet\DbUnit\Operation\MySqlBulkInsert(),
        ]);
    }

    public function getTearDownOperation()
    {
        return \PHPUnit\DbUnit\Operation\Factory::NONE();
    }

    protected static function getFixturesDir() {
        return realpath(__DIR__.'/../../fixtures');
    }
}