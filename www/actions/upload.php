<?{
   
  /*
  **  UPLOAD ATTACHMENT
  **  
  **  Create an attachment for the ticket
  **
  */

  $action = "upload";  
  include("./action_header.php");

  if( $actionComplete == 1 ) {
     
     // determine what the incoming data is, and format it
     // for use
     $ticketID = $id;
     $input = array(
		    "ticketID"       => "int",
		    "userfile_name"  => "text"
		    );
     if( $logID ) {
	$input["logID"] = "int";
     }
     $required = array_keys($input);
     $input["comments"] = "html";
     $zen->cleanInput($input);
     foreach($required as $r) {
	if( !$$r ) {
	   $errs[] = " $r is required";
	}
     }
     
     if( !$errs ) {
	// perform the file transfer to move it to the directory where we 
	// want to keep it
	
	// seed with microseconds to create a random filename
	function make_seed() {
	   list($usec, $sec) = explode(' ', microtime());
	   return (float) $sec + ((float) $usec * 100000);
	}
	mt_srand(make_seed());
	$randval = mt_rand();	          	          		
	$file_name = $ticketID."_$randval";
	while( file_exists( $zen->attachmentsDir."/$file_name" ) ) {
	   $file_name = $ticketID."_$randval";	   
	}
	$file_type = ereg_replace(".*[.]", "", $userfile_name);
	if( preg_match("/\b$file_type\b/i",$zen->settings["attachment_text_types"]) ) {
	   $userfile_type = "text/plain";
	}
        $max_size = $zen->settings["attachment_max_size"];	
	if( !is_uploaded_file($userfile) ) {
	   $errs[] = "The file was not recieved.  Check to insure it's size does not exceed ".substr($max_size,0,strlen($max_size)-3)."KB";
	} else if( $userfile_size > $max_size ) {
	   $errs[] = "The file size (".number_format($userfile_size).") exceeded the maximum allowed (".number_format($max_size).")";
	} else if( $zen->settings["attachment_types_allowed"] && !preg_match("/\b$file_type\b/i", $zen->settings["attachment_types_allowed"]) ) {
	   $errs[] = "'$file_type' is not an allowed file extension - See your systems administrator for more information";
	} else if( !$userfile_type ) {
	   $errs[] = "That is not a recognized file type, by your browsers determinations";	   
	} else if( !move_uploaded_file($userfile, $zen->attachmentsDir."/$file_name") ) {
	   $errs[] = "The file could not be uploaded ";
	}
	
	if( !$errs ) {
	   chmod($zen->attachmentsDir."/$file_name",0600);
	   $params = array(
			   "name"     => $userfile_name,
			   "filename" => $file_name,
			   "filetype" => $userfile_type
			   );
	   if( $comments )
	     $params["description"] = $comments;
	   $res = $zen->attach_to_ticket( $ticketID, $login_id, $params, $logID);
	   if( $res ) {
	      add_system_messages("Attachment $userfile_name uploaded for ticket $id");
	      header("Location: $rootUrl/ticket.php?id=$id&setmode=attachments\n");
	   } else {
	      $errs[] = "System error: Attachment $userfile_name could not be uploaded for ticket $id. ".$zen->db_error;
	   }
	}
     }
     if( $errs )
       add_system_messages( $errs, 'Error' );     
  }

  include("$libDir/nav.php");

  if( $actionComplete == 1 ) {
     $id = $ticketID;
     $ticket = $zen->get_ticket($id);     
  }
  extract($ticket);
  if( strtolower($zen->types["$typeID"]) == "project" ) {
     include("$templateDir/projectView.php");
  } else {
     include("$templateDir/ticketView.php");     
  }

  include("$libDir/footer.php");

}?>
