<?
  /*
  **  NEW PROJECT
  **  
  **  Create a new project
  **
  */
  
  
  include("header.php");

  $page_title = tr("Create a New Project");
  $expand_projects = 1;
  $onLoad[] = "behavior_js.php?formset=newProjectForm&mode=create";

  include("$libDir/nav.php");

  $page_type = 'project';
  $view = 'project_create';
  include("$templateDir/newTicketForm.php");

  include("$libDir/footer.php");
?>
