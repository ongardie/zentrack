<?{
   
  /*
  **  YANK TICKET
  **  
  **  Pull a ticket from it's owner
  **
  */

  $action = "yank";  
  include("./action_header.php");

  if( $actionComplete == 1 ) {
     $input = array(
		    "id"       => "int",
		    "comments" => "html"
		    );
     $zen->cleanInput($input);
     $required = array("id");
     foreach($required as $r) {
	if( !$$r ) {
	   $errs[] = " $r is required";
	}
     }
     
     if( !$errs ) {
	$res = $zen->yank_ticket($id, $login_id, $comments);
	if( $res ) {
	   add_system_messages("Ticket $id yanked from ".$zen->formatName($ticket["user_id"]).".");
	   header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
	} else {
	   $errs[] = "System error: Ticket $id could not be yanked.".$zen->db_error;
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
