<?{


  // get action properties
  $action = "contacts";  
  include("../header.php");
  
  // check to insure that this user has access
  // and this ticket allows the requested action
  // to be completed
  $ticket = $zen->get_ticket($id);
  $tid = $ticket["type_id"];
  if( in_array($tid,$zen->projectTypeIDs()) ) {
    $ticket["children"] = $zen->getProjectChildren($id, 
	    array("id,title,status,est_hours,wkd_hours"));
    list($ticket["est_hours"],$ticket["wkd_hours"]) = $zen->getProjectHours($id);
    $page_type = "project";
  }  else {
    $page_type = "ticket";
  }
  $page_mode = "system";

  
  $page_title = tr("Ticket #?", array($id));
  $page_section = "Ticket #$id";
  $expand_tickets = 1;
  
  if( is_array($drops) ) {
    // drop items in list
    $num = 0;
    for($i=0; $i<count($drops); $i++) {
      // clean up numbers just in case
      $n = $zen->checkNum($drops[$i]);
      if( strlen($n) ) {
	// do the drop
	$res = $zen->delete_contact( $n,"ZENTRACK_RELATED_CONTACTS","clist_id");
	// calculate the number of results
	if( $res ) {
	  $num += 1;
	}
      }
    }
    add_system_messages(tr("? are dropped from the contact list", array($num)),"Bold");
    $setmode = "contacts";
  }
  else {
    // create an error message
    $msg = tr("No contacts were selected to drop");
    add_system_messages( $msg, 'Error' );
  }

  
  // display the results
  include("$libDir/nav.php");
  unset($action);
  extract($ticket);
  if( $zen->inProjectTypeIDs($type_id) ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }  
  include("$libDir/footer.php");    

}?>