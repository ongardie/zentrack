<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Includes and sets up global functions, variables, classes, etc.
   *
   * Includes and sets up global functions, variables, classes, etc.  This is normally the only
   * file in inc/ that needs to be included in control scripts to initialize variables, sessions, libraries, and database.
   * Benchmark times
   * Normally we would use startPTime or endPtime, but here
   * we haven't built those functions yet, so we do the first couple
   * by hand
   *
   * @package Libs
   */

  $GLOBALS['ptimes'] = array('total'=>array(microtime(), null), 'global.php'=>array(microtime(),null));

  // include all global functions
  require_once("$dir_lib/inc/functions.php");

  // include all the object classes
  require_once("$dir_lib/inc/classes.php");
  load_classes( $classes_standard, $dir_classes );
  load_classes( $classes_data_types, $dir_classes );

  // start the session information
  require_once("$dir_lib/inc/session.php");

  // check the php environment settings
  require_once("$dir_lib/inc/environment.php");

  // include all global variables
  require_once("$dir_lib/inc/variables.php");

  endPTime( 'global.php' );
}?>
