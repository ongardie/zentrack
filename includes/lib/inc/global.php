<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  $global_data_types = array(
                             "bin",
                             "priority",
                             "stage",                                  
                             "system",
                             "task",
                             "type",
                             "user"
                             );

  // start the session information
  require_once("$dir_lib/inc/session.php");

  // include all the object classes
  require_once("$dir_lib/inc/classes.php");

  // include all global functions
  require_once("$dir_lib/inc/functions.php");

  // check the php environment settings
  require_once("$dir_lib/inc/environment.php");

  // include all global variables
  require_once("$dir_lib/inc/variables.php");

}?>
