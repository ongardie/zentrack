
  <table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell'>
       Tasks for this Project    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
  if( is_array($children) ) {
     $tickets = $children;
     unset($children);
     include("$templateDir/listTickets_workFormat.php");
  } else {
     print "No tickets have been added to this Project.".$zen->getProjectChildren($id);
  }
?>
     </td>
   </tr>
   </table>

