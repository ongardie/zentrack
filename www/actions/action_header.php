<?
  
  /*
  **  ACTION HEADER
  **
  **  global to all ticket action pages
  **
  **  Prepare some variables for the
  **  action pages, and include the main
  **  page header
  */

  include_once("../header.php");

  // set the ticket mode to system
  $page_mode = 'system';
  $setmode = 'system';

  // check to insure a ticket id was passed
  $id = ereg_replace("[^0-9]", "", $id);
  if( !$id ) {
    $zen->addDebug("action_header","No ticket id, redirecting",1);
    include("../index.php");
    exit;
  }
  // use the filename to 
  // determine the action
  $basename = strtolower(basename($SCRIPT_NAME,".php"));
  if( in_array($basename,array_keys($zen->getActions())) ) {
    $action = $basename;
  }
  else if( $basename == "editticketsubmit" || $basename == "editsubmit" ) {
    $action = "edit";
  }
  else if( $basename == "addtonotify" || $basename == "dropfromnotify" ) {
    $action = "notify";
  } 
  else if( !$action ) {
    $action = "view";
  }

  // check to insure that this user has access
  // and this ticket allows the requested action
  // to be completed
  $ticket = $zen->get_ticket($id);
  $tid = $ticket["type_id"];
  if( in_array($tid,$zen->projectTypeIDs()) ) {
    $ticket["children"] = $zen->getProjectChildren($id, 
	    array("id,title,status,est_hours,wkd_hours"));
    list($ticket["est_hours"],$ticket["wkd_hours"]) = $zen->getProjectHours($id);
    $page_type = "project";
  }  else {
    $page_type = "ticket";
  }
  $page_mode = "system";

  // find out if this is the ticket's creator (special conditions apply)
  $tf_creator = (($action=="view"||$action == "print"||$action == "email")
	&&$zen->settings["allow_cview"]=="on"
	&&$zen->checkCreator($login_id,$tid));


  // find out if user can do this action, if not, redirect them
  if( !$zen->actionApplicable( $id, $action, $login_id ) && !$tf_creator ) {
    $setmode = "details";
    $zen->addDebug("action_header.php","Action was not applicable, redirecting",1);
    include("../ticket.php");
    exit;
  }

  // set up page paremeters
  $page_title = "Ticket #$id";
  $page_section = "Ticket #$id";
  $expand_tickets = 1;

?>
