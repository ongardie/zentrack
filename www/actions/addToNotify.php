<?{

  /**
   **  ADD ENTRIES TO NOTIFY LIST
   **  
   **  Checks for duplicates and adds users/email addresses
   **  to a ticket's notify list
   */
  
  $action = "notify";  
  include("./action_header.php");
  
  if( $actionComplete == 1 ) {
    $ticket_id = $id;
    $priority = 1;
    // clean input vars
    $users = null;
    if( strlen($user_accts) ) {
      $users = split("[, \n]+", $user_accts);
    }
    if( strlen($unreg_name) ) {
      $unreg_name = strip_tags($unreg_name);
    }
    if( strlen($unreg_email) ) {
      $unreg_email = $zen->checkEmail($unreg_email);
    }
    
    if( !count($users) 
	&& (!strlen($unreg_name)||!strlen($unreg_email)) 
	&& !strlen($company_id) && !strlen($person_id) ) {
      $errs[] = tr("You must provide at least one registered user, or a valid name and email address");
    }
    
    if( !$errs ) {
      $i = 0;
      if( count($users) ) {
	foreach($users as $u) {
	  if( !$zen->check_user_id($u) ) {
	    $errs[] = tr("? was not a valid user id", array($u));
	  } else {
	    $params = array("user_id"   => $u,
			    "priority"  => $priority,
			    "ticket_id" => $ticket_id);
	    $res = $zen->add_to_notify_list($ticket_id, $params);
	    if( $res && $res != "duplicate" ) {
	      $i++;
	    }
	    else if( $res && $res == "duplicate" ) {
	      add_system_messages(tr("user_id ? already on notify "
				     ."list for #?", array($u, $ticket_id)));        
	    }
	  }
	}
      }
      if( strlen($unreg_name) && strlen($unreg_email) ) {
	$params = array("name"      => $unreg_name,
			"email"     => $unreg_email,
			"priority"  => $priority,
			"ticket_id" => $ticket_id);
	$res = $zen->add_to_notify_list($ticket_id,$params);
	if( $res && $res != "duplicate" ) {
	  $i++;
	}
	else if( $res && $res == "duplicate" ) {
	  add_system_messages(tr("email ? already on notify "
				 ."list for #?", array($unreg_email, $ticket_id)));        
	}
      }
      if(strlen($company_id) || strlen($person_id)) {
	
	$name = null;
	$email = null;
	
	if( !$errs ) {
	  if($company_id) {
	    $data = $zen->get_contact($company_id,"ZENTRACK_COMPANY","company_id");
	    $name = $data["title"]." ".$data["office"];
	    $email= $data["email"]; 
	  }
	  
	  if($person_id) {
	    $data = $zen->get_contact($person_id,"ZENTRACK_EMPLOYEE","person_id");
	    $name = $data["fname"]." ".$data["lname"]; 
	    $email= $data["email"];  
	  }	 
	  
	  if( strlen($name) && strlen($email) ) {
	    $params = array("name"      => $name,
			    "email"     => $email,
			    "priority"  => $priority,
			    "ticket_id" => $ticket_id);
	    $res = $zen->add_to_notify_list($ticket_id,$params);
	    if($res)$i++;
	  }
	}
      }		
      
      
      if( $i > 0 ) {
	add_system_messages(tr("? entries added to #? notification.", array($i, $ticket_id)));
	$setmode = "notify";
      } else {
	$errs[] = tr("System error: Notify list could not be updated ").$zen->db_error;
      }
    }
    if( $errs )
      add_system_messages( $errs, 'Error' );     
  }
  
  include("$libDir/nav.php");
  
  if( strtolower($zen->types["$type_id"]) == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  
  include("$libDir/footer.php");

}?>
