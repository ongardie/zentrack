<?
  /*
  **  NEW TICKET
  **  
  **  Create a new ticket
  **
  */
  
  
  include("header.php");

  $page_title = tr("Create a New Ticket");
  $expand_tickets = 1;
  $onLoad[] = "behavior_js.php?formset=ticketForm&mode=create";

  include("$libDir/nav.php");

  $view = "ticket_create";
  include("$templateDir/newTicketForm.php");

  include("$libDir/footer.php");
?>
