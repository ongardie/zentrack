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
     if( $params["type_id"] == $zen->noteTypeID() ) {
       $params["status"] = "CLOSED";
       $params["tested"] = 0;
       $params["approved"] = 0;
       $params["ctime"] = time();
       unset($params["user_id"]);
     } else {
       $params["status"] = "OPEN";
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
     header("Location:$rootUrl/ticket.php?id=$id");
  } else {
     include("$libDir/nav.php");
     $zen->print_errors($errs);
     include("$templateDir/newTicketForm.php");
     include("$libDir/footer.php");
  }
?>
