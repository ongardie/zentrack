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

// ... except the following list
$reservedList = array("Db_Type", "Db_Instance", "Db_Login", "Db_Pass", "Db_Host", "Debug_Mode",
                      "Demo_Mode", "page_prefix", "page_title", "configFile", "system_message_limit");

if (isset($_POST)) {
  foreach ($_POST as $k=>$v) {
    if (!in_array($k, $reservedList)) {
      $$k = $v;
    }
  }
}

if (isset($_GET)) {
  foreach ($_GET as $k=>$v) {
    if (!in_array($k, $reservedList)) {
      $$k = $v;
    }
  }
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
		      "login_language",
		      "project_mode",
		      "ticket_mode");

if( is_array($_SESSION) ) {
  foreach($session_vars as $s) {
    if( strlen($_SESSION["$s"]) ) {
      $$s = $_SESSION["$s"];
    }
    else {
      $$s = "";
    }
  }
}
else if( is_array($HTTP_SESSION_VARS) ) {
  foreach($session_vars as $s) {
    if( strlen($HTTP_SESSION_VARS["$s"]) ) {
      $$s = $HTTP_SESSION_VARS["$s"];
    }
    else {
      $$s = "";
    }
  }
}
else {
  die("Sessions are not enabled properly on this system.  zenTrack is exiting.");
}

// you can't have any spaces after this closing tag!
?>
