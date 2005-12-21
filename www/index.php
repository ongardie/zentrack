<?
  /*
  **  INDEX PAGE
  **  
  **  Provides login screen, and lists tickets for the logged in user by default
  **
  */  
  
  include_once(dirname(__FILE__)."/header.php");
  
  $page_title = tr("Welcome to zenTrack");
  $page_section = tr("Tickets");
  include_once("$libDir/nav.php");
  
  $view = 'ticket_list';
  
  $userBins = $zen->getUsersBins($login_id);
  if( is_array($userBins) && count($userBins) ) {
    include("$templateDir/listTickets.php");
  } else {
    print "<p class='hot'>" . tr("You do not have access to any bins") . "</p>\n";
  }

  include("$libDir/footer.php");
?>