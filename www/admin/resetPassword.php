<?
  /*
  **  RESET PASSWORD
  **  
  **  Changes a users password to the default
  **
  */
  
  
  include("./admin_header.php");

  if( $uid == 1 && $login_id != 1 ) {
    $errs[] = "Only the root administrator can change the root administrator's password";
  } else if( $uid ) {
    if( $zen->demo_mode == "on" ) {
      $msg = "Process completed successfully.  No changes were made because this is a demo site";
    } else {
      $res = $zen->reset_password($uid);
      if( $res ) {
	$msg = "Password reset to the default [user's last name] for user $uid";
      } else { 
	$errs[] = "The user password could not be found/edited";
      }	
    }
  } else {
    $errs[] = "No user id was recieved";
  }

  $page_tile = "Reset Password";
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include("$templateDir/adminMenu.php");
  include("$libDir/footer.php");

?>
