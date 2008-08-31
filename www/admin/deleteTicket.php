<?{

  /*
  **  DELETE TICKETS
  **  
  **  Delete tickets from the system
  */
  
  
  include("admin_header.php");
  $page_title = tr("Delete Tickets");
  include("$libDir/nav.php");

  // declare here since it's used in the form at the bottom and might cause warning
  $validids = array();

function split_form_ids($txt) {
  $txt = preg_replace("@[^0-9 ]@", "", $txt);
  $vals = explode(" ", $txt);
  return array_unique($vals);
}

if( !empty($_POST['confirmed_deletions']) ) {
  $ids = split_form_ids($_POST['confirmed_deletions']);
  foreach($ids as $id) {
    $ticket = $zen->get_ticket($id);
    $res = $zen->delete_ticket($id);
    $t = $ticket['title'];
    if( $res !== false ) {      
      print "<div>$id deleted <div class='note'>$t</div></div>\n";
    }
    else {
      $validids[] = $id;
      print "<p class='error'>$id failed to delete. You'll have to manually run the following queries:<br>DELETE FROM {$zen->table_tickets} WHERE id = $id<br>DELETE FROM {$zen->table_logs} WHERE ticket_id = $id<br>DELETE FROM {$zen->table_varfield} WHERE id = $id<br>DELETE FROM {$zen->table_varfield_multi} WHERE id = $id<br>DELETE FROM {$zen->table_attachments} WHERE id = $id<br>DELETE FROM ZENTRACK_RELATED_CONTACTS WHERE ID = $id</p>\n";
    }
  }
}
else if( !empty($_POST['tickets_to_delete']) ) {
  $ids = split_form_ids($_POST['tickets_to_delete']);
  $validids = array();

  // print headings
  print "<p class='hot'>THIS IS IRREVERSIBLE! If you have any doubts that you might ever want to review any data in any of these tickets, now is your last chance. After this, you have no chance to survive make your time.</p>\n";
  print "<table class='formTable'>\n";
  print "<tr><td class='subTitle' colspan='4'>Tickets to Exterminate</td></tr>\n";
  print "<tr>";
  print "<th class='headerCell'>".uptr("id")."</th>";
  print "<th class='headerCell'>".tr("Status")."</th>";
  print "<th class='headerCell'>".tr("Type")."</th>";
  print "<th class='headerCell'>".tr("Title")."</th>";
  print "</tr>\n";
  
  // set up translations once for re-use
  $invalid_txt = uptr("invalid");
  $invmsg = tr("Invalid ticket ID, will be ignored");

  // print out tickets
  foreach($ids as $id) {
    $ticket = $zen->get_ticket($id);
    if( !$ticket ) {
      // an invalid id was provided
      print "<tr class='error'><td>$id</td><td>$invalid_txt</td>";
      print "<td>$invalid_txt</td><td>$invmsg</td></tr>\n";
    }
    else {
      // create status coloring
      if( $ticket["status"] == 'CLOSED' ) {
	$c = "class='bars'";
      }
      else if( $zen->getSetting("priority_medium") ) {
	$c = "class='priority{$ticket['priority']}'";
      }
      else {
	$classxText = "class='cell'";
      }

      // store it for the form forwarding
      $validids[] = $id;
      
      // show the ticket info
      print "<tr $c>";
      print "<td>$id</td>";
      print "<td>".$map->getTextValue('ticket_list', 'status', $ticket['status'])."</td>";
      print "<td>".$map->getTextValue('ticket_list', 'type_id', $ticket['type_id'])."</td>";
      print "<td>".$map->getTextValue('ticket_list', 'title', $ticket['title'])."</td>";
      print "</tr>\n";
    }
  }
  // footer
  print "<tr><td colspan='4' align='right' class='subTitle'><form method='post' action='{$SCRIPT_NAME}' name='ticketConfirmForm'>\n";
  print "<input type='submit' value=' Permanently Remove These Tickets '>\n";
  print "<input type='hidden' name='confirmed_deletions' value='".$zen->ffv(join(" ", $validids))."'>\n";
  print "</form></td></tr>\n";
  print "</table>\n";
}

?>
  <br><blockquote>
   <b><?=tr("Please enter ticket IDs")?></b>
   <form action='<?=$SCRIPT_NAME?>' name='ticketIdForm' method='post'>
     <div>Separate multiple ids with spaces</div>
     <textarea name="tickets_to_delete" rows="3" cols="25"><?= $zen->ffv(join(" ",$validids)) ?></textarea>
     <p><input type='submit' name='delbutton' value=' Confirm Tickets to be Deleted '>
   </form>
   <script>setFocalPoint('ticketIdForm','id');</script>
   </blockquote>
<?
  include("$libDir/footer.php");
}?>