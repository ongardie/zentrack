<?{
   
  /*
  **  TEST TICKET
  **  
  **  Set testing status to completed for a ticket.
  **
  */

  $action = "test";  
  include("action_header.php");

  if( $actionComplete == 1 ) {
     $input = array(
		    "id"       => "int",
		    "hours"    => "num",
		    "comments" => "html"
		    );
     if( !$errs ) {
	$res = $zen->test_ticket($id, $login_id, $hours, $comments);
	if( $res ) {
	   add_system_messages("Ticket $id tested");
	   $setmode = "details";
	   include("../ticket.php");
	   exit;
	   //header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
	} else {
	   $errs[] = tr("System error: Ticket ? could not be tested", array($id)).$zen->db_error;
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
