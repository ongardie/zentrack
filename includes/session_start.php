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
if( isset($_COOKIE) ) {
  extract($_COOKIE);
}

// fix $SCRIPT_NAME for some php binary installations
// which use /bin/php as the SCRIPT_NAME rather
// than the actual script
if( (isset($PHP_SELF)&&strlen($PHP_SELF)) 
    && (!isset($SCRIPT_NAME)||strpos(".php",$SCRIPT_NAME) === false) ) {
  $SCRIPT_NAME = $PHP_SELF;
}

// Initialize values we need
$session_vars = array("login_name",
		      "login_id",
		      "login_level",
		      "login_inits",
		      "login_bin",
		      "login_mode",
		      "login_messages",
		      "project_mode",
		      "ticket_mode");

if( is_array($_SESSION) ) {
  extract($_SESSION);
}
else if( is_array($HTTP_SESSION_VARS) ) {
  extract($HTTP_SESSION_VARS);
}
else {
  die("Sessions are not enabled properly on this system.  zenTrack is exising.");
}

// you can't have any spaces after this closing tag!
?>
