<?
  /*
  **  EDIT USER
  **  
  **  Modifies an existing user account
  **
  */
  
  
  include("./admin_header.php");

  $page_tile = "Edit User";
  include("$libDir/nav.php");

  $user = $zen->get_user($uid);
  
  if( $uid == 1 && $login_id != 1 ) {
    print "<ul><b>The Root Admin Account can only be modified by the Root Administrator</b></ul>\n";    
  } else if( is_array($user) ) {
    $TODO = 'EDIT';
    extract($user);
    include("$templateDir/userAdd.php");
  } else {
    print "<ul><b>That user could not be found</b>";
    print "<br><a href='$rootUrl/admin/listUsers.php'>Click Here</a>";
    print " to search for users</a></ul>\n";
  }

  include("$libDir/footer.php");

?>
