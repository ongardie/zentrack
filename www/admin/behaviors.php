<?{

  /*
  **  EDIT BEHAVIORS
  **  
  **  Edit/create/delete the behaviors
  **
  */
  

  include("admin_header.php");

  $page_title = ($skip)? tr("Admin Section") : tr("Edit Behaviors");
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include("$templateDir/behaviorMenu.php");
  
  include("$libDir/footer.php");

}?>









