<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the Zen.php class file and its methods
   *
   * Requirements: Relies on config.php in the install/utilities/tests/ folder
   *
   * @package PHPUnitTests
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /** Find the class files needed */
  include_once($_SESSION['zen']['directories']['dir_classes']."/Zen.php");

  /**
   * Test the Zen.php class methods
   *
   * @package PHPUnitTests
   */
  class ZenTest extends Test {

    var $obj;

    function ZenTest() {
      $this->obj = new Zen();
    }

    function testGetIniVal( $vals ) {
      $val = Zen::getIniVal( $vals['cat'], $vals['name'] );
      Assert::assert( $val == $vals['expected'], "Expected {$vals['expected']}, found $val" );
    }

    //todo
    //todo create a test for each method... be sure to differentiate between static and non-static methods


  }

}?>
