<?
  /*
  **  NEW PROJECT
  **  
  **  Create a new project
  **
  */
  
  
  include("header.php");

  $page_tile = tr("Create a New Project");
  $expand_projects = 1;
  include("$libDir/nav.php");

  include("$templateDir/newProjectForm.php");

  include("$libDir/footer.php");
?>
