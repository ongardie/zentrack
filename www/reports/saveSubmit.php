<?
  /*
  **  REPORTS INDEX PAGE
  **  
  **  Shows menus for report generation
  **
  */
  
  
  include("./reports_header.php");
  $page_tile = "Usage Reports";

  include("$libDir/nav.php");

  if( !$tempid ) {
    $errs[] = "Processing error: tempid not found\n";
  } else {
    $res = $zen->saveReport($tempid);
    if( $res ) {
      print "<b>Your chart has been saved successfully saved with id: $res</b>\n";
    } else {
      $errs[] = "Chart could not be saved. "
	.(($zen->db_error)?$zen->db_errnum.":".$db_error:"");
    }
  }

  if( $errs ) {
    $zen->printErrors($errs);
  }

  include("$templateDir/reportMenu.php");

  include("$libDir/footer.php");

?>
