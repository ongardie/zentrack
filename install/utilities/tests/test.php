<?php
$rootPath = 'D:\personal\projects\zentrack\zentrack_3';

include_once $rootPath . '\includes\adodb\adodb.inc.php';
include_once $rootPath . '\includes\lib\classes\Zen.class';
include_once $rootPath . '\includes\lib\classes\ZenDatabase.class';
include_once $rootPath . '\includes\lib\classes\ZenQuery.class';
include_once $rootPath . '\install\utilities\tests\ZenQuery_test.php';
include_once $rootPath . '\install\utilities\tests\ZenDatabase_test.php';


$suite = new PHPUnit_TestSuite('ZenDatabaseTest');
$result = PHPUnit::run($suite);
echo $result->toHTML();

$suite = new PHPUnit_TestSuite('ZenQueryTest');
$result = PHPUnit::run($suite);
echo $result->toHTML();
?>