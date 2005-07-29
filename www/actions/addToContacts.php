<?{

  /**
   **  ADD ENTRIES TO NOTIFY LIST
   **  
   **  Checks for duplicates and adds users/email addresses
   **  to a ticket's notify list
   */
  
  $action = "contacts";
  include_once("../contact_header.php");
  
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
  
  if( $actionComplete == 1 ) {
    $priority = 1;
    // clean input vars
    $cp_id = null;
		$type = null;

    if($company_id==0 && $person_id==0) {
      $errs[] = tr("You must select a Company or Person.");
    }
    
    if($company_id) {
    $cp_id = $company_id;
	  $type = "1";  
	  }
	  
	  if($person_id) {
    $cp_id = $person_id;
	  $type = "2";  
	  }

    if( !$errs ) {
      
      $params = array("type"   => $type,
          "cp_id"  => $cp_id,
          "ticket_id" => $id);
          
      $res = $zen->add_contact( $params,"ZENTRACK_RELATED_CONTACTS");

    }
  }

      if( !empty($res)) {
  				add_system_messages(tr("? contact added to #?.", array($i, $id)));
  				$setmode = "contacts";
				}
    if( $errs ){
      add_system_messages( $errs, 'Error' );     
  }
  
  include("$libDir/nav.php");
  
  $page_mode="system";
  $setmode = 'system';
  
  extract($ticket);
  if( strtolower($zen->types["$type_id"]) == "project" ) {
	  
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  
  include("$libDir/footer.php");

}?>
