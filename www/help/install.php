<?

  /*
  **  HELP SECTION - INSTALL
  */

  include("./help_header.php");

  $page_title = "About ".$zen->settings["system_name"];
  include("$libDir/nav.php");

  readfile("./install.html");

  include("$libDir/footer.php");
?>


