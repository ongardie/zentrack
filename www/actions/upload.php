<?{
   
  /*
  **  UPLOAD ATTACHMENT
  **  
  **  Create an attachment for the ticket
  **
  */

  $action = "upload";  
  include("action_header.php");

  if( $actionComplete == 1 ) {
    // here we are converting this page to make it work
    // with php's EVER changing way of doing things... so
    // we will try to keep everything from breaking while they continue
    // to alter how everything works... while still maintaining some backwards
    // compatability
    if( is_array($HTTP_POST_FILES) && is_array($HTTP_POST_FILES["userfile"]) ) {
      $userfile_name = $HTTP_POST_FILES["userfile"]["name"];
      $userfile_type = $HTTP_POST_FILES["userfile"]["type"];
      $userfile = $HTTP_POST_FILES["userfile"]["tmp_name"];
      $userfile_size = $HTTP_POST_FILES["userfile"]["size"];
      $userfile_error = $HTTP_POST_FILES["userfile"]["error"];
    }
     
     // determine what the incoming data is, and format it
     // for use
     $ticket_id = $id;
     $input = array(
		    "ticket_id"       => "int",
		    "userfile_name"  => "text"
		    );
     if( $log_id ) {
	$input["log_id"] = "int";
     }
     else {
       $log_id = 0;
     }
     $required = array_keys($input);
     $input["comments"] = "html";
     $zen->cleanInput($input);
     foreach($required as $r) {
	if( !$$r ) {
	   $errs[] = tr(" ? is required", array($r));
	}
     }
     // print out an appropriate error message
     // thanks to Jeremy G. for this correction
     if( $userfile_error ) {
       switch ($userfile_error){
       case 1:
	 $errs[] = tr("The uploaded file exceeds the upload_max_filesize directive in php.ini.");
	 break;
       case 2:
	 $errs[] = tr("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form.");
	 break;
       case 3:
	 $errs[] = tr("The uploaded file was only partially uploaded.");
	 break;
       case 4:
	 $errs[] = tr("No file was uploaded.");
	 break;
       case 5:
	 $errs[] = tr("Uploaded file size 0 bytes");
	 break;
       }
     } 
     // if there aren't any errors, get the file and input to the system
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
	$file_name = $ticket_id."_$randval";
	while( file_exists( $zen->attachmentsDir."/$file_name" ) ) {
	   $file_name = $ticket_id."_$randval";	   
	}
	$file_type = ereg_replace(".*[.]", "", $userfile_name);
	if( preg_match("/\b$file_type\b/i",$zen->settings["attachment_text_types"]) ) {
	   $userfile_type = "text/plain";
	}
        $max_size = $zen->settings["attachment_max_size"];	
	if( !is_uploaded_file($userfile) ) {
	  $errs[] = tr("The file was not recieved. Check to insure it's size does not exceed ?KB", array(substr($max_size,0,strlen($max_size)-3)));
	} else if( $userfile_size > $max_size ) {
	   $errs[] = tr("The file size (?) exceeded the maximum allowed (?)", array(number_format($userfile_size), number_format($max_size)));
	} else if( $zen->settings["attachment_types_allowed"] 
		   && !preg_match("/\b$file_type\b/i", $zen->settings["attachment_types_allowed"]) ) {
	   $errs[] = tr("'?' is not an allowed file extension - See your systems administrator for more information", array($file_type));
	} else if( !$userfile_type ) {
	   $errs[] = tr("That is not a recognized file type, by your browsers determinations");	   
	} else if( !move_uploaded_file($userfile, $zen->attachmentsDir."/$file_name") ) {
	   $errs[] = tr("The file could not be uploaded ");
	}
	
	if( !$errs ) {
	  @chmod($zen->attachmentsDir."/$file_name",0666);
	  $params = array(
			  "name"     => $userfile_name,
			  "filename" => $file_name,
			  "filetype" => $userfile_type
			  );
	  if( $comments )
	    $params["description"] = $comments;
	  $res = $zen->attach_to_ticket( $ticket_id, $login_id, $params, $log_id);
	  if( $res ) {
	    add_system_messages("Attachment $userfile_name uploaded for ticket $id");
	    $setmode = "attachments";
	    include("../ticket.php");
	    exit;
	  } else {
	    $errs[] = tr("System error: Attachment ? could not be uploaded for ticket ?. ", array($userfile_name, $id))
	      .$zen->db_error;
	  }
	}
     }
     if( $errs )
       add_system_messages( $errs, 'Error' );     
  }
  
  include("$libDir/nav.php");
  
  if( $actionComplete == 1 ) {
    $id = $ticket_id;
     $ticket = $zen->get_ticket($id);     
  }
  extract($ticket);
  if( strtolower($zen->types["$type_id"]) == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  
  include("$libDir/footer.php");
  
}?>