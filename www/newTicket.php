<?
  /*
  **  NEW TICKET
  **  
  **  Create a new ticket
  **
  */
  
  
  include("header.php");

  $page_tile = "Create a New Ticket";
  $expand_tickets = 1;
  include("$libDir/nav.php");

  include("$templateDir/newTicketForm.php");

  include("$libDir/footer.php");
?>
