<?
  /*
  **  INDEX PAGE
  **  
  **  Provides login screen, and lists tickets for the logged in user by default
  **
  */  
  
  include_once(dirname(__FILE__)."/header.php");
  
  $page_title = tr("Welcome to zenTrack");
  $expand_tickets = 1;
  include_once("$libDir/nav.php");
  
  $view = 'ticket_list';
  $map = new ZenFieldMap($zen);
  $fields = $map->getFieldMap($view);
  $userBins = $zen->getUsersBins($login_id);
  
  if( is_array($userBins) && count($userBins) ) {
    $params = array(
    "status"  => array('OPEN','PENDING'),
    "type_id" => $zen->notProjectTypeIDs()
    );
    if( $login_bin > 0 ) {
      $params["bin_id"] = $login_bin;
    } else {
      $params["bin_id"] = $zen->getUsersBins($login_id);
    }
    include("$libDir/sorting.php");
    $tickets = $zen->get_tickets($params, $orderby);
    include("$templateDir/listTickets.php");
    if( count($tickets) ) {
      include("$libDir/paging.php"); //Addition for paging
    }
  } else {
    print "<p class='hot'>" . tr("You do not have access to any existing bins") . "</p>\n";
  }
  include("$libDir/footer.php");
?>