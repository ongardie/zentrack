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
		  "status"  => array("OPEN","PENDING"),
		  "userID"  => $login_id
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
    $params["binID"] = $zen->getUsersBins($login_id);
  }
  if( is_array($params) )
    $tickets = $zen->get_tickets($params);
  include("$templateDir/listTickets.php");

  include("$libDir/footer.php");
?>
