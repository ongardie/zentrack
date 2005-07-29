<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Tickets")?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$nav_rollover_text?> title='<?=$hotkeys->tt("Tickets")?>'>
    <a href='<?=$rootUrl?>/index.php' class='leftNavLink'><?=$hotkeys->ll("Tickets","Browse")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$nav_rollover_text?> title='<?=$hotkeys->tt("New Ticket")?>'>
    <a href='<?=$rootUrl?>/newTicket.php' class='leftNavLink'><?=$hotkeys->ll("New Ticket")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$nav_rollover_text?> title='<?=$hotkeys->tt("Search")?>'>
    <a href='<?=$rootUrl?>/search.php' class='leftNavLink'><?=$hotkeys->ll("Search")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
    <div class='recentHistory'><?=tr("Recent Tickets")?></div>
    <?
      $history =& $zen->getHistoryManager();
      $list = $history->getList('ticket');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<br><a href='$rootUrl/ticket.php?id=$k'>$k - ".substr($zen->ffv($v),0,10)."</a>\n";
        }
      }
      else {
        print "-none-";
      }
    ?>
  </td>
</tr>