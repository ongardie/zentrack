<?
  /*
  **  INDEX PAGE
  **  
  **  Provides login screen, and lists tickets for the logged in user by default
  **
  */  
  
  include("header.php");

  $page_type = 'ticket';
  $view = 'assigned_list';
  $map = new ZenFieldMap($zen);
  $fields = $map->getFieldMap($view);

  $page_title = tr("Tickets assigned") . ": $login_name";
  $expand_tickets = 1;
  include("$libDir/nav.php");

  $params = array("status"  => array('OPEN','PENDING'),
		  "user_id" => $login_id,
		  "type_id" => $zen->notProjectTypeIDs());
  if( $login_bin > 0 ) {
    $params["bin_id"] = $login_bin;
  }

  include_once("$libDir/sorting.php");
  $tickets = $zen->get_tickets($params, $sortstring);
  include("$templateDir/listTickets.php");

  include("$libDir/footer.php");
?>