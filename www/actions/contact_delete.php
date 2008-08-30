<?
  /*
  **  Action: delete contact
  */
  $id = NULL;
  include_once("../contact_header.php");
  $page_title = tr("Contacts");
  $page_section = "Contacts";
  
  if( isset($cid)) {
			$table = "ZENTRACK_COMPANY";
			$col = "company_id";	
			$id = $cid;
	}
	if( isset($pid)) {
			$table = "ZENTRACK_EMPLOYEE";	
			$col = "person_id";
			$id = $pid;
	}

	if(isset($id)){	
      $res = $zen->delete_contact($id,$table,$col);
      if( $res ) { $msg[] = tr("Deleted contact #?",$id); }
      else { $errs[] = "Delete contact failed due to system error"; } 
	} else {
			print "No contact selected";
	}

  $tabel = "ZENTRACK_COMPANY";
  $title = "title";
  $overview = "company";
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);	
  include("$templateDir/contactView.php");
  include("$libDir/footer.php");
?>
