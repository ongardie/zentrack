<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  startPTime("environment.php");

  // see if the ini file exists, if not, quit here
  if( !file_exists($ini_file) ) {
    die("The ini file specified in header.php is not readable or missing.  Unable to continue");
  }

  // see if $zen was found in the session, otherwise initialize
  if( $_SESSION['zen'] == null ) {
    $_SESSION['zen'] = Zen::read_ini( $ini_file );
  }

  // check our cached values and make sure things are up to date
  $ft = lastConfigUpdate();
  if( $_SESSION['configLastUpdated'] == null ) {
    $_SESSION['configLastUpdated'] = $ft;
  }
  if( $ft > $_SESSION['configLastUpdated'] || $ft < 1 ) {
    clearZenSessionCache();
    $_SESSION['configLastUpdated'] = $ft;
    $_SESSION['zen'] = Zen::read_ini( $ini_file );
  }
  unset($ft);

  // check the include path
  $p = get_include_path();
  if( !preg_match("/^\.:/", $p) && !preg_match("/:\.:/", $p) ) {
    @set_include_path( $p.":." );
  }
  unset($p);

  // check magic_quotes runtime and magic_quotes_gpc
  @set_magic_quotes_runtime(0);

  // setup develop mode params
  if( getIni('debug','develop_mode') > 0 ) {    
    // turn on on-screen error printing
    ini_set("display_errors", true);

    // turn on most restrictive error_reporting (E_ALL)
    error_reporting(E_ALL);

    // always reload debug.xml
    $_SESSION['cache']['messageListConfig'] = null;
    
    // figure out what to do with magic quotes for testing
    //todo
  }
  else {
    @error_reporting(E_ALL ^ E_NOTICE);
    @ini_set("display_errors", false);
  }

  endPTime( "environment.php" );

}?>
