<?
  
if( is_array($logs) ) {
 
   $link = $zen->settings["url_view_ticket"];   
   $c = count($logs);
      ?>
        <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>'>
        <tr><td class='titleCell' colspan="8" align='center'><?=($c>1)? "$c Matches" : "1 Match";?></td></tr>
	<tr bgcolor="<?=$zen->settings["color_title_background"]?>">
	<td width="32" height="25" valign="middle" title="Tracking ID for the ticket">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("ID")?></span></b></span></div>
	</td>
        <td width="32" height="25" valign="middle" title="Date Logged">
          <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
	    <b><span class="small"><?=$zen->prn("Date")?></span></b></span>
          </div>
        </td>
	<? if( !$search_params["action"] || is_array($search_params["action"]) ) { ?>
	  <td width="32" height="25" valign="middle" title="Action Taken">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("Action")?></span></b></span></div>
	  </td>
        <? } ?>
	<? if( !$search_params["user_id"] || is_array($search_params["user_id"]) ) { ?>
	  <td width="32" height="25" valign="middle" title="Person ticket is assinged to">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("User")?></span></b></span></div>
	  </td>
        <? } ?>
	<? if( !$search_params["bin_id"] || is_array($search_params["bin_id"]) ) { ?>
	  <td width="32" height="25" valign="middle" title="Bin ticket is located in">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("Bin")?></span></b></span></div>
	  </td>
        <? } ?>
	</tr>
      <?      

   $td_ttl = "title='Click here to view this ticket.'";
   foreach($logs as $t) {
      unset($txt);
      unset($est);

      if( $row == $zen->settings["color_background"] ) {
	$row = $zen->settings["color_bars"];
	$txt = $hotrollover_greytext;
	$text = $zen->settings["color_bar_text"];	
      } else {
        $row = $zen->settings["color_background"];
	$txt = $hotrollover_text;
	$text = $zen->settings["color_text"];
      }
      ?>
	<tr style="background:<?=$row?>;color:<?=$text?>">
	<td height="25" valign="middle" <?=$td_ttl?> <?=$txt?>>
	 <a class="rowLink" style="color:<?=$text?>" 
            href="<?=$link?>?id=<?=$t["ticket_id"]?>&setmode=log"><?=$t["ticket_id"]?></a>
	</td>
	<td height="25" valign="middle" <?=$td_ttl?> <?=$txt?>>
	  <a class="rowLink" style="color:<?=$text?>" 
	     href="<?=$link?>?id=<?=$t["ticket_id"]?>&setmode=log"><?=$zen->showDate($t["date"])?></a>
	</td>
	<? if( !$search_params["action"] || is_array($search_params["action"]) ) { ?>
	<td height="25" valign="middle">
	  <?=$t["action"]?>
	</td>
	<? } ?>
	<? if( !$search_params["user_id"] || is_array($search_params["user_id"]) ) { ?>
	<td height="25" valign="middle">
	  <?=$zen->formatName($t["user_id"])?>
	</td>
	<? } ?>
	<? if( !$search_params["bin_id"] || is_array($search_params["bin_id"]) ) { ?>
	<td height="25"  valign="middle">
	  <?=$zen->bins["$t[bin_id]"]?>
	</td>
	<? } ?>
	</tr>	 	   
	<? if( trim($t["entry"]) ) { ?>
	<tr style="background:<?=$row?>;color:<?=$text?>">
	  <td height="25" colspan="8" <?=$td_ttl?> <?=$txt?>>
	   <a class="rowLink" href='<?=$link?>?id=<?=$t["ticket_id"]?>&setmode=log'>
	   <?
	     $t["entry"] = htmlentities($t["entry"]);
	     $parts = explode("\n",$t["entry"]);
	     if( $search_text ) {
	       unset($pt);
	       for($i=0; $i<count($parts); $i++) {
		 $p = $parts[$i];
		 if( eregi($search_text, stripslashes($p)) ) {
		   $pt .= ($pt)? "<br>\n" : ""; 
		   $pt .= $zen->highlight(stripslashes($p),$search_text);
		 }
	       }
	     } else {
	       $pt = substr($t["entry"],0,100);
	     }
	     print $pt;	     
	   ?>
           </a>
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
	<input type="hidden" name="search_fields[entry]" value="<?=strip_tags($search_fields["entry"])?>">
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
