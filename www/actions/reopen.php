<?{
   
  /*
  **  REOPEN TICKET
  **  
  **  Open a ticket which was closed in error
  **
  */

  $action = "reopen";  
  include("action_header.php");

  if( $actionComplete == 1 ) {
     if( !$tested ) {
	$tested = 0;
     }
     if( !$approved ) {
	$approved = 0;
     }
     $input = array(
		    "id"       => "int",
		    "comments" => "html"
		    );
     $zen->cleanInput($input);
     $required = array("id","comments");
     foreach($required as $r) {
	if( !strlen($$r) ) {
	   $errs[] = " $r is required";
	}
     }
     
     if( !$errs ) {
	$res = $zen->reopen_ticket($id, $login_id, $comments);
	if( $res ) {
	   add_system_messages("Ticket $id was repoened.");
	   $setmode = "details";
	   include("../ticket.php");
	   exit;
	   //header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
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
  if( strtolower($zen->types["$type_id"]) == "project" ) {
     include("$templateDir/projectView.php");
  } else {
     include("$templateDir/ticketView.php");     
  }

  include("$libDir/footer.php");

}?>
