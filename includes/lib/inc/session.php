<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  // initialize all session data

  session_start();

  // set up the static data
  if( !isset($_SESSION['loadstat']) ) {
    $_SESSION['loadstat'] = array("settings"=>array(),
                                  "types"=>array(),
                                  "bins"=>array(),
                                  "users"=>array(),
                                  "priorities"=>array(),
                                  "systems"=>array(),
                                  );
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
