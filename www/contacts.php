<?
  /*
  **  
  **  
  **  Contacts list
  **
  */
  
  include("header.php");

  // security measure
  if( $login_level < $zen->settings['level_contacts'] ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }

  switch ($overview) {
    case "company":
        $tabel = "ZENTRACK_COMPANY"; 
        $title = "title";
          $page_section = tr("Contact list - Company");
        $ie = NULL;
        break;
    case "extern":
        $tabel = "ZENTRACK_EMPLOYEE"; 
        $title = "lname"; 
          $page_section = tr("Contact list - Persons Extern");
        break;
    case "intern":
        $tabel = "ZENTRACK_EMPLOYEE";
        $title = "lname";  
          $page_section = tr("Contact list - Persons Intern");
        break;
    default:
        $tabel = "ZENTRACK_COMPANY"; 
        $title = "title";
        $overview = "company";
        $ie = NULL;
          $page_section = tr("Contact list - Company");
	  }
	   

  $expand_contacts = 1;
  include("$libDir/nav.php");
		
  include("$templateDir/contactView.php");

  include("$libDir/footer.php");
?>
