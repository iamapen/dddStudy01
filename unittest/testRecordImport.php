#!/usr/bin/php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$phpunitConfigFile = __DIR__ . '/../phpunit.xml';
$objXml = simplexml_load_file($phpunitConfigFile);

$dsn = (string)$objXml->xpath("/phpunit/php/const[@name='UNITTEST_MYSQL_DSN']")[0]->attributes()->value;
$dbuser = (string)$objXml->xpath("/phpunit/php/const[@name='UNITTEST_MYSQL_USERNAME']")[0]->attributes()->value;
$dbpass = (string)$objXml->xpath("/phpunit/php/const[@name='UNITTEST_MYSQL_PASSWORD']")[0]->attributes()->value;

$pdoOpts = [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_AUTOCOMMIT => false,
    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET SESSION sql_mode='TRADITIONAL,NO_AUTO_VALUE_ON_ZERO,ONLY_FULL_GROUP_BY'",
];
$pdo = new \PDO($dsn, $dbuser, $dbpass, $pdoOpts);

$con = new \PHPUnit\DbUnit\Database\DefaultConnection($pdo);
$tsvDir = realpath(__DIR__ . '/fixtures/table');
$tsvDs = new \Iamapen\CommentableDataSet\DbUnit\DataSet\CommentableCsvDataSet("\t");
$tsvDs->setIgnoreColumnCount(1);

$tableNames = [];
// 引数がある場合はそのテーブルのみ
if (count($_SERVER['argv']) > 1) {
    $tableNames = $_SERVER['argv'];
    array_shift($tableNames);
    foreach ($tableNames as $tableName) {
        $tsvFullpath = $tsvDir . '/' . $tableName . '.tsv';
        $tsvDs->addTable($tableName, $tsvFullpath);
    }
} else { // 引数がない場合は全TSVが対象
    $it = new \DirectoryIterator($tsvDir);
    foreach ($it as $fileInfo) {
        if ($fileInfo->getExtension() === 'tsv') {
            $tsvFullpath = $fileInfo->getPathname();
            $tableName = basename($tsvFullpath, '.tsv');
            $tsvDs->addTable($tableName, $tsvFullpath);
            $tableNames[] = $tableName;
        }
    }
}

echo "CLEAN INSERT to", "\n";
echo implode(', ', $tableNames), "\n";

// replace null
$ds = new \PHPUnit\DbUnit\DataSet\ReplacementDataSet($tsvDs);
$ds->addFullReplacement('\N', null);

// clean insert
$pdo->beginTransaction();
$op = \PHPUnit\DbUnit\Operation\Factory::CLEAN_INSERT()->execute($con, $ds);
$pdo->commit();
