<?
  /*
  **  NEW TICKET
  **  
  **  Create a new ticket
  **
  */
  
  
  include("./action_header.php");

  $ticket = $zen->get_ticket($id);
  if( !is_array($ticket) ) {
     header("Location: $rootUrl/newTicket.php");
  }
  $page_title = "Edit Ticket #$id";
  $expand_tickets = 1;
  include("$libDir/nav.php");

  $TODO = 'EDIT';
  extract($ticket);
  include("$templateDir/newTicketForm.php");

  include("$libDir/footer.php");
?>
