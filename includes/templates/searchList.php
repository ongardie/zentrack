<?  
if( is_array($tickets) && count($tickets) ) {
 
   $link = $zen->settings["url_view_ticket"];   
   $c = count($tickets);
   $TODO = "SEARCH";
   
?>
<table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>'>
<tr><td class='titleCell' colspan="9" align='center'><?=($c>1)? tr("? Matches",array($c)) : tr("1 Match");?></td></tr>
<tr bgcolor="<?=$zen->settings["color_title_background"]?>" >
<?

//#####################################################
//Id asc desc box begin
//#####################################################

?> 
<td<?=$nav_rollover_text?> width="32" height="25" valign="middle" title="<?=tr("ID of the ticket")?>">
<?
if ($orderby == "id asc") {
	$image = "/asc_order.gif";
	$i = "id desc";
} elseif($orderby == "id desc") {
	$image = "/desc_order.gif";
	$i = "id asc";
} else {
	$image = "";
	$i = "id asc";
}
?>
<A class='menuLink' HREF="<?=$zen->create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params)?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("ID")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</A>
</td>
<?

//#####################################################
//title asc desc box begin
//#####################################################

?>   
<td<?=$nav_rollover_text?> height="25" valign="middle" title="<?=tr("The name of the ticket")?>">
<?
   if ($orderby == "title asc") {
	   $i = "title desc";
	   $image = "/asc_order.gif";
   } elseif($orderby == "title desc") {
	   $i = "title asc";
	   $image = "/desc_order.gif";
   } else {
	  $image = "";
	  $i = "title asc";
   }
?>
<A class='menuLink' HREF="<?=$zen->create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params)?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Title")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</A>
</td>
<?

//#####################################################
//priority asc desc box begin
//#####################################################

if( !$search_params["priority"] || is_array($search_params["priority"]) ) { ?>
<td<?=$nav_rollover_text?> width="32" height="25" valign="middle" title="<?=tr("The importance of the ticket")?>">
<?
   if ($orderby == "priority asc") {
	   $i = "priority desc";
	   $image = "/desc_order.gif";
   } elseif($orderby == "priority desc") {
	   $i = "priority asc";
	   $image = "/asc_order.gif";
   } else {
	  $image = "";
	  $i = "priority asc";
   }
?>
<A class='menuLink' HREF="<?=$zen->create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params)?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Pri")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</A>
</td>
<? } 

//#####################################################
//status asc desc box begin
//#####################################################

if( !$search_params["status"] || is_array($search_params["status"]) ) { ?>
<td<?=$nav_rollover_text?> width="50" height="25" valign="middle" title="<?=tr("Current status of the ticket")?>">
<?
   if ($orderby == "status asc") {
	   $i = "status desc";
	   $image = "/desc_order.gif";
   } elseif($orderby == "status desc") {
	   $i = "status asc";
	   $image = "/asc_order.gif";
   } else {
	  $image = "";
	  $i = "status desc";
   }
?>
<A class='menuLink' HREF="<?=$zen->create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params)?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Status")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</A>
</td>
<? } 

//#####################################################
//user_id asc desc box begin
//#####################################################

if( !$search_params["user_id"] || is_array($search_params["user_id"]) ) { ?>
<td<?=$nav_rollover_text?> width="50" height="25" valign="middle" title="<?=tr("Person ticket is assigned to")?>">
<?
   if ($orderby == "user_id asc") {
	   $i = "user_id desc";
	   $image = "/asc_order.gif";
   } elseif($orderby == "user_id desc") {
	   $i = "user_id asc";
	   $image = "/desc_order.gif";
   } else {
	  $image = "";
	  $i = "user_id asc";
   }
?>
<A class='menuLink' HREF="<?=$zen->create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params)?>">     
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Owner")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</A>
</td>
<? }

//#####################################################
//type_id asc desc box begin
//#####################################################

if( !$search_params["type_id"] || is_array($search_params["type_id"]) ) { ?>
<td<?=$nav_rollover_text?> width="32" height="25" valign="middle" title="<?=tr("Type of ticket")?>">
<?
   if ($orderby == "type_id asc") {
	   $i = "type_id desc";
	   $image = "/asc_order.gif";
   } elseif($orderby == "type_id desc") {
	   $i = "type_id asc";
	   $image = "/desc_order.gif";
   } else {
	  $image = "";
	  $i = "type_id asc";
   }
?>
<A class='menuLink' HREF="<?=$zen->create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params)?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Type")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</A>
</td>
<?}

//#####################################################
//system_id asc desc box begin
//#####################################################

if( !$search_params["system_id"] || is_array($search_params["system_id"]) ) { ?>
<td<?=$nav_rollover_text?> width="50" height="25" valign="middle" title="<?=tr("System involved in ticket")?>">
<?
   if ($orderby == "system_id asc") {
	   $i = "system_id desc";
	   $image = "/asc_order.gif";
   } elseif($orderby == "system_id desc") {
	   $i = "system_id asc";
	   $image = "/desc_order.gif";
   } else {
	  $image = "";
	  $i = "system_id asc";
   }
?>
<A class='menuLink' HREF="<?=$zen->create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params)?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("System")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</A>
</td>
<?}
 
//#####################################################
//bin_id asc desc box begin
//#####################################################

if( !$search_params["bin_id"] || is_array($search_params["bin_id"]) ) { ?>
<td<?=$nav_rollover_text?> width="50" height="25" valign="middle" title="<?=tr("Bin ticket is located in")?>">
<?
   if ($orderby == "bin_id asc") {
	   $i = "bin_id desc";
	   $image = "/asc_order.gif";
   } elseif($orderby == "bin_id desc") {
	   $i = "bin_id asc";
	   $image = "/desc_order.gif";
   } else {
	  $image = "";
	  $i = "bin_id asc";
   }
?>
<A class='menuLink' HREF="<?=$zen->create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params)?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Bin")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</A>
</td>
<?}
 
//#####################################################
//start_date asc desc box begin
//#####################################################
     
?>
<td<?=$nav_rollover_text?> width="32" height="25" valign="middle" title="<?=tr("Date of ticket")?>">
<?
   if ($orderby == "start_date asc") {
	   $i = "start_date desc";
	   $image = "/asc_order.gif";
   } elseif($orderby == "start_date desc") {
	   $i = "start_date asc";
	   $image = "/desc_order.gif";
   } else {
	  $image = "";
	  $i = "start_date asc";
   }
?>
<A class='menuLink' HREF="<?=$zen->create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params)?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Date")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</A>
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
      
      if( $t["status"] == 'CLOSED' ) {
        $classxText = "class='bars' onclick='ticketClk(\"{$link}?id={$t['id']}\")' $rollover_greytext";
      }
      else if( $zen->settings["priority_medium"] ) {
        $classxText = "class='priority{$t['priority']}' "
         ."onclick='ticketClk(\"{$link}?id={$t['id']}\")' "
         ."onMouseOver='mClassX(this, \"priority{$t['priority']}Over\", true)' "
         ."onMouseOut='mClassX(this, \"priority{$t['priority']}\", false)'";
      }
      else {
        $classxText = "class='cell' onclick='ticketClk(\"{$link}?id={$t['id']}\")' $rollover_text";
      }
      
      if( $search_text && $search_fields["title"] ) {
          $t["title"] = $zen->highlight($t["title"],$search_text);
      }
      
      ?>

   <tr <?=$classxText?>>
      <td height="25" valign="middle" <?=$td_ttl?>>
        <a class="rowLink" href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["id"]?></a>
      </td>
      
      <td height="25" valign="middle" <?=$td_ttl?>>
        <a class="rowLink" href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["title"]?></a>
      </td>
      
    <? if( !$search_params["priority"] || is_array($search_params["priority"]) ) { ?>
      <td height="25" <?=$tx?> valign="middle">
         <?=$zen->priorities["$t[priority]"]?>
      </td>
    <? } ?>
    <? if( !$search_params["status"] || is_array($search_params["status"]) ) { ?>
      <td height="25" valign="middle">
         <?=$t["status"]?>
      </td>
    <? } ?>
    <? if( !$search_params["user_id"] || is_array($search_params["user_id"]) ) { ?>
      <td height="25" valign="middle">
         <?=$zen->formatName($t["user_id"],2)?>
      </td>
    <? } ?>
    <? if( !$search_params["type_id"] || is_array($search_params["type_id"]) ) { ?>
       <td height="25" valign="middle">
         <?=$zen->types["$t[type_id]"]?>
       </td>
    <? } ?>
    <? if( !$search_params["system_id"] || is_array($search_params["system_id"]) ) { ?>
       <td height="25" valign="middle">
          <?=$zen->systems["$t[system_id]"]?>
       </td>
    <? } ?>
    <? if( !$search_params["bin_id"] || is_array($search_params["bin_id"]) ) { ?>
       <td height="25" valign="middle">
          <?=$zen->bins["$t[bin_id]"]?>
       </td>
    <? } 
    //#####################################################
    //date field 
    //#####################################################
    ?>
       <td height="25" valign="middle">
          <?=$zen->showDate($t[otime])?>
       </td>
   </tr>       
   
   <? if( $search_text && $search_fields["description"] && $t["description"] ) { ?>
   <tr style="background:<?=$row?>;color:<?=$text?>">
     <td height="25" colspan="9">   
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
   }  // End forech ticket loop
   ?>

   <tr>
     <form method="post" action="<?=$SCRIPT_NAME?>">
       <td colspan="9" class="titleCell">
          <input type="submit" class="smallSubmit" value="<?=tr("Modify Search")?>">
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
