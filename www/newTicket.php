<?
  /*
  **  NEW TICKET
  **  
  **  Create a new ticket
  **
  */
  
  define("ZT_SECTION","tickets");
  include("header.php");

  $page_title = tr("Create a New Ticket");
  $expand_tickets = 1;
  $onLoad[] = "behavior_js.php?formset=ticketForm&mode=create";

  // yahoo libs for addbox
  $ext = $Debug_Mode == 3? "-debug" : "-min";
  $onLoad[] = "js/addBoxFunctions.js";
  // we load them as a single file from the yui network
  $onLoad[] = "http://yui.yahooapis.com/combo?2.5.2/build/yahoo-dom-event/yahoo-dom-event.js&2.5.2/build/connection/connection{$ext}.js&2.5.2/build/json/json{$ext}.js";

  include("$libDir/nav.php");

  $view = "ticket_create";
  include("$templateDir/newTicketForm.php");
  include("$libDir/footer.php");
?>
