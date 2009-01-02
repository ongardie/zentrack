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
    $msg[] = tr("You do not have permission to create tickets in this bin.");
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
      if( $f == 'notify' ) { continue; } //notify is processed separately
      if( strlen($$f) ) {
        $params["$f"] = $$f;
      }
    }
    $params['type_id'] = $zen->projectTypeID();
    $params["creator_id"] = $login_id;
    $params['status'] = 'OPEN';
/*
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
      if( in_array($params["type_id"],$zen->noteTypeIDs()) ) {
        $zen->close_ticket($id,null,null,'Notes closed automatically');
      }      
    }
*/

    $indexed_params=array('standard'=>$params,
                          'varfield'=>$varfield_params,
                          'contacts'=>$contacts);
    $errs = $zen->add_new_ticket($id,$indexed_params);
    if( in_array($params["type_id"],$zen->noteTypeIDs()) ) {
      $zen->close_ticket($id,null,null,'Notes closed automatically');
    }
    
    if( !$errs && $id && !empty($_POST['notify']) ) {
      $emails = explode("\t", $_POST['notify']);
      // notify recipients to add
      foreach($emails as $e) {
        if( strpos($e, '|') > 0 ) {
          list($n,$e) = explode("|", $e);
          $parms = array('name'=>$n, 'email'=>Zen::checkEmail($e));
        }
        else {
          $parms = array('email'=>Zen::checkEmail($e));
        }
        $zen->add_to_notify_list($id, $parms);
      }
    }    
  }
  
  if( !$errs ) {
    $setmode = '';
    $action = '';
    include("project.php");
    exit;
  } else {
    $onLoad[] = "behavior_js.php?formset=ticketForm";

    // yahoo libs for addbox
    $ext = $Debug_Mode == 3? "-debug" : "-min";
    $onLoad[] = "js/addBoxFunctions.js";
    // we load them as a single file from the yui network
    $onLoad[] = "http://yui.yahooapis.com/combo?2.5.2/build/yahoo-dom-event/yahoo-dom-event.js&2.5.2/build/connection/connection{$ext}.js&2.5.2/build/json/json{$ext}.js";

    include("$libDir/nav.php");
    $zen->print_errors($errs);
    include("$templateDir/newTicketForm.php");
    include("$libDir/footer.php");
  }
?>
