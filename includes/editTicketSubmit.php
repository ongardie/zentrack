<?

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
  if( $type == "project" && !$type_id )
     $type_id = $zen->projectTypeID();

  $is_project = $type == 'project' || $zen->inProjectTypeIds($type_id);

  $fields = array(
        "title"       => "text",
        "priority"    => "int",
        "description" => "html",
        "bin_id"       => "int",
        "type_id"      => "int",
        "user_id"      => "int",
        "system_id"    => "int",
        "tested"      => "int",
        "approved"    => "int",
        "relations"   => "text",
        "project_id"   => "int",
        "est_hours"   => "num",
        "deadline"    => "int",
        "start_date"  => "int"
        );
 // $required = array(
         // "title",
         // "priority",
         // "description",
         // "bin_id",
         // "type_id",
         // "system_id"
         // );

  $customFieldsArray = false;
  $customFieldsArray = $map->getFieldMap($type=='project'?'project_edit':'ticket_edit');

  $required = array();
  foreach($customFieldsArray as $f=>$field) {
    if( $field['is_required'] ) {
      $required[] = $f;
    }
  }
         
  $zen->cleanInput($fields);
  // check for required fields
  foreach($required as $r) {
     if( !$$r ) {
   $errs[] = ucfirst($r)." ".tr("is a required field");
     }
  }
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
     else {
       // parse variable fields which appear in new ticket screen, 
       // store them in $varfield_params
       // insure that all requirements are met before proceeding
       // with the ticket save process
       if( !$errs ) {
         foreach(array_keys($customFieldsArray) as $f) {
           if (strncmp($f,"custom_",7)!=0) {
             unset($customFieldsArray["$f"]);
           }
         }
         if( $customFieldsArray && count($customFieldsArray) ) {
           include("$libDir/parseVarfields.php");
         }
       }
       
       if( $customFieldsArray && count($varfield_params) ) {
         $res = $zen->updateVarfieldVals($id, $varfield_params, $login_id, $bin_id);
         if( !$res ) {
           $errs[] = tr("? updated, but variable fields could not be saved", array(tr($x)));
         }
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
