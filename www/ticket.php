<?
  /*
  **  TICKET DISPLAY PAGE
  **  
  **  Displays a ticket to the screen
  **
  */
  
  // include the header file
  if( file_exists("header.php") ) {
    include_once("header.php");
  }

  if( $page != "project" )
      $page = "ticket";

  // redirect to somewhere user can pick a ticket if no id was recieved
  if( !$id ) {
    include("index.php");
    exit;
    //header("Location: $rootUrl/index.php\n");
  }

  /*
  **  GET TICKET INFORMATION
  */
  $page_title = tr("Ticket") . " #$id";

  /*
  **  GET PARAMS FOR A PROJECT
  */
  if( $page_type == "project" ) {
     $ticket = $zen->get_project($id);
     $page_section = "Project $id";
     $expand_projects = 1;
  } else {
     $ticket = $zen->get_ticket($id);
     if( is_array($ticket) ) {
       if( $zen->inProjectTypeIDs($ticket["type_id"]) ) {
	 unset($ticket);
	 $ticket = $zen->get_project($id);
	 $page_section = "Project $id";
	 $expand_projects = 1;
       } else {
	 $page_type = "ticket";
	 $page_section = $zen->types["$ticket[type_id]"]." #$id";
	 $expand_tickets = 1;     
       }
     }
  }

  // allow creator of ticket to view (if setting is on) even if no access
  $is_creator = ($login_id == $ticket["creator_id"] && $zen->settings["allow_cview"] == "on");

  /*
  ** PRINT OUT THE PAGE
  */ 
  include_once("$libDir/nav.php");

  if( !$is_creator && !$zen->checkAccess($login_id,$ticket["bin_id"]) ) {
     print "<p class='hot'>" . tr("You are not allowed to view the following in this bin") . ": {$page_type}s</p>\n";
  } else {

    if( is_array($ticket) ) {
      extract($ticket);
      if( $type_id == $zen->projectTypeID() ) {
	include("$templateDir/projectView.php");
      } else {
	include("$templateDir/ticketView.php");     
      }
    } else {
      print "<p class='error'>" . tr("That ticket doesn't exist") . "</p>\n";
    }
     
  }

  include("$libDir/footer.php");
?>
