<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenQuery.php class library
   *
   * Requirements: Relies on config.php in the install/utilities/tests/ folder
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the ZenQuery.php class methods
   *
   * This test unit requires that the Zen.php, ZenDatabase.php, DbTypeInfo.php, ZenQuery.php and adodb libraries be included
   * This test also relies on the ZenQueryTest.xml file to provide test data
   *
   * This test assumes that a table exists in the database called DBTEST and that the table has been populated
   * which should occur when the database is created with develop=true
   *
   * @package PHPUnit
   */
  class ZenQueryTest extends Test {

    function ZenQueryTest() {
    }

    function load( $node ) {
      list($tableNode,) = $node->child('table');
      $table = $tableNode->data();
      $inserts = $node->child('insert');

      // clear test table
      $query = Zen::getNewQuery();
      $query->table($table);
      $query->delete();

      // load test data
      foreach( $inserts as $i ) {
        $params = ZenXmlParser::getParmSet($i->child('param'));
        $query = Zen::getNewQuery();
        $query->table($table);
        $query->setPrimaryKey();
        foreach($params as $key=>$val) {
          $query->field( $key, $val, $table );
        }
        $res = $query->insert();
        Assert::assert( $res, "query->load: Insert failed:<br>(".$query->getQueryString().")" );
      }      
    }

    /**
     * There is only one function to test ZenQuery methods, it accepts the following xml input params:
     *
     * <code>
     *  <param name='table'>table_name</>
     *  <param name='field'>field_name</param>
     *  <param name='value'>field_name:the value of the field</param>
     *  <param name='match'>field_name:{ZEN_EQ|ZEN_CONTAINS|etc...}:string[:table_name]</match>
     *  <param name='exclude'>field_name:{ZEN_EQ|ZEN_CONTAINS|etc...}:string[:table_name]</match>
     *  <param name='method'>{get|select|insert|update|delete|replace=field}</param>
     *  <param name='passfail' eval='true'>boolean</param> (whether this query should succeed or fail)
     *  <param name='limit'>integer</param> (optional)
     *  <param name='offset'>integer</param> (optional, only useful with limit)
     *  <param name='sort'>field</param> (optional, can be a comma separated list, or multiple param tags)
     *  <param name='rsort'>field</param> (desc sort, optional,  can be a comma separated list, or multiple param tags)
     *  <param name='join'>table1,table2,field1[,field2]</param> (optional)
     *  <param name='primarykey'[ eval='true']>field_name</param> (optional, use null and eval=true to test auto-generate)
     *  <param name='expected'>value</param> (optional, required for method=get, return value of first row, first column)
     *  <param name='count'>integer</param> (number of rows that should be returned, optional)
     * </code>
     */
    function testquery( $vals ) {
      // get a query
      $query = Zen::getNewQuery();
      Assert::assert( is_object($query), "Could not initialize ZenQuery object" );

      // set properties of query
      foreach($vals as $key=>$val) {
        switch($key) {
        case "rsort":
          if( !is_array($val) ) { $val = explode(',',$val); }
          foreach($val as $v) { $query->sort( $v, true ); }
          break;
        case "sort":
          if( !is_array($val) ) { $val = explode(',',$val); }
          foreach($val as $v) { $query->sort( $v ); }
          break;
        case "match":
        case "exclude":
          if( !is_array($val) ) { $val = array($val); }
          foreach( $val as $v ) {
            $set = explode(':',$v);
            if( !isset($set[3]) ) { $set[3] = null; }
            $query->$key( $set[0], constant($set[1]), $set[2], $set[3] );
          }
        case "table":
        case "field":
          if( !is_array($val) ) { $val = array($val); }
          foreach( $val as $v ) {
            $query->$key( $v, null, $vals['table'] );
          }
          break;
        case "value":
          if( !is_array($val) ) { $val = array($val); }
          foreach( $val as $v ) {
            list($field,$entry) = explode(":",$v,2);
            $query->field($field, $entry, $vals['table']);
          }
          break;
        case "limit":
          $query->limit( $val, isset($vals['offset'])? $vals['offset']:null );
          break;
        case "join":
          if( !is_array($val) ) { $val = array($val); }
          foreach($val as $v) {
            $set = explode(',',$v);
            if( !isset($set[3]) ) { $set[3] = null; }
            $query->join($set[0], $set[1], $set[2], $set[3]);
          }
        case "primarykey":
          $zen->setPrimaryKey($val);
          break;
        }
      }

      // execute
      $m = $vals['method'];
      switch($m) {
      case "replace":
        list(,$v) = explode('=',$vals['method']);
        $retval = $query->replace( $v );
        break;
      default:
        $retval = $query->$m();
      }

      $query = $query->getQueryString();

      // test passfail
      if( !$vals['passfail'] ) {
        Assert::equalsTrue( $retval === false || (is_array($retval) && count($retval)===0), "Expected to fail, but did not<br>($query)" );
      }
      else if( (isset($vals['count']) || isset($vals['expected'])) && !$retval && !is_array($retval) ) {
        Assert::equalsTrue( false, "A return value/count was expected, but not recieved<br>($query)" );
      }
      else {
        if( $vals['method'] == 'get' ) {
          Assert::equals( $retval, $vals['expected'] );
        }
        else {
          // test count
          if( isset($vals['count']) ) {
            Assert::equalsTrue( (is_array($retval) && count($retval) == $vals['count']), 
                                "Return count [".(is_array($retval)? count($retval):0)."] not equal to expected [{$vals['count']}]"
                                ."<br>($query)" );
          }

          // test value
          if( isset($vals['expected']) ) {
            Assert::equalsTrue( (is_array($retval) && $retval[0][0] == $vals['expected']),
                                "Return value [".(is_array($retval)? $retval[0][0]:'<undefined>')
                                ."] not equal to expected [{$vals['expected']}]"
                                ."<br>($query)" );
          }
        }
      }
    }

    function testNeedsJoin() { Assert::equalsTrue( false, "need to add a join test" ); }

    function testNeedsAffectedRows() { Assert::equalsTrue( false, "need to test different counts of update and delete" ); }

  }

}?>