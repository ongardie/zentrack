<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<?
  include("$templateDir/pwcForm.php");
  
  print "<p>";
  if( $zen->settingOn("allow_pwd_save") ) {
     if( $zen->get_prefs($login_id,'autologin') ) {
       $txt = "Disable Auto-Login";
       $val = "off";
     }
     else {
       $txt = "Enable Auto-Login";
       $val = "on";
     } 

?>
<form method="get" action="<?=$rootUrl?>/misc/autologin.php">

<table width="300" cellpadding="5">
<tr>
  <td colspan="2" class="subTitle" align="center" height="20">
    <b><?=tr("Auto Login Setting")?></b>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
    <input type="submit" value="<?=tr($txt)?>" class="submit">
  </td>
</tr>
</table>

<input type="hidden" name="setauto" value="<?=$val?>">
</form>
<?
  }
   
   print "<p>";
   include("$templateDir/languageForm.php");

   if( $page_title == tr("Change Password") ) {
    $link = "<a href='$helpUrl/tutorial.php'>".tr('Tutorial')."</a>";
    print "<p><span class='error'>";
    print tr("If this is your first time logging in, please read the ?!", array($link));
    print "</span></p>\n";  
  } 
?>
