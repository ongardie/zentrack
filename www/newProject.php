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
  $onLoad = array("behavior_js.php?formset=ticketForm");

  include("$libDir/nav.php");

  include("$templateDir/newProjectForm.php");

  include("$libDir/footer.php");
?>
