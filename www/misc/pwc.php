<?{

  /*
  **  CHANGE PASSWORD
  **  
  **  Change the passphrase for the logged in user
  **
  */
  
  include("../header.php");

  $page_tile = "Change Password";
  $expand_options = 1;

  if( $TODO == 'SET' ) {
    if( !$newPass1 || !$newPass2 ) {
      $errs[] = "Please fill in both of the fields";
    } else if( $newPass1 != $newPass2 ) {
      $errs[] = "Your passwords did not match";
    } else {
      if( $zen->settings["check_pwd_simple"] == "on" && strlen($newPass1) < 6 ) 
				$errs[] = "Your passphrase must be at least 6 digits long";
      if( $zen->settings["check_pwd_simple"] == "on" && !ereg("[^a-zA-Z]", $newPass1) )
			  $errs[] = "Your new passphrase must contain at least 1 non-letter character";
  	}
  	$user = $zen->getUser($login_id);
  	if( $user["initials"] == "GUEST" ) {
  	  $errs[] = "The Guest Password cannot be changed!";
  	}

  	if( !$errs ) {
  	  $params = array();
  	  $params["passphrase"] = $newPass1;
  	  if( $zen->demo_mode == "on" ) {
			  $msg = "Your request was successful, but this is a demo site, so the passphrase was not altered";
				$skip = 1;
  	  } else {
				$res = $zen->update_user($login_id,$params);
				if( !$res ) {
				  $errs[] = "System Error: Unable to change user passphrase.";
				} else {
				  $skip = 1;
				  $msg = "Password successfully changed";
				}
  	  }
			if( $skip ) {
				$login_level = $user["access_level"];
			}
  	}
  }

  // if we made it this far, then the passphrase wasn't changed,
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

