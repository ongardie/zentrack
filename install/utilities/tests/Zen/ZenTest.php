<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the Zen.php class file and its methods
   *
   * Requirements: Relies on config.php in the install/utilities/tests/ folder
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the Zen.php class methods
   *
   * This test unit requires that the Zen.php class file be included
   * This test also relies on the ZenTest.xml file to provide test data
   *
   * @package PHPUnit
   */
  class ZenTest extends Test {

    var $obj;

    /** Constructor */
    function ZenTest() {
      $this->obj = new Zen();
    }

    /** Test the method for getting db connections, make sure it returns the same one each time */
    function testGetDbConnection() {
      $conn =& Zen::getDbConnection();
      $conn2 =& Zen::getDbConnection();
      if( !is_object($conn) || !is_object($conn2) || !get_class($conn) == "ZenDatabase" ) {
        Assert::equalsTrue( false, "Could not instantiate ZenDatabase object" );
      }
      else {
        Assert::equals( $conn->randomNumber, $conn2->randomNumber, "ZenDatabase object is not static" );
      }
    }

    /** Test the method for getting a message list, make sure it returns static instance */
    function testGetMessageList() {
      $list1 =& Zen::getMessageList();
      $list2 =& Zen::getMessageList();
      if( !is_object($list1) || !is_object($list2) || !get_class($list1) == "ZenMessageList" ) {
        Assert::equalsTrue( false, "Could not instantiate ZenMessageList object" );
      }
      else {
        Assert::equals( $list1->randomNumber, $list2->randomNumber, "ZenMessageList object is not static" );
      }
    }

    /** 
     * Test method to get ZenMetaTable object and insure it returns static instance 
     *
     * The following params should be passed:
     * <code>
     *   <param name='class'>name_of_class</param> (the class name to get meta data for)
     *   <param name='expected'>table_name</param> (the table we expect to recieve meta data for)
     *   <param name='makeclass' eval='true'>boolean</param> (if true, passes a class instance instead of string)
     * </code>
     */
    function testGetMetaData( $vals ) {
      Assert::equalsTrue( class_exists($vals['class']), "The class requested ({$vals['class']} doesn't exist" );
      if( $vals['makeclass'] ) {
        $n = $vals['class'];
        $obj = new $n();
      }
      else {
        $obj = $vals['class'];
      }
      $res = Zen::getMetaData( $obj );
      if( !ZenUtils::isInstanceOf("ZenMetaTable",$res) ) {
        Assert::equalsTrue( false, "Could not instantiate ZenMetaTable" );
      }
      else {
        $b = strtolower($res->name()) == strtolower(ZenUtils::tableNameFromClass($vals['class']));
        Assert::equalsTrue( $b, "Table name ".$res->name()." != "
                            .ZenUtils::tableNameFromClass($vals['class']) );
      }
    }

    function testNotComplete() { Assert::assert( false, "Not yet completed" ); }
  }

}?>
