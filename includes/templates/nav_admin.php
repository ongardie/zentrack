<?
  if( !ZT_DEFINED ) { die("Illegal Access"); }
  //shortcut
  $hk = $hotkeys 
?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Users")?></td>
</tr>
<?=ztGetNavigatorRow($hk->tt('New User'), "/admin/addUser.php", $hk->ll("New User"));?>
<?=ztGetNavigatorRow($hk->tt('Edit Users'), "/admin/listUsers.php", $hk->ll("Edit Users"));?>
<!--
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('New User')?>'>
    <a href='<?=$rootUrl?>/admin/addUser.php' class='leftNavLink'><?=$hk->ll("New User")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Edit Users')?>'>
    <a href='<?=$rootUrl?>/admin/listUsers.php' class='leftNavLink'><?=$hk->ll('Edit Users')?></a>
  </td>
</tr>
-->
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Tickets")?></td>
</tr>
<?=ztGetNavigatorRow($hk->tt('Edit Tickets'), "/admin/editTicket.php", $hk->ll("Edit Tickets"));?>
<?=ztGetNavigatorRow($hk->tt('Delete Tickets'), "/admin/deleteTicket.php", $hk->ll("Delete Tickets"));?>
<?=ztGetNavigatorRow($hk->tt('Edit Field Map'), "/admin/fieldMap.php", $hk->ll("Edit Field Map"));?>
<!--
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Edit Tickets')?>'>
    <a href='<?=$rootUrl?>/admin/editTicket.php' class='leftNavLink'><?=$hk->ll('Edit Tickets')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Edit Field Map')?>'>
    <a href='<?=$rootUrl?>/admin/fieldMap.php' class='leftNavLink'><?=$hk->ll('Edit Field Map')?></a>
  </td>
</tr>
-->
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Data Types")?></td>
</tr>
<?=ztGetNavigatorRow($hk->tt('Bins'), "/admin/bins.php", $hk->ll("Bins"));?>
<?=ztGetNavigatorRow($hk->tt('Priorities'), "/admin/priorities.php", $hk->ll("Priorities"));?>
<?=ztGetNavigatorRow($hk->tt('Systems'), "/admin/systems.php", $hk->ll("Systems"));?>
<?=ztGetNavigatorRow($hk->tt('Tasks'), "/admin/tasks.php", $hk->ll("Tasks"));?>
<?=ztGetNavigatorRow($hk->tt('Types'), "/admin/types.php", $hk->ll("Types"));?>
<!--
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Bins')?>'>
    <a href='<?=$rootUrl?>/admin/bins.php' class='leftNavLink'><?=$hk->ll('Bins')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Priorities')?>'>
    <a href='<?=$rootUrl?>/admin/priorities.php' class='leftNavLink'><?=$hk->ll('Priorities')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Systems')?>'>
    <a href='<?=$rootUrl?>/admin/systems.php' class='leftNavLink'><?=$hk->ll('Systems')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Tasks')?>'>
    <a href='<?=$rootUrl?>/admin/tasks.php' class='leftNavLink'><?=$hk->ll('Tasks')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Types')?>'>
    <a href='<?=$rootUrl?>/admin/types.php' class='leftNavLink'><?=$hk->ll('Types')?></a>
  </td>
</tr>
-->
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Settings")?></td>
</tr>
<?=ztGetNavigatorRow($hk->tt('Data Groups'), "/admin/groups.php", $hk->ll("Data Groups"));?>
<?=ztGetNavigatorRow($hk->tt('Behaviors'), "/admin/behaviors.php", $hk->ll("Behaviors"));?>
<?=ztGetNavigatorRow($hk->tt('Configuration'), "/admin/config.php", $hk->ll("Configuration"));?>
<!--
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Data Groups')?>'>
    <a href='<?=$rootUrl?>/admin/groups.php' class='leftNavLink'><?=$hk->ll('Data Groups')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Behaviors')?>'>
    <a href='<?=$rootUrl?>/admin/behaviors.php' class='leftNavLink'><?=$hk->ll('Behaviors')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hk->tt('Configuration')?>'>
    <a href='<?=$rootUrl?>/admin/config.php' class='leftNavLink'><?=$hk->ll('Configuration')?></a>
  </td>
</tr>
-->
<tr><td height='100%'>&nbsp;</td></tr>
