<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  startPTime('variables.php');

  // check and set $GLOBALS['thisurl'] appropriately
  //todo

  // check and set $GLOBALS['thisfile'] appropriately
  //todo

  // set the path variables
  extract( getini('paths') );
  extract( getini('directories') );
  $templateDir = getini('directories','dir_templates')."/".getini('layout','template_set');
  

  $GLOBALS['templateDir'] = &$templateDir;

  /**
   * @var array $GLOBALS['tcache'] temporary cache to store ZenDataTypes for life of page
   */
  $GLOBALS['tcache'] = array(
                             "access"  => array(),
                             "action"  => array(),                           
                             "ticket"  => array(),
                             "trigger" => array(),
                             "user"    => array()
                             );

  // generate some session settings
  if( getGlobal('cache','data_types') == null ) {
    $_SESSION['cache']['data_types'] = array();
    foreach($global_data_types as $t) {
      $_SESSION['cache']['data_types'][$t] = Zen::loadDataTypeArray($t);
    }
  }

  // clean up page variables
  $page_title = getini('layout','page_title');
  $page_prefix = getini('layout','page_prefix');
  $errs = array();
  $msg = array();
  
  endPtime('variables.php');

}?>
