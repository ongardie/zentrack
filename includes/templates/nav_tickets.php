<?  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Tickets")?></td>
</tr>
<?=ztGetNavigatorRow($hotkeys->tt("New Ticket"), "/newTicket.php", $hotkeys->ll("New Ticket"));?>
<?=ztGetNavigatorRow("", "/assignedTickets.php", tr("My Tickets"));?>
<?=ztGetNavigatorRow($hotkeys->tt("Advanced Search"), "/search.php", $hotkeys->ll("Advanced Search", "Search"));?>
<?=ztGetNavigatorRow("", "/searchLogs.php", tr('Search Logs'));?>
<!--
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("New Ticket")?>'>
    <a href='<?=$rootUrl?>/newTicket.php' class='leftNavLink'><?=$hotkeys->ll("New Ticket")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>>
    <a href='<?=$rootUrl?>/assignedTickets.php' class='leftNavLink'><?=tr('My Tickets')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title="<?=$hotkeys->tt("Advanced Search")?>">
    <a href='<?=$rootUrl?>/search.php' class='leftNavLink'><?=$hotkeys->ll("Advanced Search", "Search")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>> 
    <a href='<?=$rootUrl?>/searchLogs.php' class='leftNavLink'><?=tr('Search Logs')?></a>
  </td>
</tr>
-->
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
    <div class='recentHistory' id='ticketHistoryDiv' onMouseOver='setupHistoryDiv(this)'>
      <div><?=tr("Recent Tickets")?></div>
    <?
      $history =& $zen->getHistoryManager();
      $list = $history->getList('ticket');
      if( count($list) ) {
        $otag="";
        $ctag="";
        foreach($list as $k=>$v) {
// If you want (or don't want) the current ticket in the Recent Tickets section to be bold,
// uncomment (or comment) the following modification:
          if ( !empty($id) && $id==$k ) {
            $otag="<b>";
            $ctag="</b>";
          } else {
            $otag="";
            $ctag="";
          }
// End of "current ticket in bold" section to un/comment.

          $t = Zen::ffv($v);
          //$t = strlen($v) > 15? substr(Zen::ffv($v),0,12)."..." : $tt;
          print "<br><a href='$rootUrl/ticket.php?id=$k' title='$t'>$otag".$k.tr("-").$t.$ctag."</a>\n";
        }
      }
      else {
        print "-none-";
      }    
    ?>
    </div>
    <p>&nbsp;</p>
  </td>
</tr>
