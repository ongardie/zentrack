<?
  /*
  **  TICKET DISPLAY PAGE
  **  
  **  Displays a ticket to the screen
  **
  */
  
  // include the header file
  include("header.php");

  // redirect to somewhere user can pick a ticket if no id was recieved
  if( !$id )
    header("Location: $rootUrl/index.php\n");

  /*
  **  GET TICKET INFORMATION
  */
  $page_title = "Ticket #$id";
  $ticket = $zen->get_ticket($id);

  /*
  **  GET PARAMS FOR A PROJECT
  */
  if( $ticket["typeID"] == $zen->projectTypeID() ) {
     unset($ticket);
     $ticket = $zen->get_project($id);
     $page_section = "Project $id";
     $expand_projects = 1;
  } else {
     if( strtolower($login_mode) == 'tasks' )
	$login_mode = 'details';
     $page_section = $zen->types["$ticket[typeID]"]." #$id";
     $expand_tickets = 1;     
  }

  // allow creator of ticket to view (if setting is on) even if no access
  $is_creator = ($login_id == $ticket["creatorID"] && $zen->settings["allow_cview"] == "on");

  /*
  ** PRINT OUT THE PAGE
  */ 
  include("$libDir/nav.php");

  if( !$is_creator && !$zen->checkAccess($login_id,$ticket["binID"]) ) {
     print "<p class='hot'>You are not allowed to view tickets in this bin</p>\n";
  } else {

     extract($ticket);
     if( $typeID == $zen->projectTypeID() ) {
	include("$templateDir/projectView.php");
     } else {
	include("$templateDir/ticketView.php");     
     }
     
  }

  include("$libDir/footer.php");
?>
