<?
  /*
  **  Action: delete contact
  */
  $id = NULL;
  include_once("../header.php");
  $page_title = tr("Contacts");
  $page_section = "Contacts";
  $expand_contacts = 1;
  
  
  include("$libDir/nav.php");

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
      print $res? "Deleted contact ".$id."<br>\n" : "Delete contact failed<br>\n"; 
	} else {
			print "No contact selected";
	}
	
$tabel = "ZENTRACK_COMPANY";
$title = "title";
$overview = "company";

  include("$templateDir/contactView.php");

  include("$libDir/footer.php");
?>
