<?
  /*
  **  NEW TICKET (add submit)
  **  
  **  Commit new ticket to database
  **
  */
  
  
  include("header.php");

  $page_tile = "Commit New Ticket";
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
		  "description" => "ignore",
		  "otime"       => "int",
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
	if( strlen($$f) ) {
	   $params["$f"] = $$f;
	}
     }
     $params["creatorID"] = $login_id;
     // add the ticket to db
     $id = $zen->add_ticket($params);
     // check for errors
     if( !$id ) {
	$errs[] = "Could not create ticket. ".$zen->db_error;
     }
  }

  if( !$errs ) {
     header("Location:$rootUrl/ticket.php?id=$id");
  } else {
     include("$libDir/nav.php");
     $zen->print_errors($errs);
     include("$templateDir/newTicketForm.php");
     include("$libDir/footer.php");
  }
?>
