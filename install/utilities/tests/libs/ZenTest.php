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

    /** Test the getIniVal function, this will create a $_GLOBALS['zen'] object, and parse ini file contents */
    function testGetIniVal( $vals ) {
      $val = Zen::getIniVal( $vals['cat'], $vals['name'] );
      Assert::assert( $val == $vals['expected'], "Expected {$vals['expected']}, found $val" );
    }

    //todo
    //todo create a test for each method... be sure to differentiate between static and non-static methods


  }

}?>
