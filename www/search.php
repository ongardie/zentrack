<?
  /*
  **  SEARCH TICKETS
  **  
  **  Filter tickets by a list of parameters and return
  **  only those tickets matching the result set
  **
  */
  
  include("header.php");


  $page_title = tr("Search Tickets");
  $page_section = $page_title;
  $expand_search = 1;
  include("$libDir/nav.php");

if( $TODO == 'SEARCH' ) {
    include("$templateDir/searchResults.php");
    if( is_array($tickets) ) {
       include("$templateDir/searchList.php");
       include("$libDir/paging.php"); //Addition for paging
    } else {
      if( $errs ) {
	 $zen->printErrors($errs);
       } else {
	 print "<p><b>" . tr("There were no results for your search.") . "</b></p>\n";
       }
       include("$templateDir/searchForm.php");
     }
  } else {
     include("$templateDir/searchForm.php");
  }

  include("$libDir/footer.php");
?>
