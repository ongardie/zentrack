<?{
   
  /*
  **  CLOSE TICKET
  **  
  **  Close a ticket, or set the status to pending if approval and testing are 
  **  required.
  **
  */

  $action = "close";  
  include("./action_header.php");

  if( $actionComplete == 1 ) {
     $input = array(
		    "id"       => "int",
		    "hours"    => "num",
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
	$res = $zen->close_ticket($id, $login_id, $hours, $comments);
	if( $res ) {
	   add_system_messages("Ticket $id has been closed");
	   header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
	} else {
	   $errs[] = "System error: Ticket $id could not be closed".$zen->db_error;
	}
     }
     if( $errs )
       add_system_messages( $errs, 'Error' );     
  }

  include("$libDir/nav.php");

  if( $actionComplete == 1 )
     $ticket = $zen->get_ticket($id);
  extract($ticket);
  if( strtolower($zen->types["$typeID"]) == "project" ) {
     include("$templateDir/projectView.php");
  } else {
     include("$templateDir/ticketView.php");     
  }

  include("$libDir/footer.php");

}?>
