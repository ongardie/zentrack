<?
  /**
   * Renders the confirm form for delete screen
   *
   * REQUIREMENTS:
   *   (zenTrack) $zen
   *   (array)    $ids -- (int)ids to be deleted
   *
   * SIDE EFFECTS:
   *   creates $validids for the input form (templates/deleteTicketForm.php)
   */

  // store for the input form
  $validids = array();
?>
<p class='hot'>THIS IS IRREVERSIBLE! If you have any doubts that you might ever 
want to review any data in any of these tickets, now is your last chance. 
After this, you have no chance to survive make your time.</p>

<table class='formTable'>
<tr><td class='subTitle' colspan='4'>Tickets to Exterminate</td></tr>
<tr>
<th class='headerCell'><?= tr("up") ?></th>
<th class='headerCell'><?= tr("Status") ?></th>
<th class='headerCell'><?= tr("Type") ?></th>
<th class='headerCell'><?= tr("Title") ?></th>
</tr>
<?
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
?>

<tr>
<td colspan='4' align='right' class='subTitle'>
<form method='post' action='<?=$SCRIPT_NAME?>' name='ticketConfirmForm'>
<input type='submit' value=' Permanently Remove These Tickets '>
<input type='hidden' name='confirmed_deletions' value='".$zen->ffv(join(" ", $validids))."'>
</form>
</td>
</tr>
</table>
