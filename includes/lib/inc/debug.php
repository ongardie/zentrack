<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * @package Libs
   *
   * Print debugging information to the screen in a user friendly format.  
   *
   * This page will print all items in ZenMessageList as well as environment settings, php settings,
   * and any pertinent information for use
   */

  print "<p>-------- DEBUG OUTPUT ---------</P>\n";
  print "<ul>\n";

  print "<li>PHP Version: ".phpversion()."<br>\n";
  print "<li>SAPI: ".php_sapi_name()."<br>\n";
  print "<li>Uname: ".php_uname()."<br>\n";
  print "<li>Server: ".$_SERVER['SERVER_SIGNATURE']."<br>\n";
  print "<li>zenTrack Version: ?<br>\n";
  print "<li>magic_quotes_gpc: ".get_magic_quotes_gpc()."<br>\n";
  print "<li>magic_quotes_runtime: ".get_magic_quotes_runtime()."<br>\n";


  // login user info


  // pertinent arrays and info



  //todo
  //todo finish this up
  //todo
  //todo

  
  // print out ZenMessageList
















?>
