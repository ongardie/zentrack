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

  $vx = $zen->getCustomFields(1, $page_type, 'Custom');
  $counts = $zen->get_ticket_stats($id);
  foreach( $tabs as $key=>$t ) {
    if( $key == 'custom' && (!$vx || !count($vx)) ) {
      // only display the custom tab if there are fields on it
      continue;
    }
    if( $key == 'contacts' && 
	($zen->settings['allow_contacts'] != 'on' ||
	 !$zen->checkAccess($login_id, $bin_id, 'level_contacts')) ) {
      // do not show contacts if this is off
      continue;
    }
    if( $page_mode == $key ) {
      $class = 'tabOn';
      $lclass = "tabsOn";
    } else {
      $class = 'tabOff';
      $lclass = 'tabsOff';
    }
    
    // Possible translations: (for the benefit of translation maintenance tools)
    // tr("Related"); tr("Notify"); tr("Tasks");
    $txt = (isset($counts[$key]) && $counts[$key])?
      $t." (".$counts["$key"].")" : $t;
    $w = ($key == "attachments")? 85 : 60;
    print "<td class='$class' height='$height_num' width='$w'>";
    print "<a href='$pageUrl?id=$id&setmode=$key' class='$lclass'>$txt</a></td>\n";
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
    if( !file_exists("$templateDir/actions/$page_mode.php") ) {
      $zen->addDebug("ticket_box","Invalid filename $name declared... redirecting",1);
    }
    $name = "ticket_systemBox.php";
  }
  include("$templateDir/$name");
?>
   <br>
  </td>
</tr>
</table>
