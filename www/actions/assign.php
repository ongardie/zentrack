<?{
  
  /*
  **  ASSIGN TICKET
  **  
  **  Make the owner of a ticket the specified user
  **
  */
  
  $action = "assign";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
    $input = array(
		   "id"       => "int",
		   "user_id"   => "int",
		   "comments" => "html"
		   );
    $zen->cleanInput($input);
    $required = array("user_id","id");
    foreach($required as $r) {
      if( !$$r ) {
	$errs[] = tr(" ? is required", array($r));
      }
    }
    
    if( !$errs ) {
      $res = $zen->assign_ticket($id, $user_id, $login_id, $comments);
      if( $res ) {
	add_system_messages("Ticket $id assigned to ".$zen->formatName($user_id));
	$setmode = "details";
	include("../ticket.php");
	exit;
	//header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
      } else {
	$errs[] = tr("System error: Ticket ? could not be assigned", array($id)).$zen->db_error;
      }
    }
    if( $errs ) {
      add_system_messages( $errs, 'Error' );
    }
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
