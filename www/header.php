<?
  
  // zenTrack configuration settings
  // it's a good idea to keep a backup
  // of this file somewhere safe when upgrading!

  /*
  **  NO TRAILING SLASHES
  */

  // the prefix to appear in the browser title
  $page_prefix = "zenTrack | ";

  // the title to appear in the browser title
  $page_title = "Welcome to zenTrack";
  
  // the directory where zentrack includes are stored
  $libDir = "/web/phpzen/sub/devtrack/includes";

  // the directory where zentrack www docs are kept
  $rootUrl = "http://devtrack.phpzen.net";
  
  // the configuration settings for the zenTrack functions
  $configFile = "$libDir/configVars.php";
  
  // the maximum number of system messages to keep in memory
  $system_message_limit = 20;


  /*
  **  LEAVE THIS PART ALONE
  */
  
  include("$libDir/headerInc.php");
  
?>
