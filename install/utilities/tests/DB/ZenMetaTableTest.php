<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenMetaTable.php class file and its methods
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the ZenMetaTable.php class methods
   *
   * This test unit requires that the ZenDbSchema.php, ZenUtils.php, Zen.php, ZenDbSchema,
   *    and ZenMetaTable class files be included
   * This test also relies on the ZenMetaTableTest.xml and ZenDbSchema_config.xml files to provide test data
   *
   * @package PHPUnit
   */
  class ZenMetaTableTest extends Test {

    /** The db schema object */
    var $dbSchema;

    /** Constructor */
    function ZenMetaTableTest() { }

    /** Load config file (gets params from <setup> node) */
    function load( $vals ) {
      $vals = ZenXMLParser::getParmSet( $vals->getChild('param') );
      // delete cache file to make sure it gets created with fresh data
      $this->unload();
      // load the schema
      $this->dbSchema = new ZenDbSchema( dirname(__FILE__).'/'.$vals['xmlfile'], true );
    }

    /** Clear out cached data and reset system */
    function unload() {
      // clear out any cached data
      $cachefile =  ZenUtils::getIni('directories','dir_cache').'/dbSchemaInfo';
      if( file_exists($cachefile) ) {
        unlink(  ZenUtils::getIni('directories','dir_cache').'/dbSchemaInfo'  );
      }
    }

    function testCopy( $vals ) {
      if( $vals['expected'] ) {
        $table = new ZenMetaTable( $this->dbSchema->getTableArray( $vals['table'] ) );
      }
      else {
        $table = $vals['table'];
      }
      $newtable = new ZenMetaTable(null);
      $res = $newtable->copy($table);
      if( $vals['expected'] ) {
        Assert::equalsTrue( $res, "Copy failed for {$vals['table']} (should succeed)" );
        if( $res ) {
          $oldfields = $table->getTableArray();
          $newfields = $newtable->getTableArray();
          $eq = ZenUtils::arrayEquals($oldfields, $newfields);
          Assert::equalsTrue( $eq, "The values were not copied correctly" );
          if( !$eq ) {
            $this->printArrayComparisons( $oldfields, $newfields );
          }
        }
      }
      else {
        Assert::equalsFalse( $res, "The return result indicates success (should have failed)" );
      }
    }


    function testNotCompleted( ) { Assert::equalsTrue( false, "More tests to write" ); }


    /** UTILITIES */

    function printArrayComparisons( $arr1, $arr2, $ind = 0, $key = '' ) {
      if( $ind == 0 ) {
        print "array(<ul style='font-size: 90%; margin-left: 20px;'>\n";
      }
      else { 
        if( $key ) { print '"'.$key.'" => '; }
        print "array(<ul style='margin-left:15px'>\n";
      }
      // check count
      if( count($arr1) != count($arr2) ) { print "<b>count does not match</b><br>\n"; }
      // check each element
      $first = true;
      foreach( $arr1 as $key=>$val ) {
        if( is_array($val) && isset($arr2[$key]) ) {
          // recurse if needed
          if( !$first ) { print "<br>\n"; }
          $this->printArrayComparisons($val, $arr2[$key], $ind+1, $key);
        }
        else {
          if( !$first ) { print ", \n"; }
          // test values carefully
          $eq = ZenUtils::safeEquals($val, $arr2[$key]);
          print "$key".($eq? '' : "<font color='red'>[not equal]</font>")."";
          if( !$eq ) {
            // make values something we can display (without notices)
            $d1 = isset($val)? (strlen($val)>10? substr($val,0,10)."...":$val) : "<null>";
            $d2 = isset($arr2[$key])? (strlen($arr2[$key])>10? substr($arr2[$key],0,10)."...":$arr2[$key]) : "<null>";
            // print the values
            print "(<font color='red'>$d1 != $d2</font>)";
          }
          $first = false;
        }
      }
      print "</ul>)<br>\n";
    }

  }

}?>
