<?{
   
  /*
  **  REJECT TICKET
  **  
  **  Return a ticket to the sender
  **
  */

  $action = "reject";  
  include("action_header.php");

  if( $actionComplete == 1 ) {
     $input = array(
		    "id"       => "int",
		    "comments" => "html"
		    );
     $zen->cleanInput($input);
     $required = array_keys($input);
     foreach($required as $r) {
	if( !$$r ) {
	   $errs[] = " $r is required";
	}
     }
     
     if( !$errs ) {
	$res = $zen->reject_ticket($id, $login_id, $comments);
	if( $res ) {
	   add_system_messages(tr("Ticket ? was rejected.", array($id)));
	   $setmode = "details";
	   include("../ticket.php");
	   exit;
	   //header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
	} else {
	   $errs[] = tr("System error: Ticket ? could not be rejected", array($id)).$zen->db_error;
	}
     }
     if( $errs )
       add_system_messages( $errs, 'Error' );     
  }

  include("$libDir/nav.php");

  if( $actionComplete == 1 )
     $ticket = $zen->get_ticket($id);
  extract($ticket);
  if( strtolower($zen->types["$type_id"]) == "project" ) {
     include("$templateDir/projectView.php");
  } else {
     include("$templateDir/ticketView.php");     
  }

  include("$libDir/footer.php");

}?>
