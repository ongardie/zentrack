<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenDataType.php class
   *
   * Requirements: Relies on config.php in the install/utilities/tests/ folder
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /** This includes test classes used to extend ZenDataType and ZenList for testing */
  include_once( dirname(__FILE__)."/ZenDataTypeTestClasses.php" );

  /**
   * Test the Zen.php class methods
   *
   * This test relies on the ZenDataTypeTest.xml 
   * file to provide test data
   *
   * @package PHPUnit
   */
  class ZenDataTypeTest extends Test {

    /** Constructor */
    function ZenDataTypeTest() {
      $this->_dbo =& Zen::getDbConnection();
    }

    function load( $setupNode ) {
      // add new test data (use devmode so test tables are available */
      $xmlnode = $setupNode->child('xmlfile',0);
      $xmlfile = dirname(dirname(__FILE__))."/DB/".$xmlnode->data();
      $GLOBALS['testingSchemaOverride'] = $xmlfile;
      $dbx = new ZenDBXML($this->_dbo, $xmlfile, true);
      $datadir = dirname(__FILE__)."/datatype_test_data";
      $res = $dbx->loadDatabaseData( $datadir );
      Assert::assert($res[0] == $res[1] && $res[0], "Unable to load test data ($datadir), aborting");
      
      // load the new test data into a ZenList for use
      $this->_list = new ZenDataType_testList();
      $this->_list->load();
    }

    function testGetField( $vals ) {
      $dataTypeObj = $this->_getDataType($vals);
      $val = $dataTypeObj->getField( $vals['field'] );
      if( !$vals['expected'] ) { $vals['value'] = null; }
      Assert::equals( $val, $vals['value'], "Expected {$vals['value']} for field "
                      ."{{$vals['field']}, found {$val}" );
    }

    function testGetMetaInfo( $vals ) {
      $dataTypeObj = $this->_getDataType($vals);
      $info = $dataTypeObj->getMetaInfo();
      $n1 = $dataTypeObj? ZenUtils::tableNameFromClass($dataTypeObj) : 'null';
      $n2 = $info? $info->name() : 'null';
      $v1 = $dataTypeObj && $info && ZenUtils::isInstanceOf('zenmetatable',$info);
      $v2 = ($v1 && strtolower($n1) == strtolower($n2));
      Assert::equalsTrue($v1 && $v2,
                         "Meta field not created properly for field "
                         .$dataTypeObj->getField('field_name').": "
                         .($v1? "'$n1' != '$n2'" : "not a ZenMetaTable object"));
    }

    function testId( $vals ) {
      $dataTypeObj = $this->_getDataType($vals);
      if( $vals['expected'] ) {
        Assert::equals($dataTypeObj->id(), $vals['rowid'], "Field id not equal to {$vals['rowid']}");
      }
      else {
        Assert::equals($dataTypeObj->id(), null, "Field id should not be set, found "
                       .$dataTypeObj->id());
      }
    }

    function testSetField( $vals ) {
      $dataTypeObj = $this->_getDataType($vals);
      $res = $dataTypeObj->setField($vals['field'], $vals['newval']);
      switch($vals['expected']) {
      case 'true':
        Assert::equalsTrue( $res === true, "Expected true, recieved ".($res?'true':'false') );
        break;
      case 'false':
        Assert::equalsTrue( $res === false, "Expected false, recieved ".($res?'true':'false') );
        break;
      case 'error':
        Assert::equalsTrue( is_string($res), "Expected error but recieved {$res} while "
                            ." setting {$vals['field']} to '{$vals['newval']}'" );
        break;
      default:
        Assert::equalsTrue(false, "No 'expected' param");
        break;
      }
      if( $res === true && $vals['expected'] ) {
        $val = $dataTypeObj->getField($vals['field']);
        Assert::equals($val, $vals['newval'], 
                       "getField(): expected '{$vals['newval']} but found {$val}");
      }
    }

    function testIsChanged( $vals ) {
      $dataTypeObj = $this->_getDataType($vals);
      $res = $dataTypeObj->setField($vals['field'], $vals['newval']);
      $v1 = $vals['expected']? 'true' : 'false';
      $v2 = $res? 'true' : 'false';
      Assert::equals($res, $vals['expected'], "Expected '{$v1}', found '{$v2}'");
    }

    function testSave() {
      Assert::equalsTrue(false, "Not ready for use yet");
    }

    function testLoaded() {
      Assert::equalsTrue(false, "Not ready for use yet");
    }

    function _getDataType( $vals ) {
      $list = $vals['uselist']? $this->_list : null;
      return new ZenDataType_test( $vals['rowid'], $list );      
    }

    /**
     * @var ZenDatabase $_dbo database connection
     * @access private
     */
    var $_dbo;

    /** 
     * @var ZenDataType_testList $_list The list of all data from DataType_test table 
     * @access private
     */
    var $_list;

  }


}?>
