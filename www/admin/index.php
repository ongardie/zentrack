<?
  /*
  **  ADMIN INDEX PAGE
  **  
  **  Checks access and shows settings menus for qualified users
  **
  */
  
  
  include("../header.php");

  $page_tile = "Admin Section";
  $expand_tickets = 1;
  $section = "Admin";
  include("$libDir/nav.php");

  if( $login_level >= $zen->settings["level_settings"] ) {
     include("$templateDir/adminMenu.php");
  } else {
     print "<span class='hot'>Sorry, you do not have access to the administrative settings</span>\n";
  }

  include("$libDir/footer.php");
?>
