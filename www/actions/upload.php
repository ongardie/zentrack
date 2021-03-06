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
    if( is_array($_FILES) && is_array($_FILES["userfile"]) ) {
      $userfile_name = $_FILES["userfile"]["name"];
      $userfile_type = $_FILES["userfile"]["type"];
      $userfile = $_FILES["userfile"]["tmp_name"];
      $userfile_size = $_FILES["userfile"]["size"];
      $userfile_error = $_FILES["userfile"]["error"];
    }
    
    // determine what the incoming data is, and format it
    // for use
    $ticket_id = $id;
    $input = array(
      "ticket_id"      => "int",
      "userfile_name"  => "text",
      "userfile_type"  => "text"
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
    
    // Check if description is too long
    if ( strlen($comments) > 100 ){
    	$errs[] = tr("Attachment description can not exceed 100 characters, yours is ? characters long.", strlen($comments));
    }
    // print out an appropriate error message
    // thanks to Jeremy G. for this correction
    if( $userfile_error ) {
      switch ($userfile_error){
        case 1:
        $errs[] = tr("The uploaded file exceeds the upload_max_filesize directive in php.ini.");
        break;
        case 2:
        $errs[] = tr("The uploaded file exceeds the MAX_FILE_SIZE allowed");
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
    
    if( !$errs ) {
      if( !$zen->checkAttachmentExt($userfile_name) ) {
        $possibles = $zen->getSetting('attachment_types_allowed');
        if( $possibles ) {
          $errs[] = tr("Invalid file type, the allowed types are: ?", $possibles);
        }
        else {
          $errs[] = tr("There are no attachment types allowed by your administrator");
        }
      }
    }
    
    // if there aren't any errors, get the file and input to the system
    if( !$errs ) {
      // perform the file transfer to move it to the directory where we 
      // want to keep it
      $file_name = $zen->getAttachmentName($ticket_id);
      $file_type = ereg_replace(".*[.]", "", $userfile_name);
      if( preg_match("/\b$file_type\b/i",$zen->getSetting("attachment_text_types")) ) {
        $userfile_type = "text/plain";
      }
      $max_size = $zen->getSetting("attachment_max_size");	
      if( !is_uploaded_file($userfile) ) {
        $errs[] = tr("The file was not recieved. Check to insure it's size does not exceed ?KB", array(substr($max_size,0,strlen($max_size)-3)));
      } else if( $userfile_size > $max_size ) {
        $errs[] = tr("The file size (?) exceeded the maximum allowed (?)", array(number_format($userfile_size), number_format($max_size)));
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
          $msg[] = tr("Attachment ? uploaded",$zen->ffv($userfile_name));
          $action = '';
          include("../ticket.php");
          exit;
        } else {
          $errs[] = tr("System error: Attachment ? could not be uploaded for ticket ?. ", array($zen->ffv($userfile_name), $id)).$zen->db_error;
        }
      }
    }
  }
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( strtolower($zen->types["$type_id"]) == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  
  include("$libDir/footer.php");
  
}?>