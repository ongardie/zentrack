
  <table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell'>
       Related Tickets    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
  $ticket = $zen->get_ticket($id);
  if( $ticket["relations"] ) {
     $tids = explode(",", $ticket["relations"]);
  }
  $tickets = $zen->get_tickets( array("id"=>$tids) );
  if( is_array($tickets) ) {
     include("$templateDir/listTickets.php");
  } else {
     print "No tickets have been associated with this ticket.";
  }
?>
     </td>
   </tr>
   </table>

