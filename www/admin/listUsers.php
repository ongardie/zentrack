<?
  /*
  **  LIST USERS FOR ADMINISTRATION
  **  
  **  Creates a list of users for editing
  **
  */
  
  
  include("./admin_header.php");
  $page_tile = "Search for Users";
  include("$libDir/nav.php");

  if( !$TODO ) {
    include("$templateDir/userSearchForm.php");
  } else {
    include("$templateDir/userSearchResults.php");
    if( is_array($users) ) {
      include("$templateDir/userSearchList.php");
    } else {
      print "<br><b>There were no results for your search</b>\n";
      include("$templateDir/userSearchForm.php");
    }
  }

  include("$libDir/footer.php");

?>
