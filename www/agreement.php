<?
  /*
  **  contact DISPLAY PAGE
  **  
  **  Displays a contact to the screen
  **
  */
  
  // include the header file
  if( file_exists("header.php") ) {
    include_once("header.php");
  }
  else if( file_exists("../header.php") ) {
    include_once("../header.php");
  }

  // security measure
  if( $login_level < $zen->settings['level_contacts'] ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }

  /*
  **  GET TICKET INFORMATION
  */
  $page_title = tr("Agreement") . " #$id";

  /*
  **  GET PARAMS FOR A Contact
  */
  
  $agree = $zen->get_contact($id,"ZENTRACK_AGREEMENT","agree_id");

  
  $page_section = "Agreement $id";
  $expand_agreement = 1;
  
  /*
  ** PRINT OUT THE PAGE
  */ 
  include_once("$libDir/nav.php");

    if( is_array($agree) ) {
      extract($agree);
       
	    include("$templateDir/agreement_box.php"); 
			
    } else {
      print "<p class='error'>" . tr("That contact doesn't exist") . "</p>\n";
    }
    
    
   

  include("$libDir/footer.php");
?>
