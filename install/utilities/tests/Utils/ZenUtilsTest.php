<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenUtils.php class library
   *
   * Requirements: Relies on config.php in the install/utilities/tests/ folder
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the ZenUtils.php class methods
   *
   * This test also relies on the ZenUtilsTest.xml file to provide test data
   *
   * This test assumes that a table exists in the database called DBTEST and that the table has been populated
   * which should occur when the database is created with develop=true
   *
   * @package PHPUnit
   */
  class ZenUtilsTest extends Test {

    //    function testNotReady() { Assert::assert( false, "ZenUtilsTest not implemented yet" ); }
   
    function testClassNameFromTable( $vals ) { 
      $result = ZenUtils::classNameFromTable( $vals['table'] );
      Assert::equals( $result, $vals['expected'] );
    }

    /** Test the getIni function, this will create a $_GLOBALS['zen'] object, and parse ini file contents */
    function testGetIni( $vals ) {
      $val = ZenUtils::getIni( $vals['cat'], $vals['name'] );
      Assert::equals( $val, $vals['expected'], "Expected {$vals['expected']}, found $val" );
    }

    function testConvertSecondsTo( $vals ) {
      $result = ZenUtils::convertSecondsTo( $vals['seconds'], $vals['period'] );
      Assert::equals( $result, $vals['expected'], "result ($result) != expected ({$vals['expected']})."
                      ."<br> seconds = {$vals['seconds']}, period = {$vals['period']}" );
    }

    function testSecondsIn( $vals ) {
      $result = ZenUtils::secondsIn( $vals['period'], $vals['num'] );
      Assert::equals( $result, $vals['expected'] );
    }

    function notReadyYet() { Assert::equalsTrue( false, "Not done yet" ); }

  }

}?>