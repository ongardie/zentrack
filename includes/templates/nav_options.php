<?  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Options")?></td>
</tr>
  <td class='leftNavMenu outset' <?=$lnav_rollover?> title='<?=$hotkeys->tt("Log Off")?>'>
    <a href='<?=$rootUrl?>/index.php?logoff=1' class='leftNavLink'><?=$hotkeys->ll("Log Off")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavCell inset' height='100%' valign='top'>
    You may customize your ZT account using this screen.
  </td>
</tr>