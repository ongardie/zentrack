<?
  /*
  **  Action: delete contact
  */
  $id = NULL;
  include_once("../header.php");
  $page_title = tr("Agreements");
  $page_section = "Agreements";
  $expand_agreement = 1;
  
  
  include("$libDir/nav.php");


	if(isset($id)){	
      $res = $zen->delete_contact($id,"ZENTRACK_AGREEMENT","agree_id");
      $res = $zen->delete_contact($id,"ZENTRACK_AGREEMENT_ITEM","agree_id");
      print "Deleted agreement ".$id."<br>\n" ; 
	} else {
			print "No agreement selected";
	}
	
  include("$templateDir/agreementView.php");

  include("$libDir/footer.php");
?>
