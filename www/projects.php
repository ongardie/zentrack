<?
  /*
  **  PROJECTS LIST PAGE
  **  
  **  Lists all current projects
  **
  */  
  
  include("header.php");

  $params = array(
		  "type_id"  => $zen->projectTypeIDs(),
		  "status"  => array("OPEN","PENDING")
		  );
  $page_tile = "Projects";
  $page_section = "Projects";
  if( $login_bin ) {
     $page_section .= " - ".$zen->bins["$login_bin"];
  }
  $expand_projects = 1;
  include("$libDir/nav.php");

  $userBins = $zen->getUsersBins($login_id);

  if( !is_array($userBins) || count($userBins) < 1 ) {
     print "<p class='hot'>You do not have access to any existing bins</p>\n";     
  } else {
     if( $login_bin ) {
	$params["bin_id"] = $login_bin;
     } else {
	$params["bin_id"] = $userBins;
     }
     if( is_array($params) ) 
       $tickets = $zen->get_tickets($params);
     include("$templateDir/listTickets.php");
  }
  include("$libDir/footer.php");
?>
