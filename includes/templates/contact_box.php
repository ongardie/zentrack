<table width="645" cellpadding="0" cellspacing="0" border="0">
<tr> 
<td valign="bottom">
<?
  /*
  ** SHOW THE NAVIGATION TABS
  */
  
  // set the page mode, for viewing tickets
  if( $setmode ) {    
    $page_mode = strtolower($setmode); 
 	} else {
	  $page_mode = "abc";	
 	}


  
  print "<table cellpadding='0' cellspacing='0'><tr>\n";
  print "<td width='3'><img src='$rootUrl/images/empty.gif' width='3' height='1'></td>\n";
  
   $tabs = array(
      "abc",
      "def",
      "ghi",     
      "jkl",
			"mno",
			"pqrs",
			"tuv",
 			"wxyz",
			"!19" 
      );
  
      $i = 1;   
  foreach( $tabs as $t ) {
    $lt = strtolower($t);
    if( $page_mode == $lt ) {
      $class = 'tabOn';
      $lclass = "tabsOn";
    } else {
      $class = 'tabOff';
      $lclass = 'tabsOff';
    }
    
    print "<td class='$class' height='16' width='60' align='center'>";
    print "<a href='$rootUrl/contacts.php?setmode=$t&overview=$overview&ie=$ie' class='$lclass'>$t</a></td>\n";
    if( $i < count($tabs) ) {
      print "<td width='3'><img src='$rootUrl/images/empty.gif' width='3' height='1'></td>\n";
    }
     $i++;
  }
print "<td width='3'><img src='$rootUrl/images/empty.gif' width='3' height='1'></td>\n";
?>
</tr></table>
</td>
</tr>
<tr> 
  <td class="ticketCell" height="300" valign="top">
  <br>  
<?

  /*
  ** DETERMINE WHICH SCREEN TO SHOW AND SHOW IT
  */
  $name = "contact_".$page_mode."Box.php";
  $name = ereg_replace("[.]{2}", "", $name);
  // check for valid filename
  if( !file_exists("$templateDir/$name") ) {
    $name = "ticket_systemBox.php";
    $this->addDebug("contact_box","Invalid filename $name declared... redirecting",1);
  }
  include("$templateDir/$name");
?>
   <br>
  </td>
</tr>
</table>
