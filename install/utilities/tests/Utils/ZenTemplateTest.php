<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenTemplate.php class library
   *
   * Requirements: Relies on config.php in the install/utilities/tests/ folder
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the ZenTemplate.php class methods
   *
   * This test also relies on the ZenTemplateTest.xml file to provide test data
   *
   * This test assumes that a table exists in the database called DBTEST and that the table has been populated
   * which should occur when the database is created with develop=true
   *
   * @package PHPUnit
   */
  class ZenTemplateTest extends Test {

    function ZenTemplateTest() {
      $GLOBALS['templateDir'] = realpath(dirname(__FILE__)).'/templates';
    }


    function testTemplate( $vals ) {
      // create indexed arrays from simple arrays
      foreach( $vals as $key=>$val ) {
        if( is_array($val) && strpos($val[0], "=") > 0 ) {
          $newvals = array();
          foreach($val as $v) {
            list($name,$newval) = explode("=",$v);
            $newvals[$name] = $newval;
          }
          $vals[$key] = $newvals;
        }
      }

      // parse template
      $template = new ZenTemplate( $vals['file'].".template" );    
      $template->values($vals);

      // check results
      $templateResult = $template->process();
      $expectedResult = join('',file( $GLOBALS['templateDir']."/".$vals['file'].".result" ));
      Assert::equals( trim($templateResult), trim($expectedResult), 
                      "Parsed file did not equal expected<hr width='200'><pre>$templateResult</pre>"
                      ."<hr width='200'><pre>$expectedResult</pre>" );
    }

    function moreTestsNeeded() {
      Assert::equalsTrue( false, "Need to add a test for {zen:category:varname}" );
    }

  }

}?>