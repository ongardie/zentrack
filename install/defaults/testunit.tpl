<?{ /* -*- Mode: C; c-basic-indent: 2; indent-tabs-mode: nil -*- ex: set tabstop=2 expandtab: */ 

  /**
   * Test the <<$class>>.php class file and its methods
   *
   * Requirements: Relies on config.php in the install/utilities/tests/ folder
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the <<$class>>.php class methods
   *
   * This test relies on the <<$class>>Test.xml 
   * file to provide test data
   *
   * Essentially any node in the xml file which
   * matches the name of a test method here will be
   * parsed, and all param tags will be set into
   * an array mapped (String)param_name => (mixed)value
   * and then passed as $vals to the test method.
   *
   * @package PHPUnit
   */
  class <<$class>>Test extends Test {

    /** Constructor */
    function <<$class>>Test() {
      ZenUtils::prep("<<$class>>");
      //$this->obj = new <<$class>>();
    }
	
    /** 
     * Special load instructions
     * @param ZenXNode $xnode
     */
    //function load( $xnode ) {
    //  ..do something here..
    //}

<<foreach item=item from=$methods>>
    function <<$item>>( $vals ) {
      Assert::equalsTrue(false, 'write me');
    }
<</foreach>>

  }

}?>
