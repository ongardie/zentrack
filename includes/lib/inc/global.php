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
  require_once("$libDir/inc/session.php");

  // include all the object classes
  require_once("$libDir/inc/classes.php");

  // include all global functions
  require_once("$libDir/inc/functions.php");

  // check the php environment settings
  require_once("$libDir/inc/environment.php");

  // include all global variables
  require_once("$libDir/inc/variables.php");

}?>
