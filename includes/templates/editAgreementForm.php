<?
  $skip = 0;
  
  $agreement = $zen->get_contact($id,"ZENTRACK_AGREEMENT","agree_id");
  //print_r($contact);
    if( !is_array($agreement) ) {
      $errs[] = tr("Contact #? could not be found",array($id));
    } else {
      $skip = 1;
      
      extract($agreement);
      
      $description = preg_replace("@<br ?/?>@","",$description); 
      
			include("$templateDir/newAgreementForm.php");

  	} 
  if( !$skip ) {
    $zen->printErrors($errs);
  }
?>