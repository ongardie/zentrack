<?
  /*
  **  
  **  
  **  Contacts list
  **
  */
  
  
  include("header.php");

  // security measure
  if( $zen->user['access_level'] < $zen->settings['level_contacts'] ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }

  $page_title = tr("Agreement list");
  $page_section =  tr("Agreement list");
  $expand_agreement = 1;
  include("$libDir/nav.php");


include("$templateDir/agreementView.php");


  include("$libDir/footer.php");
?>
