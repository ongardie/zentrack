<?php
require_once 'PHPUnit.php';

class ZenDatabaseTest extends PHPUnit_TestCase {
  //Instance of the database class
  var $database;
  
  //Constructor
  function ZenDatabaseTest($name) {
    $this->PHPUnit_TestCase($name);
  }
  
  //setup
  function setUp() {
    $this->database = new ZenDatabase('mysql', 'localhost', 'root', 'root', 'zentracker');
	$this->database->setCacheDirectory('D:\personal\temp\cache');
  }
  
  function tearDown() {
    unset($this->database);
  }
  
  //newQuery()
  function testNewQuery() {
  	$query = $this->database->newQuery();
	$expectedType = 'object';
	
	$this->assertType($expectedType, $query);
  }
  
  function testExecute() {
    $result = $this->database->execute("SELECT * FROM zentrack_access", 5);
	
	$this->assertTrue($result);
  }
  
  function testExecuteGetOne() {
  	$result = $this->database->executeGetOne("SELECT name, priority FROM zentrack_bins", 5);
	
	$this->assertEquals('Accounting', $result);
  }
  
  function testReplace() {
  	$fields = array(
		'bid' => 22,
		'name' => 'test',
		'priority' => 0,
		'active' => 1
	);
    $result = $this->database->replace('zentrack_bins', $fields, 'bid');
	$this->assertEquals(2, $result);

    $result = $this->database->replace('zentrack_bins', $fields, 'bid');
	$this->assertEquals(1, $result);
  }
  
  function testQuote() {
  	$string = "this string's bad";
	$result = $this->database->quote($string);
	
	$this->assertEquals("'this string\\'s bad'", $result);
  }
  
  function testAffectedRows() {
  	$this->database->execute("DELETE FROM zentrack_bins WHERE bid='22'");
	$result = $this->database->affectedRows();
	
	$this->assertEquals($result, 1);
  }
  
  function testGenerateID() {
  	$result = $this->database->generateID('seq_table1');
	$this->assertEquals(1, $result);
  	$result = $this->database->generateID('seq_table1');
	$this->assertEquals(2, $result);
  }
  
  function test_connect() {
  	$result = $this->database->_connect();
	$this->assertTrue($result);
  }
} 

?>