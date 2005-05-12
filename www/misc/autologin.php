<?{
  
  /*
  **  STORE PASSWORD IN COOKIE
  */
  
  include_once("../header.php");
  
  $page_title = tr("Toggle Auto-Login Feature");
  $expand_options = 1;
  
  $on = array_key_exists('setauto', $_GET) && $_GET['setauto'] == 'on';
  
  include("$libDir/nav.php");
  
  print "<p><span class='error'>";
  
  if( $zen->settings['allow_pwd_save'] != 'on' ) {
    print tr("This feature has been disabled by the administrator.")."\n";
  }
  else {
    $res = $zen->update_pref($login_id, 'autologin', $on? 1 : 0);
    
    if( $res ) {
      print $on? tr("Your auto-login feature has been turned on.  It will become active after your next login attempt.") : 
                 tr("Your auto-login feature has been turned off.");
    }
    else {
      print tr("Unable to update your user preferences due to a system error.");
    }
  }
  
  print "</span></p>\n";

  include("$templateDir/optionsMenu.php");
  include("$libDir/footer.php");
}?>