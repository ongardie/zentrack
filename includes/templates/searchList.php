<?
  
if( is_array($tickets) && count($tickets) ) {
 
   $link = $zen->settings["url_view_ticket"];   
   $c = count($tickets);
      ?>
        <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>'>
        <tr><td class='titleCell' colspan="8" align='center'><?=($c>1)? "$c Matches" : "1 Match";?></td></tr>
	<tr bgcolor="<?=$zen->settings["color_title_background"]?>">
	<td width="32" height="25" valign="middle" title="Tracking ID for the ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("ID")?></span></b></span></div>
	</td>
	<td height="25" valign="middle" title="The name of the ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
	     <b><span class="small"><?=$zen->prn("Title")?></span></b></span></div>
	</td>
	<? if( !$search_params["priority"] || is_array($search_params["priority"]) ) { ?>
	<td width="32" height="25" valign="middle" title="The importance of the ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Pri")?></span></b></span></div>
	</td>
       <? } ?>
	<? if( !$search_params["status"] || is_array($search_params["status"]) ) { ?>
	  <td width="32" height="25" valign="middle" title="Current status of the ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("Status")?></span></b></span></div>
	  </td>
        <? } ?>
	<? if( !$search_params["userID"] || is_array($search_params["userID"]) ) { ?>
	  <td width="32" height="25" valign="middle" title="Person ticket is assinged to">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("Owner")?></span></b></span></div>
	  </td>
        <? } ?>
	<? if( !$search_params["typeID"] || is_array($search_params["typeID"]) ) { ?>
	  <td width="32" height="25" valign="middle" title="Type of ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("Type")?></span></b></span></div>
	  </td>
        <? } ?>
	<? if( !$search_params["systemID"] || is_array($search_params["systemID"]) ) { ?>
	  <td width="32" height="25" valign="middle" title="System involved in ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("System")?></span></b></span></div>
	  </td>
        <? } ?>
	<? if( !$search_params["binID"] || is_array($search_params["binID"]) ) { ?>
	  <td width="32" height="25" valign="middle" title="Bin ticket is located in">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("Bin")?></span></b></span></div>
	  </td>
        <? } ?>
	</tr>
      <?      

   $td_ttl = "title='Click here to view the ticket.'";
   foreach($tickets as $t) {
      unset($txt);
      unset($tx);
      unset($est);

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

      if( $search_text && $search_fields["title"] ) {
	$t["title"] = $zen->highlight($t["title"],$search_text);
      }
      
      ?>

	<tr style="background:<?=$row?>;color:<?=$text?>">
	<td height="25" valign="middle" <?=$td_ttl?> <?=$txt?>>
	 <a class="rowLink" style="color:<?=$text?>" href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["id"]?></a>
	</td>
	<td height="25" valign="middle" <?=$txt?> <?=$td_ttl?>>
	 <a class="rowLink" style="color:<?=$text?>" href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["title"]?></a>
	</td>
	<? if( !$search_params["priority"] || is_array($search_params["priority"]) ) { ?>
	<td height="25" <?=$tx?> valign="middle">
	  <?=$zen->priorities["$t[priority]"]?>
	</td>
	<? } ?>
	<? if( !$search_params["status"] || is_array($search_params["status"]) ) { ?>
	<td height="25" <?=$tx?> valign="middle">
	  <?=$t["status"]?>
	</td>
	<? } ?>
	<? if( !$search_params["userID"] || is_array($search_params["userID"]) ) { ?>
	<td height="25" <?=$tx?> valign="middle">
	  <?=$zen->formatName($t["userID"],2)?>
	</td>
	<? } ?>
	<? if( !$search_params["typeID"] || is_array($search_params["typeID"]) ) { ?>
	<td height="25" <?=$tx?> valign="middle">
	  <?=$zen->types["$t[typeID]"]?>
	</td>
	<? } ?>
	<? if( !$search_params["systemID"] || is_array($search_params["systemID"]) ) { ?>
	<td height="25" <?=$tx?> valign="middle">
	  <?=$zen->systems["$t[systemID]"]?>
	</td>
	<? } ?>
	<? if( !$search_params["binID"] || is_array($search_params["binID"]) ) { ?>
	<td height="25" <?=$tx?> valign="middle">
	  <?=$zen->bins["$t[binID]"]?>
	</td>
	<? } ?>
	</tr>	 	   
	<? if( $search_text && $search_fields["description"] && $t["description"] ) { ?>
	<tr style="background:<?=$row?>;color:<?=$text?>">
	  <td height="25" <?=$tx?> colspan="8">	
	   <?
	     $t["description"] = ereg_replace("<br />", "<br>", $t["description"]);
	     $parts = explode("<br>", $t["description"]);
	     unset($pt);
	     for($i=0; $i<count($parts); $i++) {
	       $p = $parts[$i];
	       if( eregi($search_text, stripslashes($p)) ) {
		 $pt .= ($pt)? "<br>\n" : ""; 
		 $pt .= $zen->highlight(stripslashes($p),$search_text);
	       }
             }
	     print $pt;
	   ?>
          </td>
        </tr>
	<? 
	   } 
   
   }
   ?>
    <tr>
     <form method="post" action="<?=$SCRIPT_NAME?>">
     <td colspan="8" class="titleCell">
	<input type="submit" class="smallSubmit" value="Modify Search">
	<input type="hidden" name="search_text" value="<?=strip_tags($search_text)?>">
	<input type="hidden" name="search_fields[title]" value="<?=strip_tags($search_fields["title"])?>">
	<input type="hidden" name="search_fields[description]" value="<?=strip_tags($search_fields["description"])?>">
        <?
	  foreach($search_params as $k=>$v) {
	    print "<input type='hidden' name='search_params[$k]' value='".strip_tags($v)."'>\n";
          }
        ?>
     </td>
     </form>
    </tr>
    </table>
   <?   
}
?>