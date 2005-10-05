<?
if( !ZT_DEFINED ) { die("Illegal Access"); }


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
session_cache_limiter('public'); 
session_start();     

if( $_GET['clear_session_cache'] ) {
  session_unset();
}

// ... except the following list
$reservedList = array("libDir", "rootUrl", "rootWWW",
		      "Db_Type", "Db_Instance", "Db_Login", "Db_Pass", "Db_Host", 
		      "Debug_Mode", "Demo_Mode", "Debug_Overview", 
		      "page_prefix", "page_title", "page_section", 
		      "configFile", "system_message_limit", 
		      "login_id", "login_level", "login_inits", "login_bin", 
		      "login_language", "login_name");

// dump the system variables for use
if( isset($_SERVER) ) {
   extract($_SERVER);
}

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
  foreach($_COOKIE as $k=>$v) {
    if( !in_array($k,$reservedList) ) {
      $$k = $v;
    }
  }
}

// fix $SCRIPT_NAME for some php binary installations
// which use /bin/php as the SCRIPT_NAME rather
// than the actual script
if( (isset($PHP_SELF)&&strlen($PHP_SELF)) 
    && (!isset($SCRIPT_NAME)||strpos($SCRIPT_NAME,".php") === false) ) {
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
  $vals = $_SESSION;
  foreach($session_vars as $k) {
    $$k = isset($vals[$k])? $vals[$k] : null;
  }
}
else if( is_array($HTTP_SESSION_VARS) ) {
  $vals = $HTTP_SESSION_VARS;
  foreach($session_vars as $k) {
    $$k = isset($vals[$k])? $vals[$k] : null;
  }
}
else {
  die("Sessions are not enabled properly on this system.  zenTrack is exiting.");
}

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// you can't have any spaces after this closing tag!
?>