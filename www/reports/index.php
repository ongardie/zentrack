<?
  /*
  **  REPORTS INDEX PAGE
  **  
  **  Shows menus for report generation
  **
  */
  
  
  include("reports_header.php");
  $page_title = tr("Usage Reports");
  include("$libDir/nav.php");

  include("$templateDir/reportMenu.php");

  include("$libDir/footer.php");

?>
