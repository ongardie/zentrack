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

  include("../header.php");

  // set the ticket mode to system
  $page_mode = 'system';
  $setmode = 'system';

  // check to insure a ticket id was passed
  $id = ereg_replace("[^0-9]", "", $id);
  if( !$id )
    header("Location: $rootUrl/index.php\n");

  // check to insure that this user has access
  // and this ticket allows the requested action
  // to be completed
  $ticket = $zen->get_ticket($id);
  $tid = $ticket["type_id"];
  if( in_array($tid,$zen->projectTypeIDs()) ) {
     $ticket["children"] = $zen->getProjectChildren($id, array("id,title,status,est_hours,wkd_hours"));
     list($ticket["est_hours"],$ticket["wkd_hours"]) = $zen->getProjectHours($id);
     $page_type = "project";
  }  else {
    $page_type = "ticket";
  }
  $page_mode = "system";
  $tf_creator = (($action == "print"||$action == "email")&&$zen->checkCreator($login_id,$tid));
  if( !$zen->actionApplicable( $id, $action, $login_id ) && !$tf_creator )
    header("Location: $rootUrl/ticket.php?id=$id&setmode=details");

  // set up page paremeters
  $page_title = "Ticket #$id";
  $page_section = "Ticket #$id";
  $expand_tickets = 1;

?>