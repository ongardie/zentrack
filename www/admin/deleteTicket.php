<?{

  /*
  **  DELETE TICKETS
  **  
  **  Delete tickets from the system
  */
  
  
  include("admin_header.php");
  $page_title = tr("Delete Tickets");
  include("$libDir/nav.php");

  /**
   * Utilities for deleting ticket content
   * @param zenTrack $zen
   * @param array $ids (int)ids to be deleted, including all logs, sub-tickets, etc
   * @return array (int)ids that could not be deleted
   */
  function do_delete_tickets(&$zen, $ids) {
    $idsWithErrors = array();
    foreach($ids as $id) {
      if( !$zen->delete_ticket($id) ) {
        $idsWithErrors[] = $id;
      }
    }
    return $idsWithErrors;
  }
  
  /**
   * Returns a list of sql queries needed to delete a ticket completely
   * @return array of (string)queries
   */
  function get_ticket_delete_queries(&$zen, $id) {
    return array("DELETE FROM {$zen->table_tickets} WHERE id = $id",
        "DELETE FROM {$zen->table_logs} WHERE ticket_id = $id",
        "DELETE FROM {$zen->table_varfield} WHERE id = $id",
        "DELETE FROM {$zen->table_varfield_multi} WHERE id = $id",
        "DELETE FROM {$zen->table_attachments} WHERE id = $id",
        "DELETE FROM ZENTRACK_RELATED_CONTACTS WHERE ID = $id");
  }

  function split_form_ids($txt) {
    $txt = preg_replace("@[^0-9 ]@", "", $txt);
    $vals = explode(" ", $txt);
    return array_unique($vals);
  }

if( !empty($_POST['confirmed_deletions']) ) {
  // here we will actually perform the deletions
  $idsToDelete = split_from_ids($_POST['confirmed_deletions']);
  $idsWithErrors = do_delete_tickets($zen, $idsToDelete);
  foreach($idsToDelete as $id) {
    if( in_array($id, $idsWithErrors) ) {
      print "<p class='error'>$id failed to delete. You'll have to manually run the following queries:";
      print join("<br>", get_ticket_delete_queries($zen, $id));
      print "</p>\n";
    }
    else {
      $ticket = $zen->get_ticket($id);
      $t = $ticket['title'];
      print "<div>$id deleted <div class='note'>$t</div></div>\n";
    }
  }
  // store for the html form
  $validids = $idsWithErrors;
}
else if( !empty($_POST['tickets_to_delete']) ) {
  $ids = split_form_ids($_POST['tickets_to_delete']);
  include("$templateDir/deleteTicketsConfirmation.php");
}
else {
  // used by the deleteTicketForm, so we want to make sure it's initialized
  // to avoid php notices
  $validids = array(); 
}

  include("$templateDir/deleteTicketForm.php");
  include("$libDir/footer.php");
}?>