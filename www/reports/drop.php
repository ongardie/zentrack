<?
  /*
  **  REPORTS DELETE PAGE
  **  
  **  Drops reports from the database
  **
  */
  
  include("./reports_header.php");
  $page_tile = "Drop Template";
  include("$libDir/nav.php");

if( $repid ) {
  // fetch the template so we have some params to use
  $res = $zen->deleteReport($repid);
  print "<b>Report Deleted</b>\n";
}

  include("$templateDir/reportMenu.php");

  include("$libDir/footer.php");

?>
