<?php
require_once 'PHPUnit.php';

class ZenQueryTest extends PHPUnit_TestCase {
  //Instance of the database class
  var $database;
  var $query;
  
  //Constructor
  function ZenQueryTest($name) {
    $this->PHPUnit_TestCase($name);
  }
  
  //setup
  function setUp() {
    $this->database = new ZenDatabase('mysql', 'localhost', 'root', 'root', 'zentracker');
	$this->query = $this->database->newQuery();
	$this->database->setCacheDirectory('D:\personal\temp\cache');
  }
  
  function tearDown() {
    unset($this->database);
    unset($this->query);
  }
  
  function testTable() {
  	$result = $this->query->table('zentrack_bins');
	$this->assertTrue($result);
  }
  
  function testField() {
  	$result = $this->query->field('name', 'Test Bin 2');
	$this->assertTrue($result);
  }
  
  function testMatch() {
  	$result = $this->query->match('name', 'Test Bin', ZEN_EQ);
	$this->assertTrue($result);
  }
  
  function testExclude() {
  	$result = $this->query->exclude('name', 'Accounting', ZEN_EQ);
	$this->assertTrue($result);
  }
  
  function testBasicWhere() {
  	$result = $this->query->exclude('name', 'Test Bin', ZEN_EQ);
	$this->assertTrue($result);
  }
  
  function testJoin() {
  	$result = $this->query->join('zentrack_access', 'zentrack_bins.bid', 'zentrack_access.bin_id');
	$this->assertTrue($result);
  }
  
  function testLimit() {
  	$result = $this->query->limit(1, 0);
	$this->assertTrue($result);
  }
  
  function testGet() {
  	$result = $this->query->table('zentrack_bins');
  	$result = $this->query->field('name');
  	$result = $this->query->match('name', 'Test Bin', ZEN_EQ);
  	$result = $this->query->exclude('name', 'Accounting', ZEN_EQ);
  	$result = $this->query->join('zentrack_access', 'zentrack_bins.bid', 'zentrack_access.bin_id');
  	$result = $this->query->limit(1, 0);

  	$result = $this->query->get();
	$this->assertTrue($result);	
  }
  
  function testSelect() {
  	$result = $this->query->table('zentrack_bins');
  	$result = $this->query->field('name');
  	$result = $this->query->match('name', 'Test Bin', ZEN_EQ);
  	$result = $this->query->exclude('name', 'Accounting', ZEN_EQ);
  	$result = $this->query->join('zentrack_access', 'zentrack_bins.bid', 'zentrack_access.bin_id');
  	$result = $this->query->limit(1, 0);

  	$result = $this->query->select();
	$this->assertTrue($result);	
  }

  function testInsert() {
  	$result = $this->query->table('zentrack_bins');
  	$result = $this->query->field('name', 'Test Bin 2');

  	$result = $this->query->insert();
	$this->assertTrue($result);	
  }
  
  function testUpdate() {
  	$result = $this->query->table('zentrack_bins');
  	$result = $this->query->field('name', 'Test Bin 3');
  	$result = $this->query->match('name', 'Test Bin 2', ZEN_EQ);
  	$result = $this->query->exclude('name', 'Accounting', ZEN_EQ);
  	$result = $this->query->update();
	$this->assertEquals($result, 1);
  }

  function testReplace() {
  	$result = $this->query->table('zentrack_bins');
  	$result = $this->query->field('name', 'Test Bin 3');
  	$result = $this->query->field('priority', '1');

  	$result = $this->query->replace('name');
	$this->assertEquals(1, $result);
  }

  function testDelete() {
  	$result = $this->query->table('zentrack_bins');
  	$result = $this->query->match('name', 'Test Bin 3', ZEN_EQ);
  	$result = $this->query->delete();
	$this->assertEquals($result, 1);
  }

}

?>