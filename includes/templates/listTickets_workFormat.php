<?
  
if( is_array($tickets) ) {
 
   $link = $zen->settings["url_view_ticket"];   
      ?>
        <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>'>
	<tr bgcolor="<?=$zen->settings["color_title_background"]?>">
	<td width="32" height="25" valign="middle" title="Tracking ID for the ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("ID")?></span></b></span></div>
	</td>
	<td height="25" valign="middle" title="The name of the ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Title")?></span></b></span></div>
	</td>
	<td width="32" height="25" valign="middle" title="The importance of the ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Pri")?></span></b></span></div>
	</td>
	<td width="32" height="25" valign="middle" title="The type of task to complete">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Type")?></span></b></span></div>
	</td>
	<td width="40" height="25" valign="middle" title="Who the ticket belongs to">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Owner")?></span></b></span></div>
	</td>
        <td width="40" height="25" valign="middle" title="The estimated time to complete this ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Status")?></span></b></span></div>
        </td>     
        <td width="40" height="25" valign="middle" title="The estimated time to complete this ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Est Hrs")?></span></b></span></div>
        </td>
        <td width="40" height="25" valign="middle" title="The estimated time to complete this ticket">
  	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Worked")?></span></b></span></div>     
        </td>     
        <td width="40" height="25" valign="middle" title="Percent of Completion">
          <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("%")?></span></b></span></div>     
        </td>
	</tr>
      <?      

   $td_ttl = "title='Click here to view the ticket.'";
   $ttl_est = 0;
   $ttl_wkd = 0;
   $ttl_ext = "";
   $ttl_per = "";
   foreach($tickets as $t) {
      $row = $zen->settings["color_background"];
      unset($txt);
      unset($tx);
      unset($est);
      unset($wkd);
      unset($per);
      
      if( $t["priority"] <= $zen->settings["level_hot"] ) {
	 $tx = "style='background:".$zen->settings["color_highlight"]."'";
	 $txt = $hotrollover_text;
	 $text = $zen->settings["color_hot"];
      } else if( $t["priority"] <= $zen->settings["level_highlight"] ) {
	 $txt = $rollover_text;
	 $text = $zen->settings["color_hot"];	 
      } else {
	 $txt = $rollover_text;
	 $text = $zen->settings["color_text"];	 
      }
      
      if( $t["typeID"] == $zen->projectTypeID() ) {
	 list($est,$wkd) = $zen->getProjectHours($t["id"]);
	 $ttl_est += $est;
	 $ttl_wkd += ($wkd > $est)? $est : $wkd;
	 $ttl_ext += ($wkd > $est)? $wkd - $est : 0;
      } else {
	 if( $t["est_hours"] > 0 ) {
	    $est = $t["est_hours"];
	    $ttl_est += $est;
	 } else {
	    $est = "n/a";
	 }	 
	 if( $t["wkd_hours"] > 0 ) {
	    $wkd = $t["wkd_hours"];
	    $ttl_wkd += ($wkd > $est)? $est : $wkd;
	    $ttl_ext += ($wkd > $est)? $wkd - $est : 0;	    
	 }
      }
      if( $est > 0 )
	$per = round($zen->percentWorked($est,$wkd),1)."%";
      ?>
	<tr style="background:<?=$row?>;color:<?=$text?>">
	<td height="25" valign="middle" <?=$td_ttl?> <?=$txt?>>
	 <a class="rowLink" style="color:<?=$text?>" href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["id