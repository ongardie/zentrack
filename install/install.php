#!/usr/bin/php -q
<?{

  /**
   * This initializes and runs ZenTargets, providing proper class inclusion and environemnt checks.
   *
   * The complete list of targets and their parameters is listed in the docs/targets.html.
   *
   * The following special configuration options are available:
   * <ul>
   *   <li>--ini=filename:  specify an alternate zen.ini (config) file to use (defaults to ./zen.ini)
   *   <li>--s: suppresses confirm dialog (answers yes to all, needed for cron jobs)
   *   <li>--v: verbose: increase message output to screen
   *   <li>--c=type: set compression on data output, null-do not compress(default), zip-use zip compression, 
   *         gzip-use gzip compresion
   *   <li>--classdir=dir:  specify location of class files (for development)
   *   <li>--makeini:  create an ini file then exit (rather than running targets normally)
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
  $suppress = false;
  $verbose = false;
  $compress = null;
  $makeini = false;
  
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
      if( $val[0] == 'ini' ) { $ini_file = $val[1]; }
      else if( $val[0] == 'classdir' ) { $class_dir = $val[1]; }
      else if( $val[0] == 's' ) { $suppress = true; }
      else if( $val[0] == 'v' ) { $verbose = true; }
      else if( $val[0] == 'c' ) { $compress = $val[1]; }
      else if( $val[0] == 'makeini') { $makeini = true; }
      else { print "Invalid modifier ".$argv[$i]."\n"; }
    }
    else {
      $newvals[] = $argv[$i]; 
    }
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
  if( !$makeini && ( !file_exists($ini_file) || !is_readable($ini_file) ) ) {
    print "The ini file ($ini_file) could not be read.\n\n";
    print "You can correct this by doing one of the following:\n";
    print "   - run this script from the same directory as existing zen.ini\n";
    print "   - specify a valid zen.ini file (using --ini=filename)\n";
    print "   - if this is a cvs checkout, run --makeini to create a new ini file\n";
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

  if( $makeini ) {
    if( !@file_exists("$class_dir/smarty/Smarty.class.php") ) {
      die("ERROR: The required class ($class_dir/smarty/Smarty.inc.php) was not found."
	  ."Try using --classdir=source_dir/includes/lib/classes.\n");
    }
    include("$class_dir/smarty/Smarty.class.php");
    include("$class_dir/ZenTemplate.php");
    ZenTargets::makeNewIniFile($class_dir, $thisdir);
    print "Finished, please edit to your needs.\n";
    exit;
  }

  // parse the ini file and set the verbosity of our messages
  if( $verbose ) { print "Parsing ini params\n"; }
  $GLOBALS['zen'] = ZenUtils::read_ini($ini_file);
  $GLOBALS['installMode'] = $verbose? 
    ($GLOBALS['zen']['debug']['develop_mode']? LVL_DEBUG : LVL_NOTE) : 
    ($GLOBALS['zen']['debug']['develop_mode']? LVL_WARN : LVL_ERROR);

  // include all appropriate libraries
  if( $verbose ) { print "Including libraries\n"; }
  $dir_classes = $GLOBALS['zen']['directories']['dir_classes'];
  include_once($GLOBALS['zen']['directories']['dir_lib']."/inc/classes.php");
  load_classes($classes_all, $dir_classes);

  // run the targets
  if( $verbose ) { print "Compression set to ".($compress? $compress : "none"); }
  $z = new ZenTargets($GLOBALS['zen'], $suppress, $compress);

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