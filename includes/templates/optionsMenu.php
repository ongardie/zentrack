
<br>
<ul>
  <b>Account Options</b>
  <ul>
    <b><a href="<?=$rootUrl?>/misc/pwc.php">Change Password</a></b>
    <? if( $zen->settings["allow_pwd_save"] == "on" ) { ?>
    <br><b><a href="<?=$rootUrl?>/misc/cookie.php">Remember My Password</a></b>
    <? } ?>
    <br><b><a href="<?=$rootUrl?>/misc/homebin.php">Change Default Bin</a></b>
  </ul>
</ul>
