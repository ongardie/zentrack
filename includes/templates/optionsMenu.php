
<br>
<ul>
  <b><?=tr("Account Options")?></b>
  <ul>
    <b><a href="<?=$rootUrl?>/misc/pwc.php"><?=tr("Change Password")?></a></b>
    <? if( $zen->settings["allow_pwd_save"] == "on" ) { ?>
    <br><b><a href="<?=$rootUrl?>/misc/cookie.php"><?=tr("Remember My Password")?></a></b>
    <? } ?>
    <br><b><a href="<?=$rootUrl?>/misc/homebin.php"><?=tr("Change Default Bin")?></a></b>
    <br><b><a href="<?=$rootUrl?>/misc/language.php"><?=tr("Change Language")?></a></b>
  </ul>
</ul>

<? 
  if( $page_tile == tr("Change Password") ) {
    $link = "<a href='$helpUrl/tutorial.php'>".tr('Tutorial')."</a>";
    print "<p><span class='error'>";
    print tr("If this is your first time logging in, please read the ?!", array($link));
    print "</span></p>\n";  
  } 
?>
