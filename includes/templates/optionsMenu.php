
<br>
<ul>
  <b><?=tr("Account Options")?></b>
  <ul>
    <b><a href="<?=$rootUrl?>/misc/pwc.php"><?=tr("Change Password")?></a></b>
    <? if( $zen->settings["allow_pwd_save"] == "on" ) { ?>
    <br><b><a href="<?=$rootUrl?>/misc/cookie.php"><?=tr("Remember My Password")?></a></b>
    <? } ?>
    <br><b><a href="<?=$rootUrl?>/misc/homebin.php"><?=tr("Change Default Bin")?></a></b>
  </ul>
</ul>
