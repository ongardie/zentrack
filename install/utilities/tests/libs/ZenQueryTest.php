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

    function testNotReady() { Assert::assert( false, "ZenQueryTest not implemented yet" ); }

  }

}?>
