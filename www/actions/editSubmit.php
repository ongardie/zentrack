<?
  /*
  **  EDIT TICKET (edit submit)
  **  
  **  Commit changes to database
  **
  */
  
  include("./action_header.php");

  $page_tile = "Commit Edited Ticket";
  $expand_tickets = 1;

  // initiate default values
  $otime = time();  // set time ticket opened
  if( $deadline ) {
     $deadline = $zen->dateParse($deadline);
  }
  if( $start_date ) {
     $start_date = $zen->dateParse($start_date);
  }

  $fields = array(
		  "title"       => "text",
		  "priority"    => "int",
		  "description" => "html",
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
     // update the ticket info
     $res = $zen->update_ticket($id,$params);
     // check for errors
     if( !$res ) {
	$errs[] = "Ticket $id could not edit ticket. ".$zen->db_error;
     }
  }

  if( !$errs ) {
     add_system_messages("Edited ticket $id.");
     $setmode = "details";
     include("../ticket.php");
     exit;
     //header("Location:$rootUrl/ticket.php?id=$id&setmode=Details");
  } else {
     add_system_messages($errs);
     include("$libDir/nav.php");
     $zen->print_errors($errs);
     include("$templateDir/newTicketForm.php");
     include("$libDir/footer.php");
  }
?>
