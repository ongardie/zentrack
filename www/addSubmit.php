<?
  /*
  **  NEW TICKET (add submit)
  **  
  **  Commit new ticket to database
  **
  */
  
  
  include_once("./header.php");
  
  if( !$zen->checkAccess($login_id,$bin_id,"create") ) {
    $page_title = tr("Access Error");
    $msg = "<p class='hot'>" . tr("You do not have permission to create tickets in this bin.") . "</p>\n"; 
    include("$libDir/nav.php");     
    include("$libDir/footer.php");
    exit;
  }
  
  $page_title = tr("Commit New Ticket");
  $expand_tickets = 1;
  
  // initiate default values
  $otime = time();  // set time ticket opened
  if( $deadline ) {
    $deadline = $zen->dateParse($deadline);
  }
  if( $start_date ) {
    $start_date = $zen->dateParse($start_date);
  }
  
  $description = $zen->ffv($description);
  
  $fields = array(
  "title"       => "text",
  "priority"    => "int",
  "description" => "ignore",
  "otime"       => "int",
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

  $customFieldsArray = false;
  $customFieldsArray = $map->getFieldMap($type=='project'?'project_create':'ticket_create');

  $required = array();
  foreach($customFieldsArray as $f=>$field) {
    if( $field['is_required'] ) {
      $required[] = $f;
    }
  }

  // $required = array(
  // "title",
  // "priority",
  // "description",
  // "bin_id",
  // "type_id",
  // "system_id"
  // );
  $zen->cleanInput($fields);
  
  // check for required fields
  foreach($required as $r) {
    if( !strlen($$r) ) {
      $errs[] = tr("Required field missing:") . " " . ucfirst($r);
    }
  }
  
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
  
  if( !$errs ) {
    // create an array of existing fields
    // to be inserted for the ticket
    foreach(array_keys($fields) as $f) {
      if( strlen($$f) ) {
        $params["$f"] = $$f;
      }
    }
    $params["creator_id"] = $login_id;
    
    // add the ticket to database
    $id = $zen->add_ticket($params);
    
    // update the variable field entries for this ticket
    if( $id && $customFieldsArray && count($varfield_params) ) {
      $res = $zen->updateVarfieldVals($id, $varfield_params);
      if( !$res ) {
        $errs[] = tr("? created, but variable fields could not be saved", array(tr('Ticket')));
      }      
    }
    
    // check for errors
    if( !$id ) {
      $errs[] = tr("Could not create ticket."). " ".$zen->db_error;
    }
    else if( in_array($params["type_id"],$zen->noteTypeIDs()) ) {
      $zen->close_ticket($id,null,null,'Notes closed automatically');
    }
  }
  
  if( !$errs ) {
    $setmode = "details";
    include("ticket.php");
    exit;
    //header("Location:$rootUrl/ticket.php?id=$id");
  } else {
    $onLoad[] = "behavior_js.php?formset=ticketForm";
    include("$libDir/nav.php");
    $zen->print_errors($errs);
    $view = "ticket_create";
    include("$templateDir/newTicketForm.php");
    include("$libDir/footer.php");
  }
?>
