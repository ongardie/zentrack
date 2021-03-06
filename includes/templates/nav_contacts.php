<?  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Contacts")?></td>
</tr>
<?=ztGetNavigatorRow($hotkeys->tt("Contacts","Browse"), "/contacts.php", $hotkeys->ll("Contacts","Browse"));?>
<?=ztGetNavigatorRow($hotkeys->tt("New Contact"), "/newContact.php", $hotkeys->ll("New Contact"));?>
<?=ztGetNavigatorRow($hotkeys->tt("Find"), "/searchContacts.php", $hotkeys->ll("Find"));?>
<!--
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("Contacts","Browse")?>'>
    <a href='<?=$rootUrl?>/contacts.php' class='leftNavLink'><?=$hotkeys->ll("Contacts","Browse")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("New Contact")?>'>
    <a href='<?=$rootUrl?>/newContact.php' class='leftNavLink'><?=$hotkeys->ll("New Contact")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title="<?=$hotkeys->tt('Find')?>">
    <a href='<?=$rootUrl?>/searchContacts.php' class='leftNavLink'><?=$hotkeys->ll("Find")?></a>
  </td>
</tr>
-->
<tr>
  <td class='leftNavCell' height='25%' valign='top'>
    <div class='recentHistory'>
      <div><?=tr("Recent Companies")?></div>
    <?
      $history =& $zen->getHistoryManager();
      $list = $history->getList('company');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<div><a href='$rootUrl/contact.php?cid=$k'>".Zen::ffv($v)."</a></div>\n";
        }
      }
      else {
        print "-none-";
      }
    ?></div>
    </td></tr>
    <tr>
    <td class='leftNavCell' height='25%' valign='top'>
    <div class='recentHistory'>
      <div><?=tr("Recent Employees")?></div>
    <?
      $history =& $zen->getHistoryManager();
      $list = $history->getList('employee');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<div><a href='$rootUrl/contact.php?pid=$k'>".$zen->ffv(substr($v,0,15))."</a></div>\n";
        }
      }
      else {
        print tr("-none-");
      }
    ?></div>
  </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Agreements")?></td>
</tr>
<?=ztGetNavigatorRow($hotkeys->tt("Browse"), "/agreements.php", $hotkeys->ll("Browse"));?>
<?=ztGetNavigatorRow($hotkeys->tt("New Agreement"), "/newAgreement.php", $hotkeys->ll("New Agreement"));?>
<!--
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title="<?=$hotkeys->tt('Browse')?>">
    <a href='<?=$rootUrl?>/agreements.php' class='leftNavLink'><?=$hotkeys->ll("Browse")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title="<?=$hotkeys->tt('New Agreement')?>">
    <a href='<?=$rootUrl?>/newAgreement.php' class='leftNavLink'><?=$hotkeys->ll("New Agreement")?></a>
  </td>
</tr>
-->
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
    <div class='recentHistory'>
      <div><?=tr("Recent Agreements")?></div>
    <?
      $history =& $zen->getHistoryManager();
      $list = $history->getList('agreement');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<br><a href='$rootUrl/contacts.php?pid=$k'>".$zen->ffv(substr($v,0,15))."</a>\n";
        }
      }
      else {
        print "-none-";
      }
    ?></div>
  </td>
</tr>
