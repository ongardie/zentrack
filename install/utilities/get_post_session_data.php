<?
 /**
  * Print out all incoming session data
  *
  * @package Devtools
  */
print "<pre>\n";

print "\$_POST: \n";
print_r($_POST);

print "\$_GET: \n";
print_r($_GET);

print "\$_SESSION: \n";
print_r($_SESSION);

print "</pre>\n";
?>
