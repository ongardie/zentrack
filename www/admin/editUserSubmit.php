<?{
   
  /*
  **  EDIT USER SUBMIT
  **  
  **  Commits zenTrack user modifications to db
  **
  */
  
  include("./admin_header.php");
  $page_tile = "Edit User Submit";

  if( !$active )
    $active = 0;
  $zen->cleanInput($user_fields);
  foreach($user_required as $u) {
    if( !strlen($$u) ) {
      $errs[] = ucfirst($u)." is required";
    }
  }
  if( !$access_level ) {
    $access_level = 0;
  }

  // security checks for the root administrator account
  if( $user_id == 1 && $access_level < 5 ) {
    $errs[] = "The root admin account must have access of 5 or greater";
  }
  if( $user_id == 1 && $access_level < $zen->settings["level_settings"] ) {
    $errs[] = "The root admin access cannot be less than the level_settings parameter";
  }
  if( $user_id == 1 && !$active ) {
    $errs[] = "The root admin account cannot be deactivated";
  } else if( $user_id == 1 ) {
    $active = 2;
  }

  if( !$errs ) {
    foreach(array_keys($user_fields) as $k) {
      if( strlen($$k) ) {
	$params["$k"] = $$k;
      }
    }
    if( $zen->demo_mode == "on" ) {
      $msg = "Process successful.  User was not updated, because this is a demo site.";
    } else {
      $res = $zen->update_user($user_id, $params);
      if( $res ) {
	$msg = "User $user_id was updated successfully."
	  ."<br><a href='$rootUrl/admin/access.php?user_id=$user_id'>Click Here</a> "
	  ." to customize user $user_id's access permissions.";
      } else {
	$errs[] = "System Error: Could not update $lname, $fname";
      }
    }
  }

  include("$libDir/nav.php");
  if( $errs ) {
    $zen->printErrors($errs);
    $TODO = 'EDIT';
    include("$templateDir/userAdd.php");
  } else {
    include("$templateDir/adminMenu.php");
  }

  include("$libDir/footer.php");

}?>
