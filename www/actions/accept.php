<?{
   
  /*
  **  ACCEPT TICKET
  **  
  **  Make logged in user the owner
  **  of this ticket
  **
  */

  $action = "accept";  
  include("action_header.php");

   $res = $zen->accept_ticket($id, $login_id);
   if( $res ) {
      add_system_messages(tr("Ticket ? was accepted by ?", array($id, $login_name)));
      $setmode = "details";
      include("../ticket.php");
      exit;	   
      //header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
   } else {
      $errs[] = tr("System error: Ticket ? could not be accepted", array($id)).$zen->db_error;
   }
   if( $errs )
     add_system_messages( $errs, 'Error' );     
   
   include("$libDir/nav.php");

   $ticket = $zen->get_ticket($id);
   extract($ticket);
   unset($action);
   if( strtolower($zen->types["$type_id"]) == "project" ) {
      include("$templateDir/projectView.php");
   } else {
      include("$templateDir/ticketView.php");     
   }

   include("$libDir/footer.php");

}?>
