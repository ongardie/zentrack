<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  // check and set $_GLOBALS['thisurl'] appropriately

  // check and set $_GLOBALS['thisfile'] appropriately

  // set up the $zen properties
  $_GLOBALS['zen'] &= $_SESSION['zen'];
  $zen &= $_GLOBALS['zen']; //for convenience

  // see if $zen was found in the session, otherwise initialize
  if( $zen == null ) {
    $zen = parse_ini_file( $ini_file );
  }

  // set the path variables
  $libDir = $zen['directories']['lib'];
  $includesDir = $zen['paths']['path_includes'];
  $cacheDir = $zen['directories']['cache'];
  $templateDir = $zen['directories']['templates']."/".$zen['layout']['template'];

  $webDir = $zen['paths']['path_www'];
  $webUrl = $zen['paths']['url_www'];

  /**
   * @var array $zen is an array parsed from the php.ini file settings
   */
  $_GLOBALS['libDir'] = $libDir;
  $_GLOBALS['includesDir'] = $includesDir;
  $_GLOBALS['cacheDir'] = $cacheDir;
  $_GLOBALS['templateDir'] = $templateDir;
  $_GLOBALS['dbConnection'] = null;
  $_GLOBALS['messageList'] = null;
  $_GLOBALS['webDir'] = $webDir;
  $_GLOBALS['webUrl'] = $webUrl;

  // set the system params
  $_GLOBALS['data_types'] &= $_SESSION['data_types'];
  $_GLOBALS['settings'] = array();
  $_GLOBALS['settings']['common'] &= $_SESSION['common_settings'];

  $_GLOBALS['login'] &= $_SESSION['login'];
  foreach($global_data_types as $t) {
    if( !count($_GLOBALS['data_types'][$t]) ) {
      $_GLOBALS['data_types'][$t] = Zen::loadDataTypeArray($t);
    }
  }    

  /**
   * @var array $_GLOBALS['cache'] is an array containing various data types which have been loaded for use with static methods
   */
  $_GLOBALS['cache'] = array(
                             "access"  => array(),
                             "action"  => array(),                           
                             "ticket"  => array(),
                             "trigger" => array(),
                             "user"    => array()
                             );

  // clean up page variables
  $page_title = $zen['layout']['page_title'];
  $page_prefix = $zen['layout']['page_prefix'];
  $errs = array();
  $msg = array();
  
}?>
