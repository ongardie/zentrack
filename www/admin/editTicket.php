<?{

  /*
  **  EDIT TICKET
  **  
  **  Edit the properties for a ticket
  **
  */
  
  
  include("admin_header.php");
  $page_tile = tr("Edit Ticket");
  $onLoad = array("behavior_js.php?formset=ticketForm");
  include("$libDir/nav.php");

  include("$templateDir/editTicketForm.php");

  include("$libDir/footer.php");

}?>
