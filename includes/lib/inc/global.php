<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  // performance marks
  $GLOBALS['ptimes'] = array('total'=>array(microtime(), null), 'global.php'=>array(microtime(),null));

  $global_data_types = array(
                             'bin',
                             'priority',
                             'stage',
                             'system',
                             'task',
                             'type',
                             'user'
                             );

  // include all global functions
  require_once("$dir_lib/inc/functions.php");

  // start the session information
  require_once("$dir_lib/inc/session.php");

  // include all the object classes
  require_once("$dir_lib/inc/classes.php");

  // check the php environment settings
  require_once("$dir_lib/inc/environment.php");

  // include all global variables
  require_once("$dir_lib/inc/variables.php");

  endPTime( 'global.php' );
}?>
