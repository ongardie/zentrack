<?

  /*
  **  SESSION TRACKING AND MANAGEMENT
  **
  **  This page, in conjunction with session_save
  **  makes zenTrack register_globals compliant, while
  **  still keeping us from having ugly, lengthy code
  **  from having to turn all the variables into
  **  $_SESSION['variable_name']
  */

  session_start();     
  /*
  ** FIX REGISTER GLOBALS
  */

if( isset($_SERVER) ) {
  extract($_SERVER);
}
if( isset($_POST) ) {
  extract($_POST);
}
if( isset($_GET) ) {
  extract($_GET);
}
  

// this only makes them available for reading.. they still 
// need to be set in $_SERVER
if( isset($_SESSION) )
  extract($_SESSION);

?>
