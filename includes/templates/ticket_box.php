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
  ** CHECK THE PAGE MODE
  */

  if( !$project_mode ) {
    $project_mode = "tasks";
  }
  if( !$ticket_mode ) {
    $ticket_mode = "details";
  }

  // set the page mode, for viewing tickets
  if( $setmode ) {    
    if( $page_type == "project" )
      $project_mode = strtolower($setmode);
    else
      $ticket_mode = strtolower($setmode);
  }
  if( $page_type == "project" ) {
    $page_mode = $project_mode;
    $pageUrl = $projectUrl;
  } else {
    $page_mode = $ticket_mode;
    $pageUrl = $ticketUrl;
  }

  /*
  ** SHOW THE NAVIGATION TABS
  */

  // the navigation tabs are set in headerInc.php
  
  print "<table cellpadding='0' cellspacing='0'><tr>\n";
  print "<td width='3'><img src='$rootUrl/images/empty.gif' width='3' height='1'></td>\n";

  $i = 1;

  $counts = $zen->get_ticket_stats($id);
  foreach( $tabs as $t ) {
    $lt = strtolower($t);
    if( $page_mode == $lt ) {
      $class = 'tabOn';
      $lclass = "tabsOn";
    } else {
      $class = 'tabOff';
      $lclass = 'tabsOff';
    }
    $txt = (isset($counts[$lt]) && $counts[$lt])?
      "$t (".$counts["$lt"].")" : $t;
    $link = ($t == 'System')? $SCRIPT_NAME : $pageUrl;
    $w = ($lt == "attachments")? 85 : 60;
    print "<td class='$class' height='$height_num' width='$w'>";
    print "<a href='$link?id=$id&setmode=$t' class='$lclass'>$txt</a></td>\n";
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
  $name = "ticket_".$page_mode."Box.php";
  $name = ereg_replace("[.]{2}", "", $name);
  // check for valid filename
  if( !file_exists("$templateDir/$name") ) {
    $name = "ticket_systemBox.php";
    $this->addDebug("ticket_box","Invalid filename $name declared... redirecting",1);
  }
  include("$templateDir/$name");
?>
   <br>
  </td>
</tr>
</table>
