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

    function testParseBoolean( $vals ) {
      $result = ZenUtils::parseBoolean( $vals['value'], $vals['default'] );
      $rs=ZenUtils::boolString($result);
      $es=ZenUtils::boolString($vals['expected']);
      Assert::equals( $result, $vals['expected'], "Expected {$es}, found {$rs}" );
    }

    function testParseDate( $vals ) {
      $locale = mktime(0, 0, 0, 1, 1, 1970);
      $result = ZenUtils::parseDate( $vals['date'], $vals['eurodates'] );
      if ( is_bool($vals['expected']) ) {
        $es = ZenUtils::boolString($vals['expected']);
      }
      else {
        $es = $vals['expected'];
      }
      if ( is_bool($result) ) {
        $rs = ZenUtils::boolString($result);
      }
      else {
        if ( $result > -1 ) {
          $result -= $locale;
        }
        $rs = $result;
      }
      Assert::equals( $result, $vals['expected'], "Expected {$es}, found {$rs}" );
    }

    function testDateDiff( $vals ) {
      $result = ZenUtils::dateDiff( $vals['start'], $vals['end'], $vals['period'] );
      if ( is_bool($vals['expected']) ) {
        $es=ZenUtils::boolString($vals['expected']);
      }
      else {
        $es=$vals['expected'];
      }
      if ( is_bool($result) ) {
        $rs=ZenUtils::boolString($result);
      }
      else {
        $rs=$result;
      }
      Assert::equals( $result, $vals['expected'], "Expected {$es}, found {$rs}" );
    }


    function testSafeEquals( $vals ) {
      $result = ZenUtils::safeEquals( $vals['val1'], $vals['val2'] );
      if ( is_bool($vals['expected']) ) {
        $es = ZenUtils::boolString($vals['expected']);
      }
      else {
        $es = $vals['expected'];
      }
      if ( is_bool($result) ) {
        $rs = ZenUtils::boolString($result);
      }
      else {
        $rs = $result;
      }
      Assert::equals( $result, $vals['expected'], "Expected {$es}, found {$rs}" );
    }

    function testCleanPath( $vals ) {
      $result = ZenUtils::cleanPath( $vals['dir'] );
      $expected = $vals['expected'];
      Assert::equals( $result, $vals['expected'], "Expected {$expected}, found {$result}" );
    }

    function testDateFallsOn( $vals ) {
      $result = ZenUtils::dateFallsOn( $vals['utime'], $vals['step'], $vals['period'], $vals['base'] );
      if ( is_bool($vals['expected']) ) {
        $es = ZenUtils::boolString($vals['expected']);
      }
      else {
        $es = $vals['expected'];
      }
      if ( is_bool($result) ) {
        $rs = ZenUtils::boolString($result);
      }
      else {
        $rs = $result;
      }
      Assert::equals( $result, $vals['expected'], "Expected {$es}, found {$rs}" );
    }

    function testFfv() {
      $text = "abc&aacute;xyz";
      $expe = "abc&amp;aacute;xyz";
      $result = ZenUtils::ffv( $text );
      Assert::equals( $result, $expe, "Expected {$expe}, found {$result}" );
      $text = "<body>";
      $expe = "&lt;body&gt;";
      $result = ZenUtils::ffv( $text );
      Assert::equals( $result, $expe, "Expected {$expe}, found {$result}" );
      $text = "\"";
      $expe = "&quot;";
      $result = ZenUtils::ffv( $text );
      Assert::equals( $result, $expe, "Expected {$expe}, found {$result}" );
    }

    function testPrintArray ( $vals ) {
      if ( $vals['items'] == 0 ) {
        $val=$vals['elem'];
      }
      else if ( $vals['items'] > 0 ) {
        for ($i=0; $i<$vals['items']; $i++) {
          $val[$i]=$vals['elem'];
        }
      }
      else {
        $val=null;
      }
      $result = ZenUtils::printArray( $val, $vals['title'] );
      if ( is_bool($vals['expected']) ) {
        $es = ZenUtils::boolString($vals['expected']);
      }
      else {
        $es = $vals['expected'];
      }
      if ( is_bool($result) ) {
        $rs = ZenUtils::boolString($result);
      }
      else {
        $rs = $result;
      }
      Assert::equals( $result, $vals['expected'], "Expected {$es}, found {$rs}" );
    }



    function notReadyYet() { Assert::equalsTrue( false, "Not done yet" ); }

  }

}?>
