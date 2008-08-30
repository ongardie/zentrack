<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<? if( $page_title == tr("Change Password") ) { ?>
  <div class='menubox'>
    <div><?=tr("Welcome!")?></div>
    <p onclick='mClk(this)'>
    &nbsp;&nbsp;<span class='error'>
    <?
     $link = "<a href='$helpUrl/tutorial.php'>".tr('Tutorial')."</a>";
     print tr("If this is your first time logging in, please read the ?!", array($link));
    ?>
    </span></p>
  </div>
<? } ?>


 <div class='menubox'>
    <div><?=tr("Security")?></div>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/misc/pwc.php'><?=$hotkeys->ll("Change Password")?></a></p>
<?
  if( $zen->settingOn("allow_pwd_save") ) {
    print "<p onclick='mClk(this)'>";
    print "<a href='$rootUrl/misc/autologin.php'>";
    print $hotkeys->ll("Set Auto-Login");
    print "</a>&nbsp;&nbsp;<span class='note'>";
    if( $zen->get_prefs($login_id,'autologin') ) {
      print tr("Auto-Login is currently ON");
      $val = "off";
    }
    else {
      print tr("Auto-Login is currently OFF");
      $val = "on";
    }
    print "</span></p>\n";
?>
<? } ?>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/index.php?logoff=1'><?=$hotkeys->ll("Log Off")?></a></p>
  </div>
  
  
  <div class='menubox'>
    <div><?=tr("Preferences")?></div>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/misc/homebin.php'><?=$hotkeys->ll("Change Home Bin")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Set the default bin to display")?></span></p>
    <p onclick='mClk(this)'>
    <a href="<?=$rootUrl?>/misc/language.php"><?=$hotkeys->ll("Set Language")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Change the language used to view pages.")?></span></p>
  </div>