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

  // strip -- params and set if appropriate
  // we need two arrays because removing elements
  // from first array will change count and
  // cause problems with iterator
  $newvals = array();
  for( $i=0; $i < count($argv); $i++ ) {
    if( strpos(trim($argv[$i]), '--') === 0 ) {
      $val = explode('=',substr(trim($argv[$i]),2));
      if( $val[0] == 'ini_file' ) { $ini_file = $val[1]; }
      else if( $val[0] == 'classdir' ) { $class_dir = $val[1]; }
      else if( $val[0] == 'supress_confirm' ) { $supress = true; }
    }
    else { $newvals[] = $argv[$i]; }
  }
  $argv = $newvals;

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
  $class_files = array('ZenTargets.php', 'ZenUtils.php');
  foreach($class_files as $c) {
    if( !@file_exists("$thisdir/setup/$c") ) {
      // try to locate the class files and copy them
      if( @file_exists("$class_dir/$c") ) {
	copy("$class_dir/$c", "$thisdir/setup/$c");
      }
      // fail if we couldn't find them
      if( !@file_exists("$thisdir/setup/$c") ) {
	die("ERROR: The required class file $c was not found. "
	    ."Try using --classdir=source_dir/includes/lib/classes.\n");
      }
    }
    include("$thisdir/setup/$c");
  }

  $ini_set = ZenUtils::read_ini($ini_file);
  $dir_classes = $ini_set['directories']['dir_classes'];
  include_once($ini_set['directories']['dir_lib']."/inc/classes.php");
  load_classes($classes_all, $dir_classes);

  // run the targets
  $z = new ZenTargets($ini_set, $supress);

  // make sure we have parameters to work with
  if( count($argv) < 1 || (preg_match("/--ini_file=/",$argv[0]) && count($argv) < 2) ) {
    print "Nothing to do: please specify a target\n\n";
    $targets = $z->getValidTargets();
    foreach( $targets as $key=>$val ) {
      print "\t$key - $val\n";
    }
    exit;
  }

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
