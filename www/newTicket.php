<?
  /*
  **  NEW TICKET
  **  
  **  Create a new ticket
  **
  */
  
  
  include("header.php");

  $page_tile = tr("Create a New Ticket");
  $expand_tickets = 1;
  $onLoad[] = "behavior_js.php?formset=ticketForm&mode=create";

  include("$libDir/nav.php");

  include("$templateDir/newTicketForm.php");

  include("$libDir/footer.php");
?>
