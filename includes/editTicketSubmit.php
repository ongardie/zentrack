<?
  if( !ZT_DEFINED ) { die("Illegal Access"); }
  
  if( !$zen->checkAccess($login_id,$ticket["bin_id"],"edit") ) {
    $errs[] = tr("You cannot edit a ticket in this bin ");
  } else if( !$zen->actionApplicable($id,"edit",$login_id) ) {
    $errs[] = $zen->ptrans("Ticket #? cannot be edited in its current status",array($id));
  }

  $page_title = tr("Commit Edited Ticket");
  $expand_admin = 1;

  // initiate default values
  if( $deadline ) {
     $deadline = $zen->dateParse($deadline);
  }
  if( $start_date ) {
     $start_date = $zen->dateParse($start_date);
  } 
  if( !$tested )
     $tested = 0;
  if( !$approved )
     $approved = 0;
  if( $type == "project" )
     $type_id = $zen->projectTypeID();

  $is_project = $type == 'project' || $zen->inProjectTypeIds($type_id);
  $view = $is_project? 'project_edit' : 'ticket_edit';

  include("$libDir/validateFields.php");
  
  if( !$errs ) {
     $params = array();
     // create an array of existing fields
     foreach(array_keys($fields) as $f) {
       $params["$f"] = $$f;
     }
     // update the ticket info
     $res = $zen->edit_ticket($id,$login_id,$params,$edit_reason);
     // check for errors
     if( !$res ) {
       $errs[] = tr("System Error").": ".tr("Ticket could not be edited.")." ".$zen->db_error;
     }
     else if( $varfields && count($varfield_params) ) {
       $res = $zen->updateVarfieldVals($id, $varfield_params, $login_id, $bin_id);
       if( !$res ) {
         $errs[] = tr("? updated, but variable fields could not be saved", array(tr($x)));
       }
     }
  }
  
  if( !$errs ) {
    add_system_messages(tr("Edited ticket #?", array($id)));
    //header("Location:$rootUrl/ticket.php?id=$id&setmode=Details");
    $setmode = "Details";
    if( $is_project ) {
      include("../project.php");
    } else {
      include("../ticket.php");
    }
    exit;
  } else {
    $onLoad[] = "behavior_js.php?formset=ticketForm";
    include_once("$libDir/nav.php");
    $zen->print_errors($errs);
    $TODO = 'EDIT';
    if( $is_project ) {
      $view = "project_edit";
    }
    else {
      $view = "ticket_edit";
    }
    include("$templateDir/newTicketForm.php");
    include("$libDir/footer.php");
  }
?>
