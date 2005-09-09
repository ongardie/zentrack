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
  
  // determine if we are viewing a project or a ticket
  if( !isset($view) || $view != 'project_view' ) {
    $view = 'ticket_view';
  }
  
  // redirect to somewhere user can pick a ticket if no id was recieved
  if( !$id ) {
    $pt = $view == 'project_view'? 'projects.php' : 'index.php';
    include("$rootWWW/$pt");
    exit;
    //header("Location: $rootUrl/index.php\n");
  }
  
  // load the ticket info, validate it, and switch 
  // to the project view if needed
  if( $view == "project_view" ) {
    $ticket = $zen->get_project($id);
  } else {
    $ticket = $zen->get_ticket($id);
    if( is_array($ticket) ) {
      if( $zen->inProjectTypeIDs($ticket["type_id"]) ) {
        $ticket = $zen->get_project($id);
        $view = 'project_view';
      }
    }
  }
  
  // set the page type now that we have decided on a view
  preg_match('@^(project|ticket)_view$@', $view, $matches);
  $page_type = $matches[1];
  
  // if there is no ticket for this id, then load the list and
  // inform the user of the bad choice
  if( !is_array($ticket) || !count($ticket) ) {
    $pt = $page_type == 'project'? 'projects.php' : 'index.php';
    $msg = tr("Invalid ? id requested", array(tr($page_type)));
    include("$rootWWW/$pt");
    exit;
  }  
  
  // load hot keys for page
  $hotkeys->loadSection($view);
  
  // place record into history of recently viewed items
  $history =& $zen->getHistoryManager();
  $history->storeItem($page_type, $id, $ticket['title']);  

  /*
  **  Collect information for displaying nav and UI elements
  */
  $page_title = $zen->getTypeName($ticket['type_id'])." #$id";
  
  // allow creator of ticket to view (if setting is on) even if no access
  $is_creator = $zen->checkCreator($login_id, $id);
  
  // determine which page we will view
  if( $setmode ) {
    $page_mode = preg_replace('@[^0-9a-zA-Z_]@', '', $setmode);
  }
  if( !$page_mode ) {
    $page_mode = "{$page_type}_tab_1";
  }
  
  // load behavior js if needed
  if( preg_match("@^{$page_type}_tab_[0-9]$@", $page_mode) ) {
    if( $map->getViewProp($page_mode, 'editable') ) {
      $onLoad[] = "behavior_js.php?formset=$page_mode";
    }
  }
  
  /*
  ** PRINT OUT THE PAGE
  */ 
  include_once("$libDir/nav.php");
  
  if( !$is_creator && !$zen->checkAccess($login_id,$ticket["bin_id"]) ) {
    print "<p class='hot'>" . tr("You are not allowed to view ? in this bin", array(tr($page_type."s"))) ."</p>";
  } else {
    include("$templateDir/ticketView.php");
  }
  
  include("$libDir/footer.php");
}?>
