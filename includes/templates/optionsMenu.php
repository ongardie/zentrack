<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<br>
<ul>
  <b><?=tr("Account Options")?></b>
  <ul>
    <b><a href="<?=$rootUrl?>/misc/pwc.php"><?=tr("Change Password")?></a></b>
    <? if( $zen->settings["allow_pwd_save"] == "on" ) {
         if( $zen->get_prefs($login_id,'autologin') ) {
           print "<p><b><a href='$rootUrl/misc/autologin.php?setauto=off'>".tr("Disable Auto-Login")."</a></b>";
         }
         else {
           print "<p><b><a href='$rootUrl/misc/autologin.php?setauto=on'>".tr("Enable Auto-Login")."</a></b>";
         } 
       }
     ?>
    <p><b><a href="<?=$rootUrl?>/misc/homebin.php"><?=tr("Change Default Bin")?></a></b>
    <p><b><a href="<?=$rootUrl?>/misc/language.php"><?=tr("Change Language")?></a></b>
  </ul>
</ul>

<? 
  if( $page_title == tr("Change Password") ) {
    $link = "<a href='$helpUrl/tutorial.php'>".tr('Tutorial')."</a>";
    print "<p><span class='error'>";
    print tr("If this is your first time logging in, please read the ?!", array($link));
    print "</span></p>\n";  
  } 
?>
