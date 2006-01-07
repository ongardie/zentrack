<?
  if( !ZT_DEFINED ) { die("Illegal Access"); }
  
  $page_title = tr("Ticket #?: Save Custom Fields", array($id));
  $fields = array();
  $required = array();
  // the TODO is saved, even if the save failed
  $TODO = 'SAVED';
  
  $type_id = $zen->checkNum($type_id);
  $bin_id = $zen->checkNum($bin_id);

  if( $zen->inProjectTypeIDs($type_id) ) {
    $view="project_custom";
  } else {
    $view="ticket_custom";
  }
  include("$libDir/validateFields.php");
  if( !$errs ) {
    if( count($varfield_params) ) {
      // update the ticket info
      $res = $zen->updateVarfieldVals($id,$varfield_params,$login_id,$bin_id);
    }
    // check for errors
    if( !$res ) {
      $errs[] = tr("System Error").": ".tr("Ticket could not be edited.")." ".$zen->db_error;
    }
  }

/*
  if( !$errs ) {
      $varfields = $zen->getCustomFields(0,$page_type, 'Custom Tab'); 	 
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
*/  
  $setmode = 'custom';

  if( !$errs ) {
    add_system_messages(tr("Variable fields updated: ")." $id.");
    $save_message = tr("Fields updated successfully");
     //header("Location:$rootUrl/ticket.php?id=$id&setmode=Custom");
    $setmode = "custom";
    if( $zen->inProjectTypeIDs($type_id) ) {
      include("../project.php");
    } else {
      include("../ticket.php");
    }
    exit;
  } else {
     include_once("$libDir/nav.php");
     $zen->printErrors($errs);
     if( $zen->inProjectTypeIDs($type_id) )
       include("$templateDir/projectView.php");
     else
       include("$templateDir/ticketView.php");
     include("$libDir/footer.php");
  }
?>
