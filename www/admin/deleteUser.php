<?
  /*
  **  NEW USER
  **  
  **  Creates a new zenTrack user
  **
  */
  
  
  include("admin_header.php");

  if( $user_id == 1 ) {
    $errs[] = "The root administrator account cannot be deleted";
  } else {
    if( $zen->demo_mode == "on" ) {
      $msg = "The action completed successfully.  The account was not actually deleted, because this is a demo site";
    } else {
      $res = $zen->delete_user($user_id);
      if( !$res ) {
	$errs[] = "The account ($user_id) could not be found/deleted successfully";
      } else {
	$msg = "The account($user_id) was successfully removed";
      }
    }
  }

  $page_title = "Delete User";
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include("$templateDir/adminMenu.php");
  include("$libDir/footer.php");

?>
