<?
  /*
  **  TICKET DISPLAY PAGE
  **  
  **  Displays a ticket to the screen
  **
  */
  
  // include the header file
  include("header.php");

  if( $page != "project" )
      $page = "ticket";
  // redirect to somewhere user can pick a ticket if no id was recieved
  if( !$id )
    header("Location: $rootUrl/index.php\n");

  /*
  **  GET TICKET INFORMATION
  */
  $page_title = "Ticket #$id";

  /*
  **  GET PARAMS FOR A PROJECT
  */
  if( $page_type == "project" ) {
     if( $project_mode == "" )
	$project_mode = 'details';    
     $ticket = $zen->get_project($id);
     $page_section = "Project $id";
     $expand_projects = 1;
  } else {
     $page_type = "ticket";
     $ticket = $zen->get_ticket($id);
     if( $ticket_mode == "" )
	$ticket_mode = 'details';
     $page_section = $zen->types["$ticket[type_id]"]." #$id";
     $expand_tickets = 1;     
  }

  // allow creator of ticket to view (if setting is on) even if no access
  $is_creator = ($login_id == $ticket["creator_id"] && $zen->settings["allow_cview"] == "on");

  /*
  ** PRINT OUT THE PAGE
  */ 
  include("$libDir/nav.php");

  if( !$is_creator && !$zen->checkAccess($login_id,$ticket["bin_id"]) ) {
     print "<p class='hot'>You are not allowed to view {$page_type}s in this bin</p>\n";
  } else {

    if( is_array($ticket) ) {
      extract($ticket);
      if( $type_id == $zen->projectTypeID() ) {
	include("$templateDir/projectView.php");
      } else {
	include("$templateDir/ticketView.php");     
      }
    } else {
      print "<p class='error'>That ticket doesn't exist</p>\n";
    }
     
  }

  include("$libDir/footer.php");
?>
