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
  $view = 'project_create';
  
  // initiate default values
  $otime = date('Y-m-d H:i:s');  // set time ticket opened
  include("$libDir/validateFields.php");

  if( !$errs ) {
    // create an array of existing fields
    foreach(array_keys($fields) as $f) {
      if( strlen($$f) ) {
        $params["$f"] = $$f;
      }
    }
    $params['type_id'] = $zen->projectTypeID();
    $params["creator_id"] = $login_id;
    // add the ticket to db
    $id = $zen->add_ticket($params);
    // check for errors
    if( !$id ) {
      $errs[] = tr("Could not create project.") . " " .$zen->db_error;
    }
    else {
      if( $varfields && count($varfield_params) ) {
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
