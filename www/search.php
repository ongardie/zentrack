<?
  /*
  **  SEARCH TICKETS
  **  
  **  Filter tickets by a list of parameters and return
  **  only those tickets matching the result set
  **
  */
  
  include("header.php");


  $page_title = "Search Tickets";
  $page_section = $page_title;
  $expand_search = 1;
  include("$libDir/nav.php");

  if( $TODO == 'SEARCH' ) {
     include("$templateDir/searchResults.php");
     if( is_array($tickets) ) {
	include("$templateDir/searchList.php");
     } else {
       if( $errs ) {
	 $zen->printErrors($errs);
       } else {
	 print "<p><b>There were no results for your search.</b></p>\n";
       }
       include("$templateDir/searchForm.php");
     }
  } else {
     include("$templateDir/searchForm.php");
  }

  include("$libDir/footer.php");
?>
