<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  // this variable must match the full file path location of your zen.ini file
  $ini_file = "/web/phpzen/sub/zentrack_3/includes/config/zen.ini";

  // these lines do not need to be edited
  $zen = parse_ini_file($ini_file,true);
  include($zen['paths']['path_includes']."/lib/inc/global.php");

?>
