<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

/*if( $TODO == 'SAVED' ) {
  $zen->print_errors($errs);
  if( $save_message ) {
    print "<p class='bold'>".tr($save_message)."</p>";
  }
}*/

  // if there is an ID, open it up
  // otherwise, ask for the ticket ID
  $skip = 0;
  if( $id ) {
    // run a whole bunch of error checks before
    // letting the user edit the varfields of ticket
    $ticket = $zen->get_ticket($id);
    if( !is_array($ticket) ) {
      $errs[] = tr("Ticket #? could not be found",array($id));
    } else if( !$zen->checkAccess($login_id,$ticket["bin_id"],"varfield_edit") ) {
      $errs[] = tr("You cannot edit the varfields of a ticket in this bin");
    } else {
      $skip = 1;
      $TODO = 'EDIT_CUSTOM';
      $varfields = $zen->getVarfieldVals($id);
      extract($varfields);
      extract($ticket);
      $description = preg_replace("@<br ?/?>@","\n",$description);
      if( $zen->inProjectTypeIDs($ticket["type_id"]) ) {
        $view = "project_custom";
      } else {
        $view = "ticket_custom";
      }
      include("$templateDir/newTicketForm.php");
    }
  }
  if( !$skip ) {
    $zen->printErrors($errs);
   ?>
   <br><blockquote>
      <b><?=tr("Please enter a ticket ID")?></b>
   <form action='<?=$SCRIPT_NAME?>'>
    <input type="text" name="id" size="8" maxlength="12">
   </form>
   <?
  }
?>

