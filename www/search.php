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

  print "This will be a search page to filter ticket results.";

  include("$libDir/footer.php");
?>
