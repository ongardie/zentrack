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
    $select_users = preg_replace("@[^0-9]+@", ",", trim($select_users));    
    if( strlen($select_users) ) {
      $users = explode(",",$select_users);
      $users[] = $login_id;
    } else {
      $users = array($login_id);
    }
    if( !is_array($select_bins) ) {
      $select_bins = "";
    }
    $res = $zen->saveReport($tempid,$select_bins,$users);
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
