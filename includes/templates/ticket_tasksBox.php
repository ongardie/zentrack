<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <table width="600" align="center" cellpadding="2" cellspacing="2">
  <tr> 
     <td align="right">
     <form action="<?=$rootUrl?>/newTicket.php">
     <input type="hidden" name="project_id" value="<?=$zen->checkNum($id)?>">
       <?
         if( $zen->checkAccess($login_id,$ticket["bin_id"],"create") ) {
	    $button = "submit";
	    $color = $zen->settings["color_highlight"];
	 } else {
	    $button = "button";
	    $color = $zen->settings["color_alt_background"];
	 }
       ?>
       <input type="<?=$button?>" value=" <?=$zen->ttl("Add ticket to project")?> " class="actionButton" style="width:125;color:<?=$color?>">  
     </form>
     </td>
   </tr>  
  <tr> 
     <td align="right">
     <form action="<?=$rootUrl?>/newProject.php">
     <input type="hidden" name="project_id" value="<?=$zen->checkNum($id)?>">
       <?
         if( $zen->checkAccess($login_id,$ticket["bin_id"],"create") ) {
	    $button = "submit";
	    $color = $zen->settings["color_highlight"];
	 } else {
	    $button = "button";
	    $color = $zen->settings["color_alt_background"];
	 }
       ?>
       <input type="<?=$button?>" value=" <?=tr("Create Sub-Project")?> " class="actionButton" style="width:125;color:<?=$color?>">  
     </form>
     </td>
   </tr>    
   <tr>  
     <td class='titleCell'>
       <?=tr("Tasks for this project")?>
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
     print tr("No tickets have been added to this Project.");
  }
?>
     </td>
   </tr>
   </table>




