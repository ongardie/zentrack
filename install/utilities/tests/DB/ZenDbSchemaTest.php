<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenDbSchema.php class file and its methods
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the ZenDbSchema.php class methods
   *
   * This test unit requires that the ZenDbSchema.php, ZenUtils.php, and Zen.php class files be included
   * This test also relies on the testdb.xml and ZenDbSchemaTest.xml file to provide test data
   *
   * @package PHPUnit
   */
  class ZenDbSchemaTest extends Test {

    /** The db schema object */
    var $obj;

    /** Constructor */
    function ZenDbSchemaTest() {
    }

    /** Load config file (gets params from <setup> node) */
    function load( $vals ) {
      $vals = ZenXMLParser::getParmSet( $vals->getChild('param') );
      // delete cache file to make sure it gets created with fresh data
      $this->unload();
      // load the schema
      $this->obj = new ZenDbSchema( dirname(__FILE__).'/'.$vals['xmlfile'], true );
    }

    /** Clear out cached data and reset system */
    function unload() {
      // clear out any cached data
      $cachefile =  ZenUtils::getIni('directories','dir_cache').'/dbSchemaInfo';
      if( file_exists($cachefile) ) {
        unlink(  ZenUtils::getIni('directories','dir_cache').'/dbSchemaInfo'  );
      }
    }

    /** Test the getTable and setTable functions */
    function testAddTable( $vals ) {
      $vals['inherits'] = explode(',',$vals['inherits']);
      $res = $this->obj->addTable($vals['name'], $vals['description'], 
                                  $vals['is_abstract'], $vals['has_custom_fields'], $vals['inherits']);
      Assert::equalsTrue($res, "Table was not added properly");
      if( $res ) {
        $vals['expected'] = true;
        $this->testGetTableArray($vals);
      }
    }

    /** Test the getField and setField functions */
    function testAddColumn( $vals ) {
      // add the column
      $res = $this->obj->addColumn($vals['table'], $vals['name'], $vals['label'], $vals['custom'], 
                                  $vals['type'], $vals['ftype'], $vals);
      if( $vals['expected'] ) {
        // if success is expected then check the values
        Assert::equalsTrue($res, "Field was not added properly");
        if( $res ) {
          $this->testGetFieldArray( $vals );
        }
      }
      else {
        // if failure expected then insure no values exist
        $field = $this->obj->getFieldArray($vals['table'], $vals['name']);
        Assert::equalsFalse($res, "Field was added, but expected fail");
        Assert::equalsFalse(is_array($field), 'getFieldArray() returned value, null expected');
      }
    }

    function testGetFieldArray( $vals ) { 
      // get results
      $field = $this->obj->getFieldArray($vals['table'], $vals['name']);
      if( $vals['expected'] ) {
        // check each field
        foreach( $vals as $key=>$val ) {
          if( $key != 'table' && $key != 'expected' ) {
            Assert::equals($val, $field[$key], "getFieldArray '$val' != '".$field[$key]."' for field {$vals['table']}:$key");
          }
        }
      }
      else {
        Assert::equalsFalse( is_array($field), "Column found, expected none" );
      }
    }

    function testGetTableArray( $vals ) {       
      // get results
      $table = $this->obj->getTableArray($vals['name']);
      if( $vals['expected'] ) {        
        // might need to convert inherits param
        if( is_array($vals['inherits']) ) { $vals['inherits'] = join(',', $vals['inherits']); }
        if( isset($table['inherits']) ) { $table['inherits'] = join(',', $table['inherits']); }
        // test each field
        foreach( $vals as $key=>$val ) {
          if( $key != 'expected' ) {
            Assert::equals($val, $table[$key], "getTableArray '$val' != '".$table[$key]."' for field $key");
          }
        }
      }
      else {
        Assert::equalsFalse( is_array($table), "Table returned, expected none" );
      }
    }

    function testDropTable( $vals ) {
      // see what is in table, then delete, then get it again
      $table = $this->obj->getTableArray($vals['table']);
      $res = $this->obj->dropTable($vals['table']);
      $after = $this->obj->getTableArray($vals['table']);
      if( $vals['exists'] ) {
        // test to make sure valid tables are deleted
        Assert::equalsTrue( is_array($table), "The requested table ({$vals['table']}) was not found" );
        Assert::equalsFalse( is_array($after), "The table ({$vals['table']}) was not deleted" );
        Assert::equalsTrue( $res, "The method did not return true" );
      }
      else {
        // test to make sure invalid tables are not deleted
        Assert::equalsTrue( !is_array($table), "The table ({$vals['table']}) exists, but should not" );
        Assert::equalsFalse( $res, "The method did not return false" );
      }
    }

    function testDropColumn( $vals ) {
      $t = $vals['table'];
      $c = $vals['field'];
      $table = $this->obj->getTableArray($t);
      $res = $this->obj->dropColumn( $t, $c );
      if( $vals['exists'] ) {
        Assert::equalsTrue( isset($table['fields'][$c]), "The requested column does not exist, test will not work properly" );
        Assert::equalsTrue($res, "The column was not dropped as expected");
      }
      else {
        Assert::equalsFalse($res, "The column appears to have been dropped, but was not a valid column");
      }
    }

    function testGetInheritedFields( $vals ) { 
      // get inherited fields
      $fields = $this->obj->getInheritedFields( $vals['table'] );
      if( $vals['expected'] ) {
        // check that the fields returned match what we expected
        $expectedList = explode(',', $vals['fieldnames']);
        Assert::equals( count($expectedList), count($fields), 
                        "Field count (".count($fields).") did not equal expected (".count($expectedList).")" );
        foreach($expectedList as $e) {
          Assert::equalsTrue( isset($fields[$e]), "Should have inherited '$e', but did not" );
        }
      }
      else {
        // if invalid field, make sure result as expected
        Assert::equals( count($fields), 0, 
                        "Empty array expected for return value, recieved count of ".count($fields) );
      }
    }

    function testGetMetaField( $vals ) {
      $fieldObj = $this->obj->getMetaField( $vals['table'], $vals['field'] );
      $fun = $vals['expected']? 'equalsTrue' : 'equalsFalse';
      Assert::equalsTrue( ( !is_object($fieldObj) || get_class($fieldObj) != 'ZenMetaField' ), 
                          "The return data type was not a ZenMetaField: ".$fieldObj );
    }

    function testGetMetaTable( $vals ) {
      $tableObj = $this->obj->getMetaTable( $vals['table'] );
      $fun = $vals['expected']? 'equalsTrue' : 'equalsFalse';
      Assert::equalsTrue( ( !is_object($tableObj) || get_class($tableObj) != 'ZenMetaTable' ), 
                          "The return data type was not a ZenMetaTable: ".$tableObj );
    }

    function testGetTableNames() {
      $names = $this->obj->listTables();
      foreach( $names as $n ) {
        $table = $this->obj->getTableArray($n);
        Assert::equalsTrue( is_array($table) && is_array($table['fields']) );
        foreach( ZenMetaTable::listProperties() as $p ) {
          Assert::equalsTrue( isset($table[$p]) || $table[$p] === null, "The property $p not set for table $n" );
        }
      }
    }

    function testSetColumnProperty( $vals ) {
      $res = $this->obj->setColumnProperty( $vals['table'], $vals['column'], $vals['property'], $vals['newval'] );
      if( $vals['expected'] ) {
        $newvals = $this->obj->getFieldArray($vals['table'], $vals['column']);
        Assert::equalsTrue( $res, "Return value indicates failure" );
        $p = $vals['property'];
        Assert::equals( $vals['newval'], $newvals[$p], "Expected value '{$vals['newval']}', recieved '".$newvals[$p]."'" );
      }
      else {
        Assert::equalsFalse( $res, "Return value indicates success, should have failed" );
      }
    }

    function testSetTableProperty( $vals ) {
      $res = $this->obj->setTableProperty( $vals['table'], $vals['property'], $vals['newval'] );
      if( $vals['expected'] ) {
        $newvals = $this->obj->getTableArray($vals['table']);
        Assert::equalsTrue( $res, "Return value indicates failure" );
        $p = $vals['property'];
        Assert::equals( $vals['newval'], $newvals[$p], "Expected value '{$vals['newval']}', recieved '".$newvals[$p]."'" );
      }
      else {
        Assert::equalsFalse( $res, "Return value indicates success, should have failed" );
      }
    }

  }

}?>
