<?  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Security")?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("Change Password")?>'>
    <a href='<?=$rootUrl?>/misc/pwc.php' class='leftNavLink'><?=$hotkeys->ll("Change Password", tr("Password"))?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("Set Auto-Login")?>'>
    <a href='<?=$rootUrl?>/misc/autologin.php' class='leftNavLink'><?=$hotkeys->ll("Set Auto-Login", tr("Auto-Login"))?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("Log Off")?>'>
    <a href='<?=$rootUrl?>/index.php?logoff=1' class='leftNavLink'><?=$hotkeys->ll("Log Off")?></a>
  </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Preferences")?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("Change Home Bin")?>'>
    <a href='<?=$rootUrl?>/misc/homebin.php' class='leftNavLink'><?=$hotkeys->ll("Change Home Bin", tr("Home Bin"))?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("Set Language")?>'>
    <a href='<?=$rootUrl?>/misc/language.php' class='leftNavLink'><?=$hotkeys->ll("Set Language", tr("Language"))?></a>
  </td>
</tr>
<tr>
  <td height='100%' valign='top'>
  &nbsp;
  </td>
</tr>
