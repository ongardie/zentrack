<?{
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
  else if( file_exists("../header.php") ) {
    include_once("../header.php");
  }
  
  if( $page_type != "project" )
  $page_type = "ticket";
  $page = $page_type;
  
  // redirect to somewhere user can pick a ticket if no id was recieved
  if( !$id ) {
    $pt = $page_type == 'project'? 'projects.php' : 'index.php';
    include("$rootWWW/$pt");
    exit;
    //header("Location: $rootUrl/index.php\n");
  }
  
  /*
  **  GET TICKET INFORMATION
  */
  $page_title = tr("Ticket") . " #$id";
  $varfields = $zen->getVarfieldVals($id);
  if ( !is_array($varfields) ) {
    $varfields=array();
  }
  
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
        $page_type = "project";
      } else {
        $page_type = "ticket";
        $page_section = $zen->types["$ticket[type_id]"]." #$id";
        $expand_tickets = 1;     
      }
    }
  }
  
  if( !is_array($ticket) || !count($ticket) ) {
    $pt = $page_type == 'project'? 'projects.php' : 'index.php';
    $msg = tr("Invalid ? id requested", array(tr($page_type)));
    include("$rootWWW/$pt");
    exit;
  }
  
  // allow creator of ticket to view (if setting is on) even if no access
  $is_creator = $zen->checkCreator($login_id, $id);
  
  // load behavior js if needed
  if( isset($setmode) && $setmode == 'custom' ) {
    $onLoad[] = "behavior_js.php?formset=ticket_customForm";
  }
  
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
}?>
