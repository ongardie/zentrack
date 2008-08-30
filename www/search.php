<?
  /*
  **  SEARCH TICKETS
  **  
  **  Filter tickets by a list of parameters and return
  **  only those tickets matching the result set
  **
  */

  define('ZT_SECTION','tickets');
  include("header.php");
  
  $page_title = tr("Search Tickets");
  $page_section = $page_title;
  
  $inc = "$templateDir/searchForm.php";
  
  $tickets = false;
  if( $TODO == 'SEARCH' ) {
    include("$templateDir/searchResults.php");
    if( is_array($tickets) ) {
      if ( count($tickets) == 1 ) {
        $id = $tickets[0][id];
        $ticket = $zen->get_ticket($id);
        if( is_array($ticket) ) {
          $page_type = $zen->inProjectTypeIDs($ticket['type_id'])? 'project' : 'ticket';
          $view = "{$page_type}_view";
          include("$rootWWW/ticket.php");
          exit;
        }
      }
      $inc = "$templateDir/listTickets.php";
    } else if( !$errs ) { 
      $msg[] = tr("There were no results for your search."); 
    }
  }
  $view = strpos($inc, 'listTickets')>0? 'search_list' : 'search_form';
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include($inc);
  include("$libDir/footer.php");
?>
