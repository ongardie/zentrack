<?{
  
  /*
  **  LOG TICKET
  **  
  **  Create a log entry
  **
  */
  
  $action = "log";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
    $input = array(
    "id"       => "int",
    "comments" => "text",
    "hours"    => "num",
    "log_action"   => "text"
    );
    $zen->cleanInput($input);
    $required = array("id","action");
    foreach($required as $r) {
      if( !$$r ) {
        $errs[] = tr(" ? is required", array($r));
      }
    }     
    if( $log_action == 'LABOR' ) {
      if( !$hours )
      $errs[] = tr("Hours must be entered if the activity is 'LABOR'");
    } else if( !$comments ) {
      $errs[] = tr("No comments were entered.");
    }
    
    
    if( !$errs ) {
      $res = $zen->log_ticket($id, $login_id, $log_action, $hours, $comments);
      if( $res ) {
        add_system_messages(tr("Activity has been logged."));
        $setmode = "log";
        include("../ticket.php");
        exit;
        //header("Location:$rootUrl/ticket.php?id=$id&setmode=log");
      } else {
        $errs[] = tr("System error: Activity could not be logged.").$zen->db_error;
      }
    }
    if( $errs )
    add_system_messages( $errs, 'Error' );     
  }
  
  include("$libDir/nav.php");
  
  if( $actionComplete == 1 && $page_type == "project" ) {
    $ticket = $zen->get_project($id);
  }
  else if( $actionComplete ) {
    $ticket = $zen->get_ticket($id);
  }
  extract($ticket);
  if( $page_type == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  
  include("$libDir/footer.php");
  
}?>