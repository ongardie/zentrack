#!/usr/bin/php -q
<?{

  /**
   * @package Setup
   *
   *  This initializes and runs ZenTargets, providing proper class inclusion and environemnt checks.
   */

  // get time for performance
  $stime = time();

  // strip the filename from args
  if( count($argv) ) {
    array_shift($argv);
  }

  /****************************************************
   ***** ENVIRONMENT
   ***************************************************/

  // check php version
  if( !version_compare( phpversion(), "4.3.0", ">=" ) ) {
    die("This product requires PHP >= 4.3.0, you have ".phpversion());
  }

  // insure we are using the cli sapi
  if( !preg_match("/cli/", php_sapi_name()) ) {
    die("You must use the CLI(command line) binary to execute this script, you are trying to use a ".php_sapi_name()." binary.");
  }

  // check the include path
  $p = get_include_path();
  if( !preg_match("/^\.:/", $p) && !preg_match("/:\.:/", $p) ) {
    @set_include_path( $p.(strlen($p)?':':'').'.' );
  }
  unset($p);

  // find out where class files are (check for a local file directing, or assume ../includes/lib/classes)
  //todo


  // make sure we have parameters to work with
  if( count($argv) < 1 || (preg_match("/--ini_file=/",$argv[0]) && count($argv) < 2) ) {
    print "Nothing to do: please specify a target\n\n";
    exit;
  }

  // check and make sure we have a valid ini file
  if( preg_match("/--ini_file=([^ ])/",$argv[0],$matches) ) {
    $ini_file = $matches[1];
  }
  else {
    $ini_file = "zen.ini";
  }

  // find the ini file, if none exists, fail
  if( !file_exists($ini_file) || !is_readable($ini_file) ) {
    print "The ini file ($ini_file) could not be read.\n\n";
    print "You must either run this script from the same directory as the zen.ini file,";
    print "or specify a valid ini file\n\n";
    exit;
  }

  /*************************************************
   ****** PROCESS
   ************************************************/

  // We include the classes in such a roundabout way because the first time we
  // call this install prog there may not be any class file, so we will have to
  // copy them.  This should only ever happen during development.
  $thisdir = dirname(__FILE__);
  $class_files = array('Zen.php', 'ZenDatabase.php', 'ZenTemplate.php', 'ZenTargets.php', 'ZenUtils.php');
  foreach($class_files as $c) {
    if( !@file_exists("$thisdir/setup/$c") ) {
      if( $argv[0] != '-copy_class_files' &&
	  ($argv[1] != '-copy_class_files' || !(strpos($argv[0], '--') === 0)) ) {
	die("ERROR: The required class file $c was not found, try running 'zen.php -copy_class_files'\n");
      }
    }
    else {
      include("$thisdir/setup/$c");
    }
  }

  // run the targets
  $z = new ZenTargets();
  $z->args( $argv );
  if( $z->run() ) {
    print "\nSUCCESS: All targets completed successfully\n";
  }
  else {
    print "\n\nFAILURE: One or more targets failed\n";
  }

  // print performance time
  print "\n-----------------\nCompleted: ".(time()-$stime)." seconds.\n\n";

}?>
