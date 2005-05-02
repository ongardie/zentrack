<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell'>
       <?=tr("Related ?s", array($page_type))?>    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
  $tickets = false;
  if( $page_type == "ticket" ) {
    $view='ticket_list';
    $ticket = $zen->get_ticket($id);
  } else {
    $view='project_list';
    $ticket = $zen->get_project($id);
  }
  if( $ticket["relations"] ) {
     $tids = explode(",", $ticket["relations"]);
     $tickets = $zen->get_tickets( array("id"=>$tids) );
  }
  $fields=$map->getFieldMap($view);
  if( is_array($tickets) && count($tickets) ) {
     include("$templateDir/listTickets.php");
  } else {
     print tr("No tickets have been associated with this ticket.");
  }
?>
     </td>
   </tr>
   </table>

