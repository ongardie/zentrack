<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  // check and set $_GLOBALS['thisurl'] appropriately
  //todo

  // check and set $_GLOBALS['thisfile'] appropriately
  //todo

  // set up the $zen properties
  $_GLOBALS['zen'] =& $_SESSION['zen'];
  $zen =& $_GLOBALS['zen']; //for convenience

  // set the path variables
  $libDir = $zen['directories']['dir_lib'];
  $includesDir = $zen['paths']['path_includes'];
  $cacheDir = $zen['directories']['dir_cache'];
  $templateDir = $zen['directories']['dir_templates']."/".$zen['layout']['template_set'];
  $classDir = $zen['directories']['dir_classes'];
  $webDir = $zen['paths']['path_www'];
  $webUrl = $zen['paths']['url_www'];

  /**
   * @var array $zen is an array parsed from the php.ini file settings
   */

  $_GLOBALS['templateDir'] = $templateDir;
  $_GLOBALS['dbConnection'] = null;
  $_GLOBALS['messageList'] = null;
  $_GLOBALS['webDir'] = $webDir;
  $_GLOBALS['webUrl'] = $webUrl;
  $_GLOBALS['configLastUpdated'] =& $_SESSION['configLastUpdated'];

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

  // session settings (referenced here for convenience)
  $_GLOBALS['login'] =& $_SESSION['login'];
  $_GLOBALS['cache']['data_types'] =& $_SESSION['cache']['data_types'];
  if( $_GLOBALS['cache']['data_types'] == null ) {
    $_GLOBALS['cache']['data_types'] = array();
    foreach($global_data_types as $t) {
      $_GLOBALS['data_types'][$t] = Zen::loadDataTypeArray($t);
    }
  }
  $_GLOBALS['cache']['settings'] = array();
  $_GLOBALS['cache']['settings']['common'] =& $_SESSION['cache']['common_settings'];
  $_GLOBALS['cache']['MessageListConfig'] =& $_SESSION['cache']['MessageListConfig'];

  // clean up page variables
  $page_title = $zen['layout']['page_title'];
  $page_prefix = $zen['layout']['page_prefix'];
  $errs = array();
  $msg = array();
  
}?>
