<?
  // forward to correct help section based on language in use
  $b = dirname(__FILE__);
  include("$b/help_header.php");
  $s = $zen->checkAlphaNum($_GET['s']);
  $p = $zen->checkAlphaNum($_GET['p']);
  include("$helpDir/$s/$p.php");
?>