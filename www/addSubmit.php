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
    $msg[] = tr("You do not have permission to create tickets in this bin."); 
    include("$libDir/nav.php");     
    include("$libDir/footer.php");
    exit;
  }
  
  $page_type = 'ticket';
  $view = 'ticket_create';
  
  $page_title = tr("Commit New Ticket");
  $expand_tickets = 1;
  
  // initiate default values
  $otime = time();  // set time ticket opened

  include("$libDir/validateFields.php");

  if( !$errs ) {
    // create an array of existing fields
    // to be inserted for the ticket
    foreach(array_keys($fields) as $f) {
      if( $f == 'notify' ) { continue; } //notify list processed seperately
      if( strlen($$f) ) {
        $params["$f"] = $$f;
        if( $f == 'title' && strlen($params["$f"]) > 250 ) {
          $params["$f"] = substr($params["$f"],0,250);
        }
        else if( $f == 'project_id' ) {
          $vs = isset($$f)? (is_array($$f)? $$f : explode(',',$$f)) : array();
          if( in_array($id, $vs) ) {
            $errs[] = "A ticket cannot belong to itself, project id is invalid";
          }
        }
      }
    }
    $params["creator_id"] = $login_id;

    if( !$errs ) {

      // Add the ticket to the database
      $id = 0;
      $indexed_params=array('standard'=>$params,
                            'varfield'=>$varfield_params,
                            'contacts'=>$contacts);
      $errs = $zen->add_new_ticket($id,$indexed_params,'CREATED','',$_POST['notify']);

      // Close the ticket if it is of type "Note"
      if( in_array($params["type_id"],$zen->noteTypeIDs()) ) {
        $zen->close_ticket($id,null,null,'Notes closed automatically');
      }
    } // if( !$errs )
    
  } // if( !$errs )
  
  if( !$errs ) {
    $setmode = null;
    $action = null;
    $ticketTabAction = 0;
    include("ticket.php");
    exit;
    //header("Location:$rootUrl/ticket.php?id=$id");
  } else {
    $onLoad[] = "behavior_js.php?formset=ticketForm&mode=create";
  
    // yahoo libs for addbox
    $ext = $Debug_Mode == 3? "-debug" : "-min";
    $onLoad[] = "js/addBoxFunctions.js";
    // we load them as a single file from the yui network
    $onLoad[] = "http://yui.yahooapis.com/combo?2.5.2/build/yahoo-dom-event/yahoo-dom-event.js&2.5.2/build/connection/connection{$ext}.js&2.5.2/build/json/json{$ext}.js";

    include("$libDir/nav.php");
    $zen->print_errors($errs);
    $view = "ticket_create";
    include("$templateDir/newTicketForm.php");
    include("$libDir/footer.php");
  }
?>
