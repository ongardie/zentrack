<?{
   
  /*
  **  ASSIGN TICKET
  **  
  **  Make the owner of a ticket the specified user
  **
  */

  $action = "assign";  
  include("./action_header.php");

  if( $actionComplete == 1 ) {
     $input = array(
		    "id"       => "int",
		    "userID"   => "int",
		    "comments" => "html"
		    );
     $zen->cleanInput($input);
     $required = array("userID","id");
     foreach($required as $r) {
	if( !$$r ) {
	   $errs[] = " $r is required";
	}
     }
     
     if( !$errs ) {
	$res = $zen->assign_ticket($id, $userID, $login_id, $comments);
	if( $res ) {
	   add_system_messages("Ticket $id assigned to ".$zen->formatName($userID));
	   header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
	} else {
	   $errs[] = "System error: Ticket $id could not be assigned".$zen->db_error;
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
