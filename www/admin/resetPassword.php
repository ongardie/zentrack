<?
  /*
  **  RESET PASSWORD
  **  
  **  Changes a users password to the default
  **
  */
  
  
  include("./admin_header.php");

  if( $userID == 1 && $login_id != 1 ) {
    $errs[] = "Only the root administrator can change the root administrator's password";
  } else if( $userID ) {
    if( $zen->demo_mode == "on" ) {
      $msg = "Process completed successfully.  No changes were made because this is a demo site";
    } else {
      $res = $zen->reset_password($userID);
      if( $res ) {
	$msg = "Password reset to the default [user's last name] for user $userID";
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
