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
  $onLoad = array("behavior_js.php?formset=ticketForm");

  include("$libDir/nav.php");

  include("$templateDir/newTicketForm.php");

  include("$libDir/footer.php");
?>
