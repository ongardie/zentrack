<?
  /*
  **  PROJECTS LIST PAGE
  **  
  **  Lists all current projects
  **
  */  
  
  include("header.php");

  $params = array(
		  "typeID"  => $zen->projectTypeID(),
		  "status"  => array("OPEN","PENDING")
		  );
  $page_tile = "Projects";
  $page_section = "Projects";
  if( $login_bin ) {
     $page_section .= " - ".$zen->bins["$login_bin"];
  }
  $expand_projects = 1;
  include("$libDir/nav.php");

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

  include("$libDir/footer.php");
?>
