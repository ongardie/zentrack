<?
  /*
  **  REPORTS SAVE SUBMIT
  **  
  **  Saves report templates to database
  **
  */
  
  
  include("reports_header.php");
  $page_title = tr("Save Submit");

  include("$libDir/nav.php");

  if( !$tempid ) {
    $errs[] = tr("Processing error: tempid not found\n");
  } else {
    $select_users = preg_replace("@[^0-9]+@", ",", trim($select_users));    
    if( strlen($select_users) ) {
      $users = explode(",",$select_users);
      if( !in_array($login_id,$users) )
	  $users[] = $login_id;
    } else {
      $users = array($login_id);
    }
    if( !is_array($select_bins) ) {
      $select_bins = "";
    }
    if( $save_method == "new" ) {
      $report_name = strip_tags($report_name);
    } else {
      $report = $zen->getReportParams($report_id);
      $report_name = $report["report_name"];
      $zen->deleteReport($report_id);
    }
    if( !$report_name ) {
      $errs[] = tr("Report Name is required");
    }
    $res = $zen->saveReport($report_name,$tempid,$select_bins,$users);
    if( $res ) {
      print "<b>" . tr("Your chart has been successfully saved with title: ?",array($report_name)) . "</b>\n";
    } else {
      $errs[] = tr("Chart could not be saved.") . " "
	.(($zen->db_error)?$zen->db_errnum.":".$db_error:"");
    }
  }

  if( $errs ) {
    $zen->printErrors($errs);
  }

  include("$templateDir/reportMenu.php");

  include("$libDir/footer.php");

?>
