<?
  /*
  **  contact DISPLAY PAGE
  **  
  **  Displays a contact to the screen
  **
  */
  
  // include the header file
  if( file_exists("header.php") ) {
    include_once("header.php");
  }
  else if( file_exists("../header.php") ) {
    include_once("../header.php");
  }

  // security measure
  if( $login_level < $zen->settings['level_contacts'] ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }

$id = NULL;
  
  if($pid){
		$table = "ZENTRACK_EMPLOYEE";
		$col = "person_id";
		$id = $pid;
	} elseif($cid) {
		$table = "ZENTRACK_COMPANY";
		$col = "company_id";
		$id = $cid;
	} else {
		include("contacts.php");
    exit;
	}

  /*
  **  GET TICKET INFORMATION
  */
  $page_title = tr("Contact") . " #$id";

  /*
  **  GET PARAMS FOR A Contact
  */
  
  $contacts = $zen->get_contact($id,$table,$col);

  
  $page_section = "Contact $id";
  $expand_contacts = 1;
  
  /*
  ** PRINT OUT THE PAGE
  */ 
  include_once("$libDir/nav.php");

    if( is_array($contacts) ) {
      extract($contacts);
      
      if($pid){
	    	include("$templateDir/contact_personBox.php"); 
	    	if($overview=="tickets") {
          //collect field map info
          $view = 'ticket_list';
          $fields = $map->getFieldMap($view);
		    	//sort tickets
          include("$libDir/sorting.php");
          // collect open tickets
          $tickets = $zen->getTicketsByPerson($id, join(',',$orderby));
					//$tickets = $zen->get_open_tickets($id,"2");
					
          include("$templateDir/listTickets.php");
	    	}
	    	
      } else {
				include("$templateDir/contact_titleBox.php");
			
				if ($overview=="agreement"){
					//show the related agreements
					$parms = array(1 => array(1 => "company_id", 2 => "=", 3 => $id),
													2 => array(1 => "status", 2 => "=", 3 => "1"),												
					);
					$contacts = $zen->get_contacts($parms,"ZENTRACK_AGREEMENT","contractnr asc");	
					if( is_array($contacts) && count($contacts) ) {
	  				include("$templateDir/agreement_list.php");
  				}
				} elseif ($overview=="tickets") {
          //collect field map info
          $view = 'ticket_list';
          $fields = $map->getFieldMap($view);
          // sort tickets
          include("$libDir/sorting.php");
					//show open tickets
					//$tickets = $zen->get_open_tickets($id,"1");
          $tickets = $zen->getTicketsByCompany($id,join(',',$orderby));
					echo "<br>";
          include("$templateDir/listTickets.php");
				} else {
					//show the related contacts
					$parms = array(1 => array(1 => "company_id", 2 => "=", 3 => $id),
					);
					$contacts = $zen->get_contacts($parms,"ZENTRACK_EMPLOYEE","lname asc");	
    			if( is_array($contacts) && count($contacts) ) {
	  				include("$templateDir/contact_list.php"); 
  				}
		  	}
		  }
	   
    } else {
      print "<p class='error'>" . tr("That contact doesn't exist") . "</p>\n";
    }
    
    
   

  include("$libDir/footer.php");
?>
