<?{
   
  /*
  **  NEW USER SUBMIT
  **  
  **  Commits a new zenTrack user to db
  **
  */
  
  include("./admin_header.php");
  $page_tile = "New User Submit";

  $zen->cleanInput($user_fields);
  foreach($user_required as $u) {
    if( !strlen($$u) ) {
      $errs[] = ucfirst($u)." is required";
    }
  }
  if( !$accessLevel ) {
    $accessLevel = 0;
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
      $userID = $zen->add_user($params);
      if( $userID ) {
	$msg = "New user #$userID was added successfully."
	  ."<br><a href='$rootUrl/admin/access.php?userID=$userID'>Click Here</a> "
	  ." to customize user $userID's access permissions.";
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
