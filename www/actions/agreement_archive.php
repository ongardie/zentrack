<?

  $id = NULL;
  include_once("../header.php");
  $page_title = tr("Agreements");
  $page_section = "Agreements";
  $expand_agreement = 1;
  
  
  include("$libDir/nav.php");


	if(isset($id)){	

      $params["status"] = $active;
     
      $res = $zen->update_contact($id,$params,"ZENTRACK_AGREEMENT","agree_id");
     
      if( !$res ) {
   			$errs[] = tr("System Error").": ".tr("Agreement could not be archived.")." ".$zen->db_error;
     	} else {
      	print "archived agreement ".$id."<br>\n" ;   
    	}
    
	} else {
			print "No agreement selected";
	}
	
  include("$templateDir/agreementView.php");

  include("$libDir/footer.php");
?>
