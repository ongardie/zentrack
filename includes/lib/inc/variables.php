<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  // check and set $GLOBALS['thisurl'] appropriately
  //todo

  // check and set $GLOBALS['thisfile'] appropriately
  //todo

  // set up the $zen properties
  $GLOBALS['zen'] =& $_SESSION['zen'];

  // set the path variables
  extract( getini('paths') );
  extract( getini('directories') );
  $templateDir = getini('directories','dir_templates')."/".getini('layout','template_set');
  

  /**
   * @var array $zen is an array parsed from the php.ini file settings
   */

  $GLOBALS['templateDir'] = $templateDir;
  $GLOBALS['dbConnection'] = Zen::getDbConnection();
  $GLOBALS['messageList'] = Zen::getMessageList();
  $GLOBALS['configLastUpdated'] =& $_SESSION['configLastUpdated'];

  /**
   * @var array $GLOBALS['cache'] is an array containing various data types which have been loaded for use with static methods
   */
  $GLOBALS['cache'] = array(
                             "access"  => array(),
                             "action"  => array(),                           
                             "ticket"  => array(),
                             "trigger" => array(),
                             "user"    => array()
                             );

  // session settings (referenced here for convenience)
  $GLOBALS['login'] =& $_SESSION['login'];
  $GLOBALS['cache']['data_types'] =& $_SESSION['cache']['data_types'];
  if( getGlobal('cache','data_types') == null ) {
    $GLOBALS['cache']['data_types'] = array();
    foreach($global_data_types as $t) {
      $GLOBALS['cache']['data_types'][$t] = Zen::loadDataTypeArray($t);
    }
  }
  $GLOBALS['cache']['settings'] = array();
  $GLOBALS['cache']['settings']['common'] =& $_SESSION['cache']['common_settings'];
  $GLOBALS['cache']['MessageListConfig'] =& $_SESSION['cache']['MessageListConfig'];

  // clean up page variables
  $page_title = getini('layout','page_title');
  $page_prefix = getini('layout','page_prefix');
  $errs = array();
  $msg = array();
  
}?>
