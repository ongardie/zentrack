<?{

  /*
  **  EDIT DATA GROUPS
  **  
  **  Edit/create/delete the data groups
  **
  */
  

  include("admin_header.php");

  $vars = array();
  $vars = $zen->getDataGroups(1);

  $page_title = ($skip)? tr("Admin Section") : tr("Edit Data Groups");
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include("$templateDir/groupForm.php");
  
  include("$libDir/footer.php");

}?>









