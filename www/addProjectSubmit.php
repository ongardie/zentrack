<?
  /*
  **  NEW PROJECT (add submit)
  **  
  **  Commit new project to database
  **
  */
    
  include("header.php");

  if( !$zen->checkAccess($login_id,$bin_id,"create") ) {
     $page_tile = "Access Error";
     $msg = "<p class='hot'>You do not have permission to create tickets in this bin.</p>\n"; 
     include("$libDir/nav.php");     
     include("$libDir/footer.php");
     exit;
  }

  $page_tile = "Commit New Project";
  $expand_projects = 1;

  // initiate default values
  $otime = time();  // set time ticket opened
  if( $deadline ) {
     $deadline = $zen->dateParse($deadline);
  }
  if( $start_date ) {
     $start_date = $zen->dateParse($start_date);
  }

  $type_id = $zen->projectTypeID();
  $description = nl2br(htmlspecialchars($description));

  $fields = array(
		  "title"       => "text",
		  "priority"    => "int",
		  "description" => "ignore",
		  "otime"       => "int",
		  "bin_id"       => "int",
		  "type_id"      => "int",
		  "user_id"      => "int",
		  "system_id"    => "int",
		  "tested"      => "int",
		  "approved"    => "int",
		  "relations"   => "text",
		  "project_id"   => "int",
		  "est_hours"   => "num",
		  "deadline"    => "int",
		  "start_date"  => "int"
		  );
 $required = array(
		   "title",
		   "priority",
		   "description",
		   "bin_id",
		   "type_id",
		   "system_id"
		   );
  $zen->cleanInput($fields);
  // check for required fields
  foreach($required as $r) {
     if( !$$r ) {
	$errs[] = ucfirst($r)." is a required field";
     }
  }
  if( !$errs ) {
     // create an array of existing fields
     foreach(array_keys($fields) as $f) {
	if( strlen($$f) ) {
	   $params["$f"] = $$f;
	}
     }
     $params["creator_id"] = $login_id;
     // add the ticket to db
     $id = $zen->add_ticket($params);
     // check for errors
     if( !$id ) {
	$errs[] = "Could not create ticket. ".$zen->db_error;
     }
  }

  if( !$errs ) {
     include("./project.php");
     exit;
     //header("Location:$rootUrl/project.php?id=$id");
  } else {
     include("$libDir/nav.php");
     $zen->print_errors($errs);
     include("$templateDir/newProjectForm.php");
     include("$libDir/footer.php");
  }
?>
