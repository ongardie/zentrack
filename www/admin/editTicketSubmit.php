<?
  /*
  **  EDIT TICKET (edit submit)
  **  
  **  Commit changes to database
  **
  */
  
  
  include("./admin_header.php");

  $page_tile = "Commit Edited Ticket";
  $expand_admin = 1;

  // initiate default values
  if( $deadline ) {
     $deadline = $zen->dateParse($deadline);
  }
  if( $start_date ) {
     $start_date = $zen->dateParse($start_date);
  } 
  if( !$tested )
     $tested = 0;
  if( !$approved )
     $approved = 0;
  if( $type == "project" )
     $typeID = $zen->projectTypeID();

  $fields = array(
		  "title"       => "text",
		  "priority"    => "int",
		  "description" => "html",
		  "binID"       => "int",
		  "typeID"      => "int",
		  "userID"      => "int",
		  "systemID"    => "int",
		  "tested"      => "int",
		  "approved"    => "int",
		  "relations"   => "text",
		  "projectID"   => "int",
		  "est_hours"   => "num",
		  "deadline"    => "int",
		  "start_date"  => "int"
		  );
 $required = array(
		   "title",
		   "priority",
		   "description",
		   "binID",
		   "typeID",
		   "systemID"
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
         $params["$f"] = $$f;
     }
     // update the ticket info
     $res = $zen->update_ticket($id,$params);
     // check for errors
     if( !$res ) {
	$errs[] = "System Error: Ticket $id could not be edited. ".$zen->db_error;
     }
  }

  if( !$errs ) {
     add_system_messages("Edited ticket $id.");
     header("Location:$rootUrl/ticket.php?id=$id&setmode=Details");
  } else {
     include("$libDir/nav.php");
     $zen->print_errors($errs);
     $TODO = 'EDIT';
     if( $zen->projectTypeID() == $ticket["typeID"] )
       include("$templateDir/newProjectForm.php");
     else
       include("$templateDir/newTicketForm.php");
     include("$libDir/footer.php");
  }
?>


