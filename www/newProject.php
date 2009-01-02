<?
  /*
  **  NEW PROJECT
  **  
  **  Create a new project
  **
  */
  
  
  define("ZT_SECTION","projects");
  include("header.php");

  $page_title = tr("Create a New Project");
  $expand_projects = 1;
  $onLoad[] = "behavior_js.php?formset=ticketForm&mode=create";

  // yahoo libs for addbox
  $ext = $Debug_Mode == 3? "-debug" : "-min";
  $onLoad[] = "js/addBoxFunctions.js";
  // we load them as a single file from the yui network
  $onLoad[] = "http://yui.yahooapis.com/combo?2.5.2/build/yahoo-dom-event/yahoo-dom-event.js&2.5.2/build/connection/connection{$ext}.js&2.5.2/build/json/json{$ext}.js";
  
  include("$libDir/nav.php");

  $page_type = 'project';
  $view = 'project_create';
  include("$templateDir/newTicketForm.php");

  include("$libDir/footer.php");
?>
