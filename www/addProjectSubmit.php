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

    // add the ticket to the database
    $indexed_params=array('standard'=>$params,
                          'varfield'=>$varfield_params,
                          'contacts'=>$contacts);
    $errs = $zen->add_new_ticket($id,$indexed_params,'CREATED','',$_POST['notify']);
    if( in_array($params["type_id"],$zen->noteTypeIDs()) ) {
      $zen->close_ticket($id,null,null,'Notes closed automatically');
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
