<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * This file defines the location of the zen.ini file and the location of the lib and classes
 * directories.
 *
 * DO NOT MODIFY THIS FILE!!
 *
 * Instead, modify the zen.ini file, find the install.php program, and run:
 *   install.php -config_updated
 */

  // this variable must match the full file path location of your zen.ini file
  $ini_file = "{$ini_file|default:"$dir_config/zen.ini"}";

  // lib directory, must match the path to includes/lib
  $dir_lib = "{$dir_lib}";

  // class directory, must match path to includes/lib/classes
  $dir_classes = "{$dir_classes}";

  // these lines do not need to be edited
  include("$dir_lib/inc/global.php");

?>
