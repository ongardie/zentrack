<?
  /*
  **  Action: edit ticket
  */
  include_once("../header.php");
  $page_title = tr("Contact #?", $id);
  $expand_contact = 1;
  
  
  include("$libDir/nav.php");

  include("$templateDir/editContactForm.php");

  include("$libDir/footer.php");
?>
