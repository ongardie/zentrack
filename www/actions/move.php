<?
  /*
  **  MOVE TICKET
  **  
  **  Move ticket to a new bin
  **
  */

  $action = "move";  
  include("./action_header.php");

  if( !$id )
    header("Location: $rootUrl/index.php\n");

  if( !$zen->actionApplicable( $id, 'move', $login_id ) )
    header("Location: $rootUrl/ticket.php?id=$id&setmode=details");

  if( $actionComplete == 1 ) {
     $userID = $login_id;
     $input = array(
		    "id"       => "int",
		    "newBin"   => "int",
		    "userID"   => "int",
		    "comments" => "html"
		    );
     $zen->cleanInput($input);
     $required = array("id","newBin","userID");
     foreach($required as $r) {
	if( !$$r ) {
	   $errs[] = " $r is required";
	}
     }
     
     if( !$errs ) {
	$res = $zen->move_ticket($id, $newBin, $login_id, $comments);
	if( $res ) {
	   add_system_messages("Ticket $id moved to the ".$zen->bins["$newBin"]." bin");
	   header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
	} else {
	   $errs[] = "System error: Ticket $id could not be moved. ".$zen->db_error;
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
?>
