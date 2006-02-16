<?{

  /*
  **  VIEW HOT KEY CONFIGURATION
  **
  **  This page does not require any manual translation. It provides a list
  **  of all the current hotkey settings from the database.
  */
  
  $b = realpath(dirname(dirname(__FILE__)));
  include_once("$b/help_header.php");
  $page_title = tr("Hot Key Settings");
  include("$libDir/nav.php");
  include("$templateDir/listHotKeys.php");
  include("$libDir/footer.php");
  
}?>
