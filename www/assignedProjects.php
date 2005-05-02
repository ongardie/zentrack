<?
  /*
  **  PROJECTS LIST PAGE
  **  
  **  Lists all current projects
  **
  */  
  
  include("header.php");

  $page_type = "project";
  $view = 'project_list';

  $params = array(
		  "type_id"  => $zen->projectTypeIDs(),
		  "status"  => array("OPEN","PENDING"),
		  "user_id"  => $login_id
		  );
  $page_title = tr("Projects");
  $page_section = "Projects";
  if( $login_bin ) {
     $page_section .= " - ".$zen->bins["$login_bin"];
  }
  $expand_projects = 1;
  include("$libDir/nav.php");

  
  if( $login_bin ) {
    $params["bin_id"] = $login_bin;
  } else {
    $params["bin_id"] = $zen->getUsersBins($login_id);
  }
  if( is_array($params) )
    $tickets = $zen->get_tickets($params);
    
  include("$templateDir/listTickets.php");

  include("$libDir/footer.php");
?>
