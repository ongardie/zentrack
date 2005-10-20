<?

  $id = NULL;
  include_once("../contact_header.php");
  $page_title = tr("Agreements");
  $page_section = "Agreements";
  $expand_agreement = 1;
  
	if(isset($id)){	
    $params["status"] = $active;
    $res = $zen->update_contact($id,$params,"ZENTRACK_AGREEMENT","agree_id");
    if( !$res ) {
      $errs[] = tr("System Error").": ".tr("Agreement could not be archived.")." ".$zen->db_error;
    } else {
      $msg = "Archived agreement #$id";
    }
	} else {
	  $errs[] = "No agreement selected";
	}
	
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include("$templateDir/agreementView.php");
  include("$libDir/footer.php");
?>
