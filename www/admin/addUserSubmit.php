<?{
   
  /*
  **  NEW USER SUBMIT
  **  
  **  Commits a new zenTrack user to db
  **
  */
  
  include("./admin_header.php");
  $page_tile = "New User Submit";

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

  if( !$errs ) {
    foreach(array_keys($user_fields) as $k) {
      if( strlen($$k) ) {
	$params["$k"] = $$k;
      }
    }
    if( $zen->demo_mode == "on" ) {
      $msg = "Process completed successfully.  Account not added, because this is a demo site";
    } else {
      $user_id = $zen->add_user($params);
      if( $user_id ) {
	$msg = "New user #$user_id was added successfully.  The password is the last name of the user."
	  ."<br><a href='$rootUrl/admin/access.php?user_id=$user_id'>Click Here</a> "
	  ." to customize user $user_id's access permissions.";
      } else {
	$errs[] = "System Error: Could not add $lname, $fname to the system";
      }
    }
  }

  include("$libDir/nav.php");
  if( $errs ) {
    $zen->printErrors($errs);
    include("$templateDir/userAdd.php");
  } else {
    include("$templateDir/adminMenu.php");
  }

  include("$libDir/footer.php");

}?>