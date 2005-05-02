<?{
   
  /*
  **  CLOSE TICKET
  **  
  **  Close a ticket, or set the status to pending if approval and testing are 
  **  required.
  **
  */

  $action = "close";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
/*
    $ticket = $zen->get_ticket($id);
    $varfields = $zen->getVarfieldVals($id);
    extract($varfields);
    extract($ticket);
*/
    if (!isset($hours)) $hours=0;
    if (!isset($comments)) $comments="";

    $view = 'ticket_close';
    include("$libDir/validateFields.php");
    
    if( !$errs ) {
      if( $zen->inProjectTypeIDs($ticket["type_id"]) ) {
        $children = $zen->getProjectChildren($id,'id,type,status');
        if( is_array($children) ) {
          foreach($children as $c) {
            if( $c["status"] != "CLOSED" ) {
              $errs[] = tr("? ? is not completed.", array($zen->types[$c['type_id']], $c['id']));
            }
          }
        }
      }
    }
    if( !$errs ) {
     $params = array();
     // create an array of existing fields
     foreach(array_keys($fields) as $f) {
       $params["$f"] = $$f;
     }

      $res = $zen->close_ticket($id, $login_id, $hours, $comments);
      if( !$res ) {
        $errs[] = tr("Could not close ticket."). " ".$zen->db_error;
      } else if( $varfields && count($varfield_params) ) {
        // update the variable field entries for this ticket
        $res = $zen->updateVarfieldVals($id, $varfield_params);
        if( !$res ) {
          add_system_mesages(tr("? ? closed, but variable fields could not be saved", array(tr('Ticket'),$id)));
        } else {
          add_system_messages(tr("Ticket ? has been closed", array($id)));
        }
      }
      $setmode="details";
    }
    if( $errs ) {
      add_system_messages( $errs, 'Error' );
    }
  }

  include("$libDir/nav.php");

  $ticket = $zen->get_ticket($id);
  $varfields = $zen->getVarfieldVals($id);
  extract($varfields);
  extract($ticket);
  if( strtolower($zen->types["$type_id"]) == "project" ) {
     include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  
  include("$libDir/footer.php");
  
}?>
