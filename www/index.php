<?
  /*
  **  INDEX PAGE
  **  
  **  Provides login screen, and lists tickets for the logged in user by default
  **
  */  
  
  include_once("header.php");

  $page_title = "Welcome to zenTrack";
  $expand_tickets = 1;
  include_once("$libDir/nav.php");

  $userBins = $zen->getUsersBins($login_id);
  
  if( is_array($userBins) || count($userBins) < 1 ) {
     $params = array(
		     "status"  => array('OPEN','PENDING'),
		     "type_id" => $zen->notProjectTypeIDs()
		     );
     if( $login_bin ) {
	$params["bin_id"] = $login_bin;
     } else {
 	$params["bin_id"] = $zen->getUsersBins($login_id);
     }
     if( is_array($params) )
       $tickets = $zen->get_tickets($params);
     include("$templateDir/listTickets.php");
  } else {
     print "<p class='hot'>You do not have access to any existing ".$zen->system_name." bins</p>\n";
  }
  include("$libDir/footer.php");
?>
