<?
//if( !$zen->checkAccess($login_id,$ticket["bin_id"],"edit_custom") ) {
//  $errs[] = tr("You cannot edit a ticket's custom fields in this bin ");
//} else if( !$zen->actionApplicable($id,"edit_custom",$login_id) ) {
//  $errs[] = $zen->ptrans("Ticket #? cannot be edited in its current status",array($id));
//}
  $page_title = tr("Ticket #?: Save Custom Fields", array($id));
  $fields = array();
  $required = array();
  // the TODO is saved, even if the save failed
  $TODO = 'SAVED';
                                
  if( !$errs ) {
    $customFieldsArray = $zen->getCustomFields(0,$page_type, 'Custom Tab');
    include("$libDir/parseVarfields.php");
  }

  if( !$errs ) {
    // update the ticket info
    $res = $zen->updateVarfieldVals($id,$varfield_params);
    // check for errors
    if( !$res ) {
      $errs[] = tr("System Error").": ".tr("Ticket could not be edited.")." ".$zen->db_error;
    }
  }

  if( !$errs ) {
    add_system_messages(tr("Variable fields updated: ")." $id.");
    $save_message = tr("Fields updated successfully");
     //header("Location:$rootUrl/ticket.php?id=$id&setmode=Custom");
    $setmode = "custom";
    if( $zen->inProjectTypeIDs($bin_id) ) {
      include("../project.php");
    } else {
      include("../ticket.php");
    }
    exit;
  } else {
     include_once("$libDir/nav.php");
     if( $zen->inProjectTypeIDs($bin_id) )
       include("$templateDir/projectView.php");
     else
       include("$templateDir/ticketView.php");
     include("$libDir/footer.php");
  }
?>
