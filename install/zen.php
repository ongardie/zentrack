#!/usr/bin/php -q
<?{

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
    @set_include_path( $p.":." );
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

  include("setup/Zen.class");
  include("setup/ZenDatabase.class");
  include("setup/ZenTemplate.class");
  include("setup/ZenTargets.class");

  print `whoami`;

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
