<table width="645" cellpadding="0" cellspacing="0" border="0">
<tr> 
  <td valign="bottom"><?

  /*
  **  TICKET BOX
  **
  **  Includes the correct html to display
  **  whatever is currently going on with the
  **  ticket.
  **
  **  sets up the tabs at the top as well
  **  $login_mode is set up in the headerInc.php file
  **  in accordance with incoming form data and 
  **  is a session variable
  */
      
  /*
  ** SHOW THE NAVIGATION TABS
  */

  // the navigation tabs are set in headerInc.php
  
  print "<table cellpadding='0' cellspacing='0'><tr>\n";
  print "<td width='3'><img src='$rootUrl/images/empty.gif' width='3' height='1'></td>\n";

  $i = 1;
 
  foreach( $tabs as $t ) {
     if( $login_mode == strtolower($t) ) {
	$class = 'tabOn';
	$lclass = "tabsOn";
     } else {
	$class = 'tabOff';
	$lclass = 'tabsOff';
     }
     $link = ($t == 'System')? $SCRIPT_NAME : $ticketUrl;
     print "<td class='$class' height='$height_num' width='55'>";
     print "<a href='$link?id=$id&setmode=$t' class='$lclass'>$t</a></td>\n";
     if( $i < count($tabs) ) {
	print "<td width='3'><img src='$rootUrl/images/empty.gif' width='3' height='1'></td>\n";
     }
     $i++;
  }

  print "</tr></table>\n";

?></td>
</tr>
<tr> 
  <td class="ticketCell" height="300" valign="top">
  <br>  
<?

  /*
  ** DETERMINE WHICH SCREEN TO SHOW AND SHOW IT
  */
  
  $name = "ticket_".$login_mode."Box.php";
  $name = ereg_replace("[.]{2}", "", $name);
  include("$templateDir/$name");
?>
   <br>
  </td>
</tr>
</table>
