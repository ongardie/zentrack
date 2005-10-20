<?{
  
  /*
  **  STORE PASSWORD IN COOKIE
  */
  
  include_once("../header.php");
  
  $page_title = tr("Toggle Auto-Login Feature");
  $expand_options = 1;
  
  $on = array_key_exists('setauto', $_GET) && $_GET['setauto'] == 'on';
  
  if( !$zen->settingOn('allow_pwd_save') ) {
    $msg[] = tr("This feature has been disabled by the administrator.");
  }
  else {
    $res = $zen->update_pref($login_id, 'autologin', $on? 1 : 0);
    
    if( $res ) {
      $msg[] = $on? tr("Your auto-login feature has been turned on.  It will become active after your next login attempt.") : 
                 tr("Your auto-login feature has been turned off.");
    }
    else {
      $errs[] = tr("Unable to update your user preferences due to a system error.");
    }
  }
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include("$templateDir/optionsMenu.php");
  include("$libDir/footer.php");
}?>