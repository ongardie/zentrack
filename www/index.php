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

  $userBins = $zen->getUsersBins($login_id);
  
  if( is_array($userBins) || count($userBins) < 1 ) {
     $params = array("status"=>array('OPEN','PENDING'));
     if( $login_bin ) {
	$params["binID"] = $login_bin;
     } else {
	unset($params["binID"]);
	$access = $zen->getAccess($login_id);
	if( is_array($access) ) {
	   foreach($zen->bins as $k=>$b) {
	      if( ($access["$k"] >= $zen->settings["level_view"]) || (!$access && $login_level >= $zen->settings["level_view"]) ) {
		 $params["binID"][] = $k;
	      }
	   }
	} else if( $login_level >= $zen->settings["level_view"] ) {
	   $params["binID"] = array_keys($zen->bins);
	}
     }
     if( is_array($params) )
       $tickets = $zen->get_tickets($params);
     include("$templateDir/listTickets.php");
  } else {
     print "<p class='hot'>You do not have access to any existing ".$zen->system_name." bins</p>\n";
  }
  include("$libDir/footer.php");
?>
