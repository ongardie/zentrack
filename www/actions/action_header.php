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
  $login_mode = 'system';

  // check to insure a ticket id was passed
  $id = ereg_replace("[^0-9]", "", $id);
  if( !$id )
    header("Location: $rootUrl/index.php\n");

  // check to insure that this user has access
  // and this ticket allows the requested action
  // to be completed
  $ticket = $zen->get_ticket($id);
  $tid = $ticket["type_id"];
  if( $zen->types["$tid"] == "Project" ) {
     $ticket["children"] = $zen->getProjectChildren($id, array("id,title,status,est_hours,wkd_hours"));
     list($ticket["est_hours"],$ticket["wkd_hours"]) = $zen->getProjectHours($id);
  }
  if( !$zen->actionApplicable( $id, $action, $login_id ) )
    header("Location: $rootUrl/ticket.php?id=$id&setmode=details");


  // set up page paremeters
  $page_title = "Ticket #$id";
  $page_section = "Ticket #$id";
  $expand_tickets = 1;

?>
