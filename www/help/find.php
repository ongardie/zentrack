<?
  // forward to correct help section based on language in use
  $b = dirname(__FILE__);
  include("$b/help_header.php");
  $s = $zen->checkAlphaNum($_GET['s']);
  $p = $zen->checkAlphaNum($_GET['p']);
  if( @file_exists("$helpDir/$s/$p.php") ) {
    include("$helpDir/$s/$p.php");
  }
  else {
    print "<b>Sorry, not found</b>\n"; 
  }
?>