<?

  /**
   PREREQUISITES:
     (ZenFieldMap)$map - contains properties for fields
     (string)$view - the current view (probably project_list or ticket_list)
     (array)$fields - properties for fields to be rendered, obtained from ZenFieldMap::getFieldMap( view )
     (string)$page_type - (optional) either 'ticket' or 'project'
     (array)$tickets - list of tickets to be displayed, as retrieved from zenTrack::get_tickets()
  **/
  
if( !$page_type )
  $page_type = "ticket";
  
if( is_array($tickets) && count($tickets) ) {
?>
<script type='text/javascript'>
function resortListPage( fieldName ) {
<? if( strpos($view, 'search')===0 ) { ?>
  document.searchModifyForm.sortBy.value = fieldName;
  document.searchModifyForm.TODO.value = 'SEARCH';
  document.searchModifyForm.submit();
  return false;
<? } else { ?>
  s = window.location.href;
  s += s.indexOf('?') > 0? '&sortBy='+fieldName : '?sortBy=fieldName';
  window.location = s;
<? } ?>
}
</script>
<table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>'>
   <tr bgcolor="<?=$zen->settings["color_title_background"]?>">
<?
  // print some table headings
  $custom_field_list = array(); //store these for later
  foreach($fields as $f=>$field) {
    // skip hidden fields
    if( !$field['is_visible'] ) { continue; }

    $tf = tr($map->getLabel($view,$f));
    print "<td width='32' height='25' valign='middle' title='".$zen->ffv($tf)."' class='titleCell'><span class='small'>$tf</span></td>\n";
    
    // store information about field types
    if( strpos($f, 'custom_') === 0 && $field['is_visible'] ) {
      $custom_field_list[] = $f;
    }
  }
  
  // close the row
  print "</tr>\n";

  // we will now cache a list of users, if needed, to prevent multiple database
  // lookups from being performed
  $user_ids = array();
  $has_user_ids = array_key_exists('user_id', $fields) && $fields['user_id']['is_visible'];
  $has_creator_ids = array_key_exists('creator_id', $fields) && $fields['creator_id']['is_visible'];
  $ticket_ids = array();
  $custom_fields = array();
  if( $has_user_ids or $has_creator_ids || count($custom_field_list) ) {
    foreach($tickets as $t) {
      if( count($custom_field_list) ) { $ticket_ids[] = $t['id']; }
      if( $has_user_ids && $t['user_id'] ) { $user_ids[] = $t['user_id']; }
      if( $has_creator_ids && $t['creator_id'] ) { $user_ids[] = $t['creator_id']; }
    }
    
    // now query for the user ids and map them to keys which we will store
    // for use while rendering all of the rows
    if( count($user_ids) ) {
      $query = "SELECT user_id, initials FROM ".$zen->table_users." WHERE user_id in (".join(',', array_unique($user_ids)).")";
      $vals = $zen->db_query($query);
      if( $vals && count($vals) ) {
        $user_ids = array();
        foreach($vals as $v) {
          $user_ids["{$v[0]}"] = $v[1];
        }
      }
      else {
        // default to no entries
        $user_ids = array();
      }
    }
    
    // now query for variable field content as needed
    if( count($custom_field_list) && count($ticket_ids) ) {
      $custom_fields = $zen->getVarfieldsForTickets($ticket_ids, $custom_field_list);
    }
  }

   $td_ttl = "title='".tr("Click here to view the ?", array($page_type))."'";
   foreach($tickets as $t) {
      $row = $zen->settings["color_background"];
      
      // create special url for projects
      if( $zen->inProjectTypeIDs($t["type_id"]) ) {
         $link = $projectUrl;
      } else {
         $link = $ticketUrl;   
      }
      
      // determine the color of the row based on priority or status
      if( $t["status"] == 'CLOSED' ) {
        $classxText = "class='bars' onclick='ticketClk(\"{$link}?id={$t['id']}\"); return false;' $rollover_greytext";
      }
      else if( $zen->settings["priority_medium"] ) {
        $classxText = "class='priority{$t['priority']}' "
         ."onclick='ticketClk(\"{$link}?id={$t['id']}\"); return false;' "
         ."onMouseOver='mClassX(this, \"priority{$t['priority']}Over\", true)' "
         ."onMouseOut='mClassX(this, \"priority{$t['priority']}\", false)'";
      }
      else {
        $classxText = "class='cell' onclick='ticketClk(\"{$link}?id={$t['id']}\"); return false;' $rollover_text";
      }
      
      // render the row properties
      print "<tr $classxText>\n";
      
      // render each field in the row
      foreach($fields as $f=>$field) {
        // skip hidden fields
        if( !$field['is_visible'] ) { continue; }
        $align = $f == 'elapsed'? 'align="right"' : '';
        print "<td height='25' valign='middle' $align $td_ttl>";
        print "<a class='rowLink' href='$link?id={$t['id']}'>";
        if( $f == 'user_id' || $f == 'creator_id' ) {
          $uid = $t["$f"];
          $name = $zen->ffv($user_ids["$uid"], $field['num_cols']);
          print $name? $name : '&nbsp;';
        }
        else if( $f == 'elapsed' ) {
          print $zen->showTimeElapsed($t["otime"],$t["ctime"],1,1);
        }
        else {
          $value = strpos($f, 'custom_')===0? $custom_fields[$f] : $t[$f];
          print $map->getTextValue($view, $f, $value);
        }
        print "</a></td>\n";
      }
      
      // close the row
      print "</tr>";
   }
   
   if( strpos($view, 'search')===0 ) {
?>
   <tr>
       <td colspan="<?= 9+$vfcount ?>" class="titleCell">
       <nobr>
       <form method="post" action="search.php" name='searchModifyForm' style="display: inline; margin: 0px;">
          <input type="submit" class="smallSubmit" value="<?=tr("Modify Search")?>">
          <input type='hidden' name='TODO' value=''>
          <input type='hidden' name='sort_field' value=''>
          <input type="hidden" name="search_text" value="<?=$zen->ffv($search_text)?>">
          <?
           foreach($search_params as $k=>$v) {
             print "<input type='hidden' name='search_params[$k]' value='".$zen->ffv($v)."'>\n";
           }
           foreach($search_dates as $k=>$v) {
             print "<input type='hidden' name='search_dates[$k]' value='".$zen->ffv($v)."'>\n";
           }
           foreach($search_fields as $k=>$v) {
             print "<input type='hidden' name='search_fields[$k]' value='".$zen->ffv($v)."'>\n";
           }
           ?>
     </form>
     <form method="post" action="exportSearch.php" style="display: inline; margin: 0px;">
          <input type="submit" class="smallSubmit" value="<?=tr("Export Results")?>">
          <input type="hidden" name="search_text" value="<?=$zen->ffv($search_text)?>">
          <?
           foreach($search_params as $k=>$v) {
             print "<input type='hidden' name='search_params[$k]' value='".$zen->ffv($v)."'>\n";
           }
           foreach($search_dates as $k=>$v) {
             print "<input type='hidden' name='search_dates[$k]' value='".$zen->ffv($v)."'>\n";
           }
           foreach($search_fields as $k=>$v) {
             print "<input type='hidden' name='search_fields[$k]' value='".$zen->ffv($v)."'>\n";
           }
         ?>
        </nobr>
       </form>
     </td>
   </tr>
<?
   }
   
   print "</table>\n";
   
} else {
  if( $login_bin && $login_bin != -1 ) {
    $viewbin = $login_bin? $zen->bins["$login_bin"] : "any bin";
    print "<p>&nbsp;</p><ul><b>".tr('No open ?s in ?', array( tr($page_type), $zen->bins["$login_bin"])).".</b></ul>";
  } else {
    print "<p>&nbsp;</p><ul><b>".tr("No ?s were found", tr($page_type) ).".</b></ul>";
  }
}
  
?>
