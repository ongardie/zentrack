<?{

  /*
  **  EDIT TICKET
  **  
  **  Edit the properties for a ticket
  **
  */
  
  
  include("./admin_header.php");
  $page_tile = "Edit Ticket";
  include("$libDir/nav.php");

  // if there is an ID, open it up
  // otherwise, ask for the ticket ID
  if( $id ) {
    // run a whole bunch of error checks before
    // letting the user edit the ticket
     $ticket = $zen->get_ticket($id);
     if( !is_array($ticket) ) {
       $errs[] = "Ticket $id could not be found";
     } else if( !$zen->checkAccess($login_id,$ticket["binID"],"edit") ) {
       $errs[] = "You cannot edit a ticket in the ".$zen->bins["$ticket[binID]"]." bin.";
     } else if( !$zen->actionApplicable($id,"edit",$login_id) ) {
       $errs[] = "Ticket $id cannot be edited in its current status";
     } else {
       $TODO = 'EDIT';
       extract($ticket);
       if( $zen->projectTypeID() == $ticket["typeID"] )
	 include("$templateDir/newProjectForm.php");
       else
	 include("$templateDir/newTicketForm.php");
     }
  } else {
   ?>
   <br><blockquote>
      <b>Please enter a ticket ID</b>
   <form action='<?=$SCRIPT_NAME?>'>
    <input type="text" name="id" size="8" maxlength="12">
   </form> 
   <?
  }

  include("$libDir/footer.php");

}?>
