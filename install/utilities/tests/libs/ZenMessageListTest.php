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
   * Test the ZenMessageList class methods
   *
   * This test requires the Zen.php, ZenMessage.php and ZenMessageList.php libraries.
   * This test also relies on the ZenMessageListTest.xml file for test data
   *
   * @package PHPUnit
   */
  class ZenMessageListTest extends Test {

    /** @var ZenMessageList object */
    var $obj;

    /** @var array of ZenXNode objects, each representing a message to add in the load method */
    var $msgvals;

    function ZenMessageListTest() {
      $this->obj = new ZenMessageList( dirname(__FILE__)."/ZenMessageListTest_config.xml" );
    }
    
    function load( $node = null ) {
      $this->obj->clearMessages();
      if( $node ) { 
        $this->msgvals = $node->getChild('message');
      }
      foreach($this->msgvals as $m) {
        $parms = ZenXMLParser::getParmSet($m->getChild('param'));
        $this->obj->add( $parms['class'], $parms['method'], $parms['message'], 
                         $parms['errnum'], $parms['lvl'] );
      }
    }

    function testAddMessage( $vals ) {
      // store the current count of messages in the list
      $beforecount = $this->obj->count( $vals['lvl'] );
      $beforetotal = $this->obj->count();
      // try to add the item to the list
      $bool = $this->obj->add( $vals['class'], $vals['method'], $vals['message'], $vals['errnum'], $vals['lvl'] );
      if( $vals['expected'] == true ) {
        // check that counts have increased and the method returned true
        $bool = ($bool == true 
                 && $this->obj->count( $vals['lvl'] ) > $beforecount
                 && $this->obj->count() > $beforetotal);
	Assert::equalsTrue( $bool, "{$vals['class']}->{$vals['method']}[{$vals['lvl']}]: failed to add" );
      }
      else {
        // check that counts have not increased and that the method returned false
        $bool = ($bool == false
                 && $this->obj->count( $vals['lvl'] ) == $beforecount
                 && $this->obj->count() == $beforetotal);
	Assert::equalsTrue( $bool, "{$vals['class']}->{$vals['method']}[{$vals['lvl']}]:"
                            ."failed to skip" );
      }
    }

    function testGetArray() {      
      $this->load();
      Assert::equals( count($this->obj->getArray()), count($this->msgvals) );
    }

    function testClearMessages() {
      $this->load();
      Assert::assert( $this->obj->count() > 0, "Messages did not load properly" );
      $this->obj->clearMessages();
      Assert::equals( $this->obj->count(), 0 );
    }

    function testFilter( $vals ) {
      // make sure message list starts empty
      $this->load();

      // get count of messages loaded
      $count1 = $this->obj->count();
      Assert::assert( $this->obj->count() == count($this->msgvals), 
                      "Messages not loaded, check setup node" );
      
      // add some filters and check new count
      $this->obj->filter( $vals['lvl'], $vals['class'], $vals['method'], $vals['errnum'] );
      Assert::equals( $this->obj->count(), $vals['expected'], "Filter count "
                      .$this->obj->count()." != ".$vals['expected'] );
      
      // drop the filters and check count again
      $this->obj->clearFilters();
      Assert::equals( $this->obj->count(), count($this->msgvals),
                      "Clear filters did not reset to start point" );
    }

  }

}?>
