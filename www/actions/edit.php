<?
  /*
  **  Action: edit ticket
  */
  include("action_header.php");
  $page_title = tr("Edit Ticket");
  $onLoad = array("behavior_js.php?formset=ticketForm");
  include("$libDir/nav.php");

  include("$templateDir/editTicketForm.php");

  include("$libDir/footer.php");
?>
