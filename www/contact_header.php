<?
  define('ZT_SECTION','contacts');
  if( file_exists("header.php") ) {
    include_once("header.php");
  }
  else {
    require_once("../header.php");
  }
  if( $login_level < $zen->getSetting('level_contacts') ) {
    print("You cannot access contacts");
    exit;
  }
?>