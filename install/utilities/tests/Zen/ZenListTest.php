<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenList.php class file and its methods
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
   * This test relies on the ZenListTest.xml 
   * file to provide test data
   *
   * @package PHPUnit
   */
  class ZenListTest extends Test {

    /** Constructor */
    function ZenListTest() {
      //$this->obj = new ZenList();
    }

    /** not ready yet */
    function testNotReady() {
      Assert::assert(false, "Not ready for use yet");
    }

  }

}?>
