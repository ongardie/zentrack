<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Prepares and initializes sitewide variables, global and session arrays
   *
   * @package Libs
   */

  // benchmarking
  startPTime('variables.php');

  // check and set $GLOBALS['thisurl'] appropriately
  //todo

  // check and set $GLOBALS['thisfile'] appropriately
  //todo

  /**
   * @var string $GLOBALS['templateDir'] is the directory location of the template directory to use for this build
   */
  $GLOBALS['rootUrl'] = getini('paths','url_www');
  $GLOBALS['templateDir'] = getini('directories','dir_templates')."/".getini('layout','template_set');
  $GLOBALS['styleSheet'] = getGlobal('rootUrl')."/styles/".getini('layout','template_set').".css";
  
  /**
   * @var array $GLOBALS['tcache'] temporary cache to store ZenDataTypes for life of page
   */
  $GLOBALS['tcache'] = array(
                             "access"   => array(),
                             "action"   => array(),
                             "ticket"   => array(),
                             "trigger"  => array(),
                             "user"     => array(),
                             "settings" => array()
                             );

  /** @var array contains a list of (string)names representing data types which should be stored in the session */
  $common_data_types = array('bin',
                             'priority',
                             'stage',
                             'system',
                             'task',
                             'type',
                             'user'
                             );

  // generate some session settings
  if( getGlobal('cache','data_types') == null ) {
    /** @var array $_SESSION['cache']['data_types'] data types which should not be loaded on each page */
    $_SESSION['cache']['data_types'] = array();
    foreach($common_data_types as $t) {
      $_SESSION['cache']['data_types'][$t] = Zen::loadDataTypeArray($t);
    }
  }
  if( getGlobal('cache','common_settings') == null ) {
    /** 
     * @var array $_SESSION['cache']['common_settings'] associated array of 
     * (string)setting_name => (string)value for common config settings.  
     * The rest are stored in the globals array and regenerated on a page-by-page basis. 
     */
    $_SESSION['cache']['common_settings'] = array();
  }

  // clean up page variables
  $page_title = getini('layout','page_title');
  $page_prefix = getini('layout','page_prefix');
  $errs = array();
  $msg = array();
  
  endPtime('variables.php');

}?>
