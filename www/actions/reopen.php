<?{
   
  /*
  **  REOPEN TICKET
  **  
  **  Open a ticket which was closed in error
  **
  */

  $action = "reopen";  
  include("./action_header.php");

  if( $actionComplete == 1 ) {
     if( !$tested ) {
	$tested = 0;
     }
     if( !$approved ) {
	$approved = 0;
     }
     $input = array(
		    "id"       => "int",
		    "tested"   => "int",
		    "approved" => "int",
		    "comments" => "html"
		    );
     $zen->cleanInput($input);
     $required = array("id","comments","tested","approved");
     foreach($required as $r) {
	if( !strlen($$r) ) {
	   $errs[] = " $r is required";
	}
     }
     
     if( !$errs ) {
	$res = $zen->reopen_ticket($id, $login_id, $tested, $approved, $comments);
	if( $res ) {
	   add_system_messages("Ticket $id was repoened.");
	   header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
	} else {
	   $errs[] = "System error: Ticket $id could not be reopened.".$zen->db_error;
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
