<?{

  /*
  **  CHANGE PASSWORD
  **  
  **  Change the password for the logged in user
  **
  */
  
  include("../header.php");

  $page_tile = "Change Password";
  $expand_options = 1;

  if( $TODO == 'SET' ) {
    $settings = $zen->getSettings(1);
    if( !$newPass1 || !$newPass2 ) {
      $errs[] = "Please fill in both of the fields";
    } else if( $newPass1 != $newPass2 ) {
      $errs[] = "Your passwords did not match";
    } else {
      if( strlen($newPass1) < 6 ) 
	$errs[] = "Your password must be at least 6 digits long";
      if( ($settings["check_pwd_simple"]["value"]=="on") && !ereg("[^a-zA-Z]", $newPass1) )
	  $errs[] = "Your new password must contain at least 1 non-letter character";
    }
    $user = $zen->getUser($login_id);
    if( $user["initials"] == "GUEST" ) {
      $errs[] = "The Guest Password cannot be changed!";
    }

    if( !$errs ) {
      $params = array();
      $params["passwd"] = $newPass1;
      if( $zen->demo_mode == "on" ) {
	$msg = "Your request was successful, but this is a demo site, so the password was not altered";
	$skip = 1;
      } else {
	$res = $zen->update_user($login_id,$params);
	if( !$res ) {
	  $errs[] = "System Error: Unable to change user password.";
	} else {
	  $skip = 1;
	  $msg = "Password successfully changed";
	}
      }
    }
  }

  // if we made it this far, then the password wasn't changed,
  // so print errors if applicable and show form

  include("$libDir/nav.php");
?>
  <table width="600" align="center">
  <tr><td>
<?
  $zen->printErrors($errs);
  if( $skip ) {
    include("$templateDir/optionsMenu.php");
  } else {
    include("$templateDir/pwcForm.php");
  }
?>
  </td></tr>
  </table>
<?
  include("$libDir/footer.php");

}?>

