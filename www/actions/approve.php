<?{
   
  /*
  **  APPROVE TICKET
  **  
  **  Approve closing of a ticket
  **
  */

  $action = "approve";  
  include("./action_header.php");

   $input = array(
		  "id"       => "int",
		  "comments" => "html"
		  );
   $zen->cleanInput($input);

   if( !$errs ) {
      $res = $zen->approve_ticket($id, $login_id, $comments);
      if( $res ) {
	 add_system_messages("Ticket $id was approved");
	 header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
      } else {
	 $errs[] = "System error: Ticket $id could not be approved".$zen->db_error;
      }
   }
   if( $errs )
     add_system_messages( $errs, 'Error' );     

  include("$libDir/nav.php");

  unset($action);
  extract($ticket);
  if( strtolower($zen->types["$type_id"]) == "project" ) {
     include("$templateDir/projectView.php");
  } else {
     include("$templateDir/ticketView.php");     
  }

  include("$libDir/footer.php");

}?>
