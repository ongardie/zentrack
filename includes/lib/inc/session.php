<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  // initialize all session data
  session_start();

  // set the zen variable
  if( !isset($_SESSION['zen']) ) { $_SESSION['zen'] = null; }

  // set up the static data
  if( !isset($_SESSION['data_types']) ) {
    foreach($global_data_types as $t) {
      $_SESSION['data_types'][$t] = array();
    }
  }
    
  // store the common system settings that will be used
  // by most every page
  if( !isset($_SESSION['common_settings']) ) {
    $_SESSION['common_settings'] = null;
  }

  // set up the login data
  if( !isset($_SESSION['login']) ) {
    $_SESSION['login'] = array(
                               "name" => "",
                               "inits" => "",
                               "level" => null,
                               "id" => null,
                               "email" => "",
                               "bins"=> array(),
                               "access" => array()
                               );
  }

}?>
