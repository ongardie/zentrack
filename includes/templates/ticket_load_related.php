<? if( !ZT_DEFINED ) { die("Illegal Access"); }

include_once("$libDir/sorting.php");

$tickets = false;
  $view = 'related_list';
  if( $page_type == "ticket" ) {
    $ticket = $zen->get_ticket($id);
  } else {
    $ticket = $zen->get_project($id);
  }
  if( $ticket["relations"] ) {
     $tids = explode(",", $ticket["relations"]);
     $tickets = $zen->get_tickets( array("id"=>$tids), $sortstring );
  }
  if( is_array($tickets) && count($tickets) ) {
     include("$templateDir/listTickets.php");
  } else {
     print tr("No related ?", tr($page_type."s"));
  }
?>