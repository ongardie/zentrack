<?{

  /*
  **  EDIT BEHAVIORS
  **  
  **  Edit/create/delete the behaviors
  **
  */
  

  include("admin_header.php");

  $vars = array();
  $vars = $zen->getBehaviorList(0);

  $page_title = ($skip)? tr("Admin Section") : tr("Edit Behaviors");
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include("$templateDir/behaviorForm.php");
  
  include("$libDir/footer.php");

}?>









