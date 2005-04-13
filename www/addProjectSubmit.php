<?
  /*
  **  NEW PROJECT (add submit)
  **  
  **  Commit new project to database
  **
  */
  
  include("header.php");
  
  if( !$zen->checkAccess($login_id,$bin_id,"create") ) {
    $page_title = "Access Error";
    $msg = "<p class='hot'>" . tr("You do not have permission to create tickets in this bin.") . "</p>\n"; 
    include("$libDir/nav.php");     
    include("$libDir/footer.php");
    exit;
  }
  
  $page_title = tr("Commit New Project");
  $expand_projects = 1;
  $page_type = "project";
  
  // initiate default values
  $otime = time();  // set time ticket opened
  if( $deadline ) {
    $deadline = $zen->dateParse($deadline);
  }
  if( $start_date ) {
    $start_date = $zen->dateParse($start_date);
  }
  
  $type_id = $zen->projectTypeID();
  $description = nl2br($zen->ffv($description));
  
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
  
  $req_fields = $map->getFieldMap('project_create');
  $required = array();
  foreach($req_fields as $f=>$field) {
    if( $field['is_required'] ) {
      $required[] = $f;
    }
  }
  
  $zen->cleanInput($fields);
  // check for required fields
  foreach($required as $r) {
    if( !strlen($$r) ) {
      $errs[] = tr("required field missing:") . " " . ucfirst($r);
    }
  }
  if( !$errs ) {
    // create an array of existing fields
    foreach(array_keys($fields) as $f) {
      if( strlen($$f) ) {
        $params["$f"] = $$f;
      }
    }
    $params["creator_id"] = $login_id;
    // add the ticket to db
    $id = $zen->add_ticket($params);
    // check for errors
    if( !$id ) {
      $errs[] = tr("Could not create project.") . " " .$zen->db_error;
    }
    else {
      // parse variable fields which appear in new ticket screen, 
      // store them in $varfield_params
      // insure that all requirements are met before proceeding
      // with the ticket save process
      $customFieldsArray = false;
      if( !$errs ) {
        $customFieldsArray = $zen->getCustomFields(0, 'Project', 'New');
        if( $customFieldsArray && count($customFieldsArray) ) {
          include("$libDir/parseVarfields.php");
        }
      }
      
      if( $customFieldsArray && count($varfield_params) ) {
        $res = $zen->updateVarfieldVals($id, $varfield_params, $login_id, $bin_id);
        if( !$res ) {
          $errs[] = tr("? created, but variable fields could not be saved", array(tr('Project')));
        }
      }      
    }
  }
  
  if( !$errs ) {
    $setmode = "tasks";
    include("project.php");
    exit;
  } else {
    $onLoad[] = "behavior_js.php?formset=ticketForm";
    include("$libDir/nav.php");
    $zen->print_errors($errs);
    $view = "project_create";
    include("$templateDir/newTicketForm.php");
    include("$libDir/footer.php");
  }
?>
