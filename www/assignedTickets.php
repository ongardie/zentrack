<?
  /*
  **  INDEX PAGE
  **  
  **  Provides login screen, and lists tickets for the logged in user by default
  **
  */  
  
  include("header.php");

  $page_title = "Welcome to zenTrack";
  $expand_tickets = 1;
  include("$libDir/nav.php");

  $params = array("status"=>array('OPEN','PENDING'),"userID"=>$login_id);
  if( $login_bin ) {
    $params["binID"] = $login_bin;
  } else {
    $params["binID"] = $zen->getUsersBins($login_id);
  }
  if( is_array($params) )
    $tickets = $zen->get_tickets($params);
  include("$templateDir/listTickets.php");

  include("$libDir/footer.php");
?>
