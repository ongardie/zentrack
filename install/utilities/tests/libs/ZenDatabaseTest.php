<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenDatabase.php class library
   *
   * Requirements: Relies on config.php in the install/utilities/tests/ folder
   * 
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the ZenDatabase.php class methods
   *
   * This test unit requires that the Zen.php, ZenDatabase.php, DbTypeInfo.php and adodb libraries be included
   * This test also relies on the ZenDatabaseTest.xml file to provide test data
   *
   * This test assumes that a table exists in the database called DBTEST and that the table has been populated
   * which should occur when the database is created with develop=true
   *
   * @package PHPUnit
   */
  class ZenDatabaseTest extends Test {

    /** @var object ZenDatabase */
    var $_dbo;

    /** XML Db Config info, parsed into node */
    var $_xml;

    function ZenDatabaseTest() {
      $this->getConnection();
    }

    /** Obtain a valid database connection */
    function getConnection() {
      $GLOBALS['dbConnection'] = null;
      $this->_dbo = Zen::getDbConnection();
      // use Assert::assert() here
      Assert::assert( is_object($this->_dbo), "Could not establish a database connection" );
    }

    /** Make sure the connection thinks it is connected */
    function testIsConnected() {
      Assert::equalsTrue( $this->_dbo->isConnected() );
    }

    /** Try to change the prefix and see what happens */
    function testSetAndGetPrefix( $vals ) {
      $old = $this->_dbo->getPrefix();

      // remember to pass some invalid data here
      $this->_dbo->setPrefix($vals['prefix']);

      // test results
      Assert::equals( $vals['prefix'], $this->_dbo->getPrefix() );

      // reset the prefix
      $this->_dbo->setPrefix($old);

      // make sure we have a valid prefix to do other tests
      Assert::assert( $this->_dbo->getPrefix() == $old, "Invalid db prefix, aborting" );
    }   

    /** Compares the db type returned from the object to the $GLOBALS value, which we presume was used to create it */
    function testGetDbType() {
      Assert::equals( $GLOBALS['zen']['db']['db_type'], $this->_dbo->getDbType() );
    }
   
    /** Retrieve the correct xml data file for this db type (specified in $GLOBALS['zen']), parse, and compare to db objects opinion */
    function testGetPreferredCase() {
      // get xml setting
      $this->_getAndParseXML();
      
      $dbi = $this->_xml->getChild('dbInfo',0);
      $xml_node = $dbi->getChild('preferredCase',0);
      $xml_case = $xml_node->getData();

      // get dbo setting
      $dbo_case = $this->_dbo->getPreferredCase();

      // make sure we have valid values
      Assert::equalsTrue( ($xml_case != null && $dbo_case != null), 
                          "One of the preferred case values was null, should not be: [xml-$xml_case/dbo-$dbo_case]" );
      
      // compare
      Assert::equals( $xml_case, $dbo_case ); 
    }
    
    function testGetPrefix() {
      Assert::equals( $GLOBALS['zen']['db']['db_prefix'], $this->_dbo->getPrefix() );
    }

    /** Attempt to set the cache directory and test results */
    function testSetCacheDirectory() {
      // test $GLOBALS['ADODB_CACHE_DIR'] for result
      $oldval = $GLOBALS['ADODB_CACHE_DIR'];

      $bool = $this->_dbo->setCacheDirectory( "invalid_directory" );
      Assert::equals( $GLOBALS['ADODB_CACHE_DIR'], $oldval, "Cache directory set to an invalid directory!" );
      Assert::equalsFalse( $bool, "Return result indicates true, should be false for invalid directory" );

      $d = $GLOBALS['zen']['directories']['dir_logs'];
      $bool = $this->_dbo->setCacheDirectory( $d );
      Assert::equals( $GLOBALS['zen']['directories']['dir_logs'], $GLOBALS['ADODB_CACHE_DIR'], "Could not set cache dir to $d(must be 777)" );
      Assert::equalsTrue( $bool, "Return result indicates false, should be true for valid directory $d");
      
      // remember to reset this
      $this->_dbo->setCacheDirectory( $oldval );
      // just to be sure, fail if other tests can't run
      Assert::assert( $GLOBALS['ADODB_CACHE_DIR'] == $oldval, "Cannot continue, adodb cache is invalid" );
    }

    function testQuote( $vals ) {
      Assert::equalsTrue( false, "This test is not implemented" );
    }

    function testSetFetchMode() {
      $original = $this->_dbo->setFetchMode(false);
      Assert::equals( $this->_dbo->setFetchMode(true), ADODB_FETCH_NUM, "setFetchMode to false failed" );
      Assert::equals( $this->_dbo->setFetchMode($original), ADODB_FETCH_ASSOC, "setFetchMode to true failed" );
    }

    function testNewQuery() {
      $q = $this->_dbo->newQuery();
      Assert::equals( get_class($q), "zenquery" );
    }

    function testExecute( $vals ) {
      // create query statement
      $query = $vals['statement'];
      if( $vals['table'] ) { $query = preg_replace("/\{table\}/", $this->_makeTableName($vals['table']), $query); }        
      $offset = isset($vals['offset'])? $vals['offset'] : 0;
      $this->_dbo->setFetchMode(false);
      $recordSet = $this->_dbo->execute($query, $vals['cache'], $vals['limit'], $offset );
      // check pass or fail results
      if( $vals['passfail'] ) {
        Assert::equalsTrue( $recordSet !== false, 
                            "Query failed, should succeed<br>($query)<br>".$this->_dbo->getErrorMessage() );
      }
      else {
        Assert::equalsTrue( $recordSet === false, "Query passed, expected to faile<br>($query)" );
      }

      if( is_object($recordSet) ) {
        // check returned values
        if( isset($vals['expected_count']) ) {
          $count = $recordSet->RecordCount();
          Assert::equals( $vals['expected_count'], $count, "Count expected[{$vals['expected_count']}] != actual[$count]<br>($query)" );
        }
        if( isset($vals['expected_val']) ) {
          Assert::equals( $recordSet->fields[0], $vals['expected_val'], "Val expected[{$vals['expected_val']}] != actual[{$recordSet->fields[0]}]<br>($query)" );
        }
      }
      else if( isset($vals['expected_count']) || isset($vals['expected_val']) ) {
        Assert::equalsTrue( false, "A value or count was expected, but there was no ResultSet<br>($query)<br>".$this->_dbo->getErrorMessage() );
      }
    }
    
    function testExecuteGetOne( $vals ) {
      // create query statement
      $query = $vals['statement'];
      if( $vals['table'] ) { $query = preg_replace("/\{table\}/", $this->_makeTableName($vals['table']), $query); }        
      //todo fix cache
      $retVal = $this->_dbo->executeGetOne($query, $vals['cache']); //$vals['cache']);
      // check pass or fail results
      if( !$vals['passfail'] ) {
        Assert::equalsTrue( $retVal === false, "Query passed, expected to faile<br>($query)" );
      }
      
      if( strlen($retVal) ) {
        // check returned values
        if( isset($vals['expected_count']) ) {
          Assert::equalsTrue( is_string($retVal) || is_numeric($retVal),
                          "Value returned was not string or number<br>($query)" );
        }
        if( isset($vals['expected_val']) ) {
          Assert::equals( $retVal, $vals['expected_val'], 
                          "Val expected[{$vals['expected_val']}] != actual[{$retVal}]<br>($query)" );
        }
      }
      else if( isset($vals['expected_count']) || isset($vals['expected_val']) ) {
        Assert::equalsTrue( false, "A value or count was expected, but there was no Return Val<br>($query)<br>"
                            .$this->_dbo->getErrorMessage() );
      }
    }

    function testGenerateID( $vals ) {
      // select id from the database and compare to generated
      $table = $this->_dbo->makeTableName($vals['table']);
      $query = "SELECT current_id FROM ".$this->_dbo->makeTableName('TABLE_IDS')
        ." where name_of_table = '{$table}'";
      $maxid = $this->_dbo->executeGetOne($query, false);
      Assert::equalsTrue( ($maxid > 0), 
                          "Could not get max primary_key from database<br>($query)<br>".$this->_dbo->getErrorMessage() );
      
      // generate a new id and compare
      $id = $this->_dbo->generateID( $table );
      Assert::equalsTrue( ($id == $maxid+1), "Generated ID isn't valid(needed ".($maxid+1).", found $id)" );
    }

    function testInsert( $vals ) {
      $this->_clearTable();
      // prefix table
      $table = $this->_dbo->makeTableName($vals['table']);
      // perform insert, check results
      $id = $this->_dbo->generateID( $table );
      $query = $vals['statement'];
      // substitute values for any {...} occurences in statement
      foreach( $vals as $key=>$val ) {
        // there could be table1, table2, etc.. so we do it this
        // way instead of just == "table"
        if( strpos($key, 'table') === 0 ) { $val = $this->_makeTableName($val); }
        $query = str_replace( "{".$key."}", $val, $query );
      }
      $query = str_replace("{key}", $id, $query);
      $result = $this->_dbo->execute($query);
      if( $vals['passfail'] ) {
        Assert::equalsFalse( ($result === false), "Insert failed, expected success<br>($query)<br>".$this->_dbo->getErrorMessage() );
      }
      else {
        Assert::equalsTrue( ($result === false), "Insert did not fail as expected<br>($query)" );
      }
      $this->load( $this->_loaddata );
    }

    function _clearTable() {
      $res = $this->_dbo->execute("DELETE FROM ".$this->_makeTableName("DBTEST"));
      Assert::assert( $res, "Could not clean out DBTEST table" );
    }

    function load( $node ) {
      $this->_loaddata = $node;
      
      Assert::assert( $node, "No load data found, exiting" );

      // clean out table
      $this->_clearTable();

      // perform inserts
      foreach( $node->getChildren() as $childset ) {
        // Extract values from node
        $v = ZenXMLParser::getParmSet( $childset[0]->getChild('param') );
        
        // perform insert, check results
        $id = $this->_dbo->generateID( $this->_dbo->makeTableName($v['table']) );
        $query = $v['statement'];
        // substitute values for any {...} occurences in statement
        foreach( $v as $key=>$val ) {
          if( strpos($key, 'table') === 0 ) { $val = $this->_makeTableName($val); }
          $query = str_replace( "{".$key."}", $val, $query );
        }
        $query = str_replace("{key}", $id, $query);
        $result = $this->_dbo->execute($query);
        Assert::assert( $result, "Could not load data: $query" );
      }
    }

    function testReplace( ) { //$vals ) {
      //todo
      //todo
      //todo
      Assert::equalsTrue( false, "method not implemented" );
    }

    function testTransaction( ) { //$vals ) {
      //todo
      //todo
      //todo
      Assert::equalsTrue( false, "method not implemented" );
    }

    /** Construct a tablename with appropriate prefix and case */
    function _makeTableName( $name ) {
      $pre = $this->_dbo->getPrefix();
      $name = $pre.$name;
      return (strtolower($this->_dbo->getPreferredCase()) != "lower" )? strtoupper($name) : strtolower($name);
    }
    
    /** Parse xml file and load vars into $this->_xml */
    function _getAndParseXML() {
      if( !$this->_xml ) {
        $filename = $GLOBALS['zen']['directories']['dir_classes'].'/db/'.$GLOBALS['zen']['db']['db_type'].'.xml';
        Assert::assert( file_exists($filename), "$filename not found, unable to verify" );
        $parser = new ZenXMLParser();
        $this->_xml =& $parser->parse( join("",file($filename)) );
      }
    }

    /** @var the xml data used to set data for testing */
    var $_loaddata;

  }

}?>
