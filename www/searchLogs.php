<?
  /*
  **  SEARCH LOGS
  **  
  **  Filter logs by a list of parameters and return
  **  only those logs matching the result set
  **
  */
  
  include("header.php");


  $page_title = "Search Logs";
  $page_section = $page_title;
  $expand_search = 1;
  include("$libDir/nav.php");

  if( $TODO == 'SEARCH' ) {
     include("$templateDir/searchLogResults.php");
     if( is_array($logs) ) {
	include("$templateDir/searchLogList.php");
     } else {
       if( $errs ) {
	 $zen->printErrors($errs);
       } else {
	 print "<p><b>There were no logs matching your search.</b></p>\n";
       }
       include("$templateDir/searchLogForm.php");
     }
  } else {
     include("$templateDir/searchLogForm.php");
  }

  include("$libDir/footer.php");
?>
