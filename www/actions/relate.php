<?{
   
  /*
  **  RELATE TICKET
  **  
  **  create associations between this ticket and others
  **
  */

  $action = "relate";  
  include("./action_header.php");

  if( $actionComplete == 1 ) {
     $relations = ereg_replace("[^0-9,\n]", "", $relations);
     $relations = split(" *[,\n] *", $relations);
     $input = array(
		    "id"        => "int",
		    "relations" => "ignore",
		    "comments"  => "html"
		    );
     $zen->cleanInput($input);
     $required = array("relations","id");
     foreach($required as $r) {
	if( !$$r ) {
	   $errs[] = " $r is required";
	}
     }
     
     if( !$errs ) {
	add_system_messages("debug: ".join(",",$relations));
	$res = $zen->relate_ticket($id, $relations, $login_id, $comments);
	if( $res ) {
	   add_system_messages("Ticket $id related.");
	   header("Location:$rootUrl/ticket.php?id=$id&setmode=related");
	} else {
	   $errs[] = "System error: Ticket $id could not be related, or the entries were the same.".$zen->db_error;
	}
     }
     if( $errs )
       add_system_messages( $errs, 'Error' );     
  }

  include("$libDir/nav.php");

  if( is_array($relations) ) {
     $relations = join("\n", $relations);
  } else {
     $relations = ereg_replace(",", "\n", $ticket["relations"]);
  }
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
