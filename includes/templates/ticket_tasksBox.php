
  <table width="600" align="center" cellpadding="2" cellspacing="2">
  <tr> 
     <form action="<?=$rootUrl?>/newTicket.php">
     <input type="hidden" name="projectID" value="<?=strip_tags($id)?>">
     <td align="right">
       <?
         if( $zen->checkAccess($login_id,$ticket["binID"],"create") ) {
	    $button = "submit";
	    $color = $zen->settings["color_highlight"];
	 } else {
	    $button = "button";
	    $color = $zen->settings["color_alt_background"];
	 }
       ?>
       <input type="<?=$button?>" value=" Add Ticket to Project " class="actionButton" style="width:125;color:<?=$color?>">  
     </td>
     </form>
   </tr>  
  <tr> 
     <form action="<?=$rootUrl?>/newProject.php">
     <input type="hidden" name="projectID" value="<?=strip_tags($id)?>">
     <td align="right">
       <?
         if( $zen->checkAccess($login_id,$ticket["binID"],"create") ) {
	    $button = "submit";
	    $color = $zen->settings["color_highlight"];
	 } else {
	    $button = "button";
	    $color = $zen->settings["color_alt_background"];
	 }
       ?>
       <input type="<?=$button?>" value=" Create Sub-Project " class="actionButton" style="width:125;color:<?=$color?>">  
     </td>
     </form>
   </tr>    
   <tr>  
     <td class='titleCell'>
       Tasks for this Project    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
  if( is_array($children) && count($children) > 0) {
     $tickets = $children;
     unset($children);
     include("$templateDir/listTickets_workFormat.php");
  } else {
     print "No tickets have been added to this Project.";
  }
?>
     </td>
   </tr>
   </table>




