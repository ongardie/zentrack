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

  /** Find the class files we need to run this */
  include_once($_SESSION['zen']['directories']['dir_classes']."/Zen.php");
  include_once($_SESSION['zen']['directories']['dir_classes']."/ZenMessage.php");
  include_once($_SESSION['zen']['directories']['dir_classes']."/ZenMessageList.php");

  /**
   * Test the ZenMessageList class methods
   *
   * @package PHPUnitTests
   */
  class ZenMessageListTest extends Test {

    var $obj;

    function ZenMessageListTest() {
      $this->obj = new ZenMessageList( dirname(__FILE__)."/ZenMessageListTest_config.xml" );
      $this->obj->add( $this, 'ZenMessageListTest', 'Constructed new list for testing', 00, 3 );
    }

    function testAddAMessage( $vals ) {
      $bool = $this->obj->add( $vals['class'], $vals['method'], $vals['message'], $vals['errnum'], $vals['lvl'] );
      if( $vals['expected'] == true ) {
	Assert::equalsTrue( $bool, "{$vals['class']}->{$vals['method']}:{$vals['message']}" );
      }
      else {
	Assert::equalsFalse( $bool, "{$vals['class']}->{$vals['method']}:{$vals['message']}" );
      }
    }

    function testFilter( $vals ) {
      //todo

      //todo clearFilters() when done
    }

    function testGetArray( $vals ) {
      //todo
    }

    function testClearMessages() {
      //todo
    }

    //todo
    //todo create a test for each method... be sure to differentiate between static and non-static methods


  }

}?>
