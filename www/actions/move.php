<?
  /*
  **  MOVE TICKET
  **  
  **  Move ticket to a new bin
  **
  */

  $action = "move";  
  include("action_header.php");

  if( $actionComplete == 1 ) {
    $user_id = $login_id;
    $input = array(
		   "id"       => "int",
		   "newBin"   => "int",
		   "user_id"   => "int",
		   "comments" => "html"
		   );
    $zen->cleanInput($input);
    $required = array("id","newBin","user_id");
    foreach($required as $r) {
      if( !$$r ) {
	$errs[] = tr(" ? is required", array($r));
      }
    }
    
    if( !$errs ) {
      $res = $zen->move_ticket($id, $newBin, $login_id, $comments);
      if( $res ) {
	add_system_messages(tr("Ticket ? moved to the ? bin", array($id, $zen->bins["$newBin"])));
	$setmode = "details";
	include("../ticket.php");
	exit;
	//header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
      } else {
	$errs[] = tr("System error: Ticket ? could not be moved. ", array($id)).$zen->db_error;
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
?>
