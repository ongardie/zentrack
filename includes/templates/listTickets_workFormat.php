<?
  
if( is_array($tickets) ) {
 
      ?>
        <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>'>
	<tr bgcolor="<?=$zen->settings["color_title_background"]?>">
	<td width="32" height="25" valign="middle" title="Tracking ID for the <?=$page_type?>">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("ID")?></span></b></span></div>
	</td>
	<td height="25" valign="middle" title="The name of the <?=$page_type?>">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Title")?></span></b></span></div>
	</td>
	<td width="32" height="25" valign="middle" title="The importance of the <?=$page_type?>">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Pri")?></span></b></span></div>
	</td>
	<td width="32" height="25" valign="middle" title="The type of task to complete">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Type")?></span></b></span></div>
	</td>
	<td width="40" height="25" valign="middle" title="Who the <?=$page_type?> belongs to">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Owner")?></span></b></span></div>
	</td>
        <td width="40" height="25" valign="middle" title="The estimated time to complete this <?=$page_type?>">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Status")?></span></b></span></div>
        </td>     
        <td width="40" height="25" valign="middle" title="The estimated time to complete this <?=$page_type?>">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Est Hrs")?></span></b></span></div>
        </td>
        <td width="40" height="25" valign="middle" title="The estimated time to complete this <?=$page_type?>">
  	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Worked")?></span></b></span></div>     
        </td>     
        <td width="40" height="25" valign="middle" title="Percent of Completion">
          <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("%")?></span></b></span></div>     
        </td>
	</tr>
      <?      

   $td_ttl = "title='Click here to view the $page_type.'";
   $ttl_est = 0;
   $ttl_wkd = 0;
   $ttl_ext = "";
   $ttl_per = "";
   foreach($tickets as $t) {
      unset($txt);
      unset($tx);
      unset($est);
      unset($wkd);
      unset($per);
      
      if( $t["status"] == 'CLOSED' ) {
	$row = $zen->settings["color_bars"];
	$txt = $rollover_greytext;
	$text = $zen->settings["color_bar_text"];
      } else if( $t["priority"] <= $zen->settings["level_hot"] ) {
	$row = $zen->settings["color_background"];      
	$tx = "style='background:".$zen->settings["color_highlight"]."'";
	$txt = $hotrollover_text;
	$text = $zen->settings["color_hot"];
      } else if( $t["priority"] <= $zen->settings["level_highlight"] ) {
	$row = $zen->settings["color_background"];
	$txt = $rollover_text;
	$text = $zen->settings["color_hot"];	 
      } else {
	$row = $zen->settings["color_background"];
	$txt = $rollover_text;
	$text = $zen->settings["color_text"];	 
      }     
      
      // calculate the total hours
      // and format the ticket's hours
      list($est,$wkd) = $zen->getTicketHours($t["id"]);
      $ttl_est += $est;
      $ttl_wkd += ($wkd > $est)? $est : $wkd;
      $ttl_ext += ($wkd > $est)? $wkd - $est : 0;
      if( !strlen($est) )
	$est = "n/a";
      if( $wkd <= 0 )
	$wkd = 0;
      if( $zen->inProjectTypeIDs($t["type_id"]) ) {	
	$link = $projectUrl;
      } else {
	$link = $ticketUrl;
      }
      if( $est > 0 )
	$per = round($zen->percentWorked($est,$wkd),1)."%";
      ?>
	<tr style="background:<?=$row?>;color:<?=$text?>">
	<td height="25" valign="middle" <?=$td_ttl?> <?=$txt?>>
	 <a class="rowLink" style="color:<?=$text?>" href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["id"]?></a>
	</td>
	<td height="25" valign="middle" <?=$txt?> <?=$td_ttl?>>
	 <a class="rowLink" style="color:<?=$text?>" href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["title"]?></a>
	</td>
	<td height="25" <?=$tx?> valign="middle">
	  <?=$zen->priorities["$t[priority]"]?>
	</td>
	<td height="25" valign="middle">
	  <?=$zen->types["$t[type_id]"]?>
	</td>
	<td width="40" height="25" valign="middle">
	  <?=$zen->formatName($t["user_id"],2)?>
	</td>
	<td width="40" height="25" valign="middle">
	  <?=$t["status"]?>
	</td>
	<td width="40" height="25" valign="middle" align="right">
	  <?=$est?>
	</td>
	<td width="40" height="25" valign="middle" align="right">
	  <?=$wkd?>
	</td>
	<td width="40" height="25" valign="middle" align="right">
   	  <?=($per)? $per : "n/a"; ?>
	</td>
	</tr>	 	   
	<?
   }      
   if( $ttl_est ) {
      $ttl_per = $zen->percentWorked($ttl_est,$ttl_wkd);
   } else {
      $ttl_per = "n/a";
   }
   
   
   // extra hours summary
   if( $ttl_ext ) {
      $p = $zen->percentWorked( $ttl_per, $ttl_wkd+$ttl_ext );
      $pp = $ttl_per - $p;
      $p = round($p,1);
      $pp = round($pp,1);
      $ttl_per = round($ttl_per,1);
      print "<tr style='background:".$zen->settings["color_bars"].";color:".$zen->settings["color_bar_text"].";'>\n";
      print "<td colspan='6' align='right'><b>Actual Hours:</b>&nbsp;&nbsp;</td>\n";
      print "<td align='right'><b>$ttl_est</b></td>\n";
      print "<td align='right'><b>".($ttl_ext+$ttl_wkd)."</b></td>\n";
      print "<td align='right'><b>$p%</b></td>\n";
      print "</tr>\n";            
      print "<tr style='background:".$zen->settings["color_bars"].";color:".$zen->settings["color_bar_text"].";'>\n";
      print "<td colspan='6' align='right'><b>Hours over 100%:</b>&nbsp;&nbsp;</td>\n";
      print "<td align='right'><b>&nbsp;</b></td>\n";
      print "<td align='right'><b>&#150; $ttl_ext</b></td>\n";
      print "<td align='right'><b>$pp%</b></td>\n";
      print "</tr>\n";      
   }
   
   // totals summary
   print "<tr style='background:".$zen->settings["color_title_background"].";color:".$zen->settings["color_title_text"].";'>\n";
   print "<td colspan='6' align='right'><b>Totals:</b>&nbsp;&nbsp;</td>\n";
   print "<td align='center'><b>$ttl_est</b></td>\n";
   print "<td align='center'><b>$ttl_wkd</b></td>\n";
   print "<td align='center'><b>$ttl_per%</b></td>\n";
   print "</tr>\n";
   
   print "</table>\n";
   
} else {
   if( $login_bin )
     print "<p>&nbsp;</p><ul><b>No open {$page_type}s in ".$zen->bins["$login_bin"]."</b></ul>";
   else
     print "<p>&nbsp;</p><ul><b>No {$page_type}s were found.</b></ul>";
}
  
?>
