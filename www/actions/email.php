<?{
   
  /*
  **  EMAIL TICKET
  **  
  **  send an email containing all the information for this ticket
  **
  */

  $action = "email";  
  include("./action_header.php");

   // Variables that must be in the form which submits
   // to this page:
   //   $emethod (int-1 or 2)
   //     $users_to_email (array)
   //     $custom_email_addresses (comma delimited list)
   //   $id (int)
   //   $method (int)
   //     (1-link_only,2-ticket_summary,3-ticket_and_log)
   //   $comments
   
  if( $actionComplete == 1 ) {
     $inputParams = array(
			  "emethod"         => "int",
			  "id"              => "int",
			  "method"          => "int",
			  "comments"        => "text",
			  "users_to_email"  => "array",
			  "custom_email_addresses" => "text"
			  );
     $zen->cleanInput($inputParams);
     $required = array("id","emethod","method");
     $required[] = ($emethod == 1)? "users_to_email" : "custom_email_addresses";
     foreach($required as $r) {
	if( !strlen($$r) && !is_array($$r) ) {
	   $r = ucwords(ereg_replace("_", " ", $r));
	   $errs[] = "$r is required";
	}
     }
     if( $emethod == 1 ) {
	$recipients = $users_to_email;
     } else {
	$recipients = explode(",", $custom_email_addresses);
     }  
     
     $subject = "[{$zen->settings['system_name']}] ".$zen->getTypeName($ticket["type_id"])." $id";
     unset($params);
     if( $comments )
       $params["message"] = $comments;
     if( $method == 1 ) {
	$params["link"] = $id;
     } else if( $method == 2 ) {
	$params["tid"] = $id;
     } else if( $method == 3 ) {
	$params["tid"] = $id;
	$params["log"] = $id;
     }
     if( !is_array($recipients) )
	$errs[] = "There were no recipients";
     $message = $zen->formatEmailMessage($params);
     if( !$errs ) {
	$res = $zen->sendEmail($recipients, $subject, $message, $login_id);
	if( $res ) {
	   add_system_messages("Ticket $id emailed to selected recipients");
	   header("Location:$rootUrl/ticket.php?id=$id&setmode=system");
	   unset($action);
	   exit;
	} else {
	   $errs[] = "System error: Ticket $id could not be emailed".$zen->db_error;
	}
     }
     if( $errs )
       add_system_messages( $errs, 'Error' );     
  }

  include("$libDir/nav.php");
   
  extract($ticket);
  if( strtolower($zen->types["$type_id"]) == "project" ) {
     include("$templateDir/projectView.php");
  } else {
     include("$templateDir/ticketView.php");     
  }

  include("$libDir/footer.php");

}?>
