<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * @package Libs
   *
   * Includes and sets up global functions, variables, classes, etc.  This is normally the only
   * file in inc/ that needs to be included in control scripts to initialize variables, sessions, libraries, and database.
   */

  /** 
   * benchmark times
   *
   * normally we would use startPTime or endPtime, but here
   * we haven't built those functions yet, so we do the first couple
   * by hand
   */
  $GLOBALS['ptimes'] = array('total'=>array(microtime(), null), 'global.php'=>array(microtime(),null));

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
