
  <table width="600" align="center" cellpadding="2" cellspacing="2">
  <tr> 
     <td align="right">
     <form action="<?=$rootUrl?>/actions/addToNotify.php">
     <input type="hidden" name="ticket_id" value="<?=$zen->checkNum($id)?>">
       <?
         if( $zen->checkAccess($login_id,$ticket["bin_id"],"notify_set") ) {
	    $button = "submit";
	    $color = $zen->settings["color_highlight"];
	 } else {
	    $button = "button";
	    $color = $zen->settings["color_alt_background"];
	 }
       ?>
       <input type="<?=$button?>" value=" Add Recipient " class="actionButton" style="width:125;color:<?=$color?>">  
     </form>
     </td>
   </tr>
   <tr>  
     <td class='titleCell'>
       Notify List
     </td>
   </tr>  
   <tr>
     <td valign="top">
     <form action="<?=$rootUrl?>/actions/dropFromNotify.php">
     <input type="hidden" name="ticket_id" value="<?=$zen->checkNum($id)?>">
<?
  $notify_list = $this->get_notify_list($id);
  if( is_array($notify_list) ) {
?>
    <table width='500'>
     <tr>
       <td class='subTitle' align='center'>Name</td>
       <td class='subTitle' align='center'>Email</td>
       <td class='subTitle' align='center'>Delete</td>
     </tr>
<?  
    foreach($notify_list as $n) {
      $row = ($row == "bars") "altBars" : "bars";
      if( $n["user_id"] ) {
	$u = $zen->get_user($n["user_id"]);
	$name = $zen->formatName($u);
	$email = $u["email"];
      }
      else {
	$email = $n["email"];
	$name = ($n["name"])? $n["name"] : "&nbsp;";
      }
      print "<tr>\n";      
      print "\t<td class='$row'>$name</td>\n";
      print "\t<td class='$row'>$email</td>\n";
      print "\t<td class='$row'><input type='checkbox' "
           ."name='drops[]' value='{$n['notify_id']}'></td>\n";
      print "</tr>\n";
    }
?>
    </table>
     </td>
   </tr>
   <tr> 
     <td align="right">
       <?
         if( $zen->checkAccess($login_id,$ticket["bin_id"],"notify_set") ) {
	    $button = "submit";
	    $color = $zen->settings["color_highlight"];
	 } else {
	    $button = "button";
	    $color = $zen->settings["color_alt_background"];
	 }
       ?>
       <input type="<?=$button?>" value=" Drop Recipients " class="actionButton" style="width:125;color:<?=$color?>">  
<?
   }
   else {
    print "<b>No recipients on notify list</b>";
   }
?>
     </form>
     </td>
   </tr>
   </table>

