<?
  /*
  **  RESET PASSWORD
  **  
  **  Changes a users passphrase to the default
  **
  */
  
  
  include("admin_header.php");

  if( $user_id == 1 && $login_id != 1 ) {
    $errs[] = tr("Only the root administrator can change the root administrator's passphrase");
  } else if( $user_id ) {
    if( $zen->demo_mode == "on" ) {
      $msg = tr("Process completed successfully.  No changes were made because this is a demo site");
    } else {
      $res = $zen->reset_password($user_id);
      if( $res ) {
	$msg = tr("Password reset to the default [user's last name] for user ?", array($user_id));
      } else { 
	$errs[] = tr("The user passphrase could not be found/edited");
      }	
    }
  } else {
    $errs[] = tr("No user id was recieved");
  }

  $page_tile = tr("Reset Password");
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include("$templateDir/adminMenu.php");
  include("$libDir/footer.php");

?>
