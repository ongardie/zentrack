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

// start the session
session_start();     

// dump the system variables for use
if( isset($_SERVER) ) {
  extract($_SERVER);
}
if( isset($_POST) ) {
  extract($_POST);
}
if( isset($_GET) ) {
  extract($_GET);
}

// initialize values we need
$session_vars = array("login_name",
		      "login_id",
		      "login_level",
		      "login_inits",
		      "login_bin",
		      "login_mode",
		      "login_messages",
		      "project_mode",
		      "ticket_mode");
foreach($session_vars as $s) {
  if( !isset($_SESSION) || !count($_SESSION) || !isset($_SESSION["$s"] ) )
    $_SESSION["$s"] = "";
}
  
// this only makes them available for reading.. they still 
// need to be set in $_SERVER before we close up the page
extract($_SESSION);


?>
