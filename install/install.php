#!/usr/bin/php -q
<?{

  /**
   * This initializes and runs ZenTargets, providing proper class inclusion and environemnt checks.
   *
   * The complete list of targets and their parameters is listed in the docs/targets.html.
   *
   * The following special configuration options are available:
   * <ul>
   *   <li>--ini_file=file:  specify an alternate zen.ini (config) file to use (defaults to ./zen.ini)
   *   <li>--supress_confirm: supresses confirm dialog (answers yes to all, needed for cron jobs)
   *   <li>--classdir=dir:  specify location of class files (for development)
   *   <li>--verbose:  show all debug output (for development)
   * </ul>
   *
   * @package Setup
   */

  // get time for performance
  $stime = time();

  // strip the filename from args
  if( count($argv) ) {
    array_shift($argv);
  }

  // set the current directory
  $thisdir = dirname(__FILE__);

  // set default locations
  $ini_file = "$thisdir/zen.ini";
  $class_dir = "../includes/lib/classes";
  $supress = false;
  $verbose = false;

  // strip -- params and set if appropriate
  // we need two arrays because removing elements
  // from first array will change count and
  // cause problems with iterator
  $newvals = array();
  if( !$argv || !count($argv) ) { $argv = array('-help'); }
  if( preg_match('#^(help|list|/h|--help|-h|/\?|/h)$#', $argv[0]) ) {
    $argv[0] = '-help';
  }
  for( $i=0; $i < count($argv); $i++ ) {
    $argv[$i] = trim($argv[$i]);
    if( strpos($argv[$i], '--') === 0 ) {
      $val = explode('=',substr(trim($argv[$i]),2));
      if( $val[0] == 'ini_file' ) { $ini_file = $val[1]; }
      else if( $val[0] == 'classdir' ) { $class_dir = $val[1]; }
      else if( $val[0] == 'supress_confirm' ) { $supress = true; }
      else if( $val[0] == 'verbose' ) { $verbose = true; }
    }
    else { $newvals[] = $argv[$i]; }
  }
  $argv = $newvals;

  /****************************************************
   ***** ENVIRONMENT
   ***************************************************/

  // check php version
  if( $verbose ) { print "Checking php version\n"; }
  if( !version_compare( phpversion(), "4.3.0", ">=" ) ) {
    die("This product requires PHP >= 4.3.0, you have ".phpversion());
  }

  // insure we are using the cli sapi
  if( $verbose ) { print "Checking for cli binary\n"; }
  if( !preg_match("/cli/", php_sapi_name()) ) {
    die("You must use the CLI(command line) binary to execute this script, you are trying to use a ".php_sapi_name()." binary.");
  }

  // check the include path
  if( $verbose ) { print "Insuring . is in path\n"; }
  $p = get_include_path();
  if( !preg_match("/^\.:/", $p) && !preg_match("/:\.:/", $p) ) {
    @set_include_path( $p.(strlen($p)?':':'').'.' );
  }
  unset($p);

  // find the ini file, if none exists, fail
  if( $verbose ) { print "Checking for ini file\n"; }
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
  //
  // Additionally, if the file modification time is greater than the current file
  // time, then we overwrite with newer to prevent confusion during development
  if( $verbose ) { print "Checking critical libraries\n"; }
  $class_files = array('ZenUtils.php','ZenTargets.php');
  foreach($class_files as $c) {
    // try to locate the class files and copy them
    if( @file_exists("$class_dir/$c") && !@file_exists("$thisdir/setup/$c") 
	|| @filemtime("$class_dir/$c") > @filemtime("$thisdir/setup/$c") ) {
      if( $verbose ) { print "  - copying $class_dir/$c to $thisdir/setup/$c\n"; }
      copy("$class_dir/$c", "$thisdir/setup/$c");
    }
    // fail if we couldn't find them
    if( !@file_exists("$thisdir/setup/$c") ) {
      die("ERROR: The required class file $c was not found. "
	  ."Try using --classdir=source_dir/includes/lib/classes.\n");
    }
    include("$thisdir/setup/$c");
  }

  // parse the ini file and set the verbosity of our messages
  if( $verbose ) { print "Parsing ini params\n"; }
  $GLOBALS['zen'] = ZenUtils::read_ini($ini_file);
  $GLOBALS['installMode'] = $verbose? LVL_DEBUG : ($GLOBALS['zen']['debug']['develop_mode']? LVL_WARN : LVL_ERROR);

  // include all appropriate libraries
  if( $verbose ) { print "Including libraries\n"; }
  $dir_classes = $GLOBALS['zen']['directories']['dir_classes'];
  include_once($GLOBALS['zen']['directories']['dir_lib']."/inc/classes.php");
  load_classes($classes_all, $dir_classes);

  // run the targets
  $z = new ZenTargets($GLOBALS['zen'], $supress);

  // prepare to run
  $z->args( $argv );

  // run
  if( $z->run() ) {
    print "\nSUCCESS: All targets completed successfully\n";
  }
  else {
    print "\n\nFAILURE: One or more targets failed\n";
  }

  // print performance time
  print "\n-----------------\nCompleted: ".(time()-$stime)." seconds.\n\n";

}?>
