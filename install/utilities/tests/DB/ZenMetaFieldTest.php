<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenMetaField.php class file and its methods
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the ZenMetaField.php class methods
   *
   * This test unit requires that the ZenDbSchema.php, ZenUtils.php, Zen.php,
   * ZenDbSchema, ZenMetaTable, and ZenMetaField class files be included
   * This test also relies on the ZenMetaFieldTest.xml and ZenDbSchema_config.xml files to provide test data
   *
   * @package PHPUnit
   */
  class ZenMetaFieldTest extends Test {

    /** The db schema object */
    var $_schema;

    /** Constructor */
    function ZenMetaFieldTest() { }

    /** Load config file (gets params from <setup> node) */
    function load( $vals ) {
      $vals = ZenXMLParser::getParmSet( $vals->child('xmlfile',0) );
      // delete cache file to make sure it gets created with fresh data
      $this->unload();
      // load the schema
      $this->_schema = new ZenDbSchema( dirname(__FILE__).'/'.$vals['xmlfile'], true );
    }

    /** Clear out cached data and reset system */
    function unload() {
      // clear out any cached data
      ZenMetaDb::clearCacheInfo();
    }

    

    function testNotCompleted( ) { Assert::equalsTrue( false, "More tests to write" ); }

  }

}?>
