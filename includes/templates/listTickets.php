<?

if( !$page_type )
  $page_type = "ticket";
  
if( is_array($tickets) ) {
      ?>
        <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>'>
   <tr bgcolor="<?=$zen->settings["color_title_background"]?>">
   <td width="32" height="25" valign="middle" title="Tracking ID for the <?=$page_type?>">
   <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("ID")?></span></b></span></div>
   </td>
   <td height="25" valign="middle" title="The name of the <?=$page_type?>">
   <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Title")?></span></b></span></div>
   </td>
   <td width="32" height="25" valign="middle" title="The importance of the <?=$page_type?>">
   <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Pri")?></span></b></span></div>
   </td>
   <td width="32" height="25" valign="middle" title="The type of task to complete">
   <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Type")?></span></b></span></div>
   </td>
   <td width="60" height="25" valign="middle" title="When the <?=$page_type?> was created">
   <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Opened")?></span></b></span></div>
   </td>
   <td width="40" height="25" valign="middle" title="Who the <?=$page_type?> belongs to">
   <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Owner")?></span></b></span></div>
   </td>
   <td width="60" height="25" valign="middle" title="The location of the <?=$page_type?>">
   <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Bin")?></span></b></span></div>
   </td>
   <td width="80" height="25" valign="middle" title="The length of time the <?=$page_type?> has been open">
   <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Time")?></span></b></span></div>
   </td>
   </tr>
      <?      

   $td_ttl = "title='Click here to view the $page_type.'";
   foreach($tickets as $t) {
      $row = $zen->settings["color_background"];
      if( $zen->inProjectTypeIDs($t["type_id"]) ) {
         $link = $projectUrl;
      } else {
         $link = $ticketUrl;   
      }
      
   if( $zen->settings["priority_medium"] ) {

      $classxText = "class='priority{$t['priority']}' "
      ."onclick=\"mClk(this);\" "
      ."onMouseOver='mClassX(this, \"priority{$t['priority']}Over\", true)' "
      ."onMouseOut='mClassX(this, \"priority{$t['priority']}\", false)'";

   }
   else {
      $classxText = "class='cell' $rollover_text";
   }
      ?>
   <tr <?=$classxText?>>
   <td height="25" valign="middle" <?=$td_ttl?>>
    <a class="rowLink" href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["id"]?></a>
   </td>
   <td height="25" valign="middle" <?=$td_ttl?>>
    <a class="rowLink" href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["title"]?></a>
   </td>
   <td height="25" valign="middle">
   <?=$zen->priorities["$t[priority]"]?>
   </td>
   <td height="25" valign="middle">
   <?=$zen->types["$t[type_id]"]?>
   </td>
   <td height="25" valign="middle">
   <?=($t["otime"])? $zen->showDate($t["otime"]) : "n/a";?>
   </td>
   <td width="40" height="25" valign="middle">
   <? 
     $user = $zen->get_user($t["user_id"]);
          if( $user ) {
        print ($t["user_id"] == $login_id)? 
          "<b>".$user["initials"]."</b>" :
          $user["initials"];
     } else {
        print "n/a";
     }
        ?>
   </td>
   <td height="25" valign="middle">
   <?=$zen->bins["$t[bin_id]"]?>
   </td>
   <td height="25" valign="middle" align="right">
   <?=$zen->showTimeElapsed($t["otime"],$t["ctime"],1,1)?>
   </td>
   </tr>       
   <?
   }      
     
   print "</table>\n";
   
} else {
   if( $login_bin && $login_bin != -1 )
     print "<p>&nbsp;</p><ul><b>No open {$page_type}s in ".$zen->bins["$login_bin"]."</b></ul>";
   else
     print "<p>&nbsp;</p><ul><b>No {$page_type}s were found.</b></ul>";
}
  
?>
