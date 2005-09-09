<? if( !ZT_DEFINED ) { die("Illegal Access"); }

 /**
  * A tab or block of information in the ticket view
  *
  * REQUIREMENTS:
  *   $map - instance of ZenFieldMap
  *   $zen - instance of ZenTrack
  *   $hotkeys - instance of ZenHotKeys
  *   $page_type - 'ticket' or 'project'
  *   $bin_id - bin we are viewing currently
  */
  function getTabCounts( $zen, $id, $loads ) {
    static $stats;
    if( !$loads || !count($loads) ) { return ''; }
    if( !$stats ) { $stats = $zen->get_ticket_stats($id); }
    $tf = false;
    $counts = array();
    foreach($loads as $l) {
      if( array_key_exists("$l", $stats) ) {
        $counts[] = $stats["$l"];
        if( $stats["$l"] > 0 ) { $tf = true; }
      }
    }
    if( $tf ) { return " (".join(',',$counts).")"; }
    return '';
  }

  $tabs = $map->getTabs($page_type, $login_id, $bin_id);
  print "<table cellpadding='0' cellspacing='0'><tr>";
  foreach($tabs as $k=>$v) {
    $loads = array();
    if( $v['preload'] ) { $loads = $v['preload']; }
    if( $v['postload'] ) { $loads = array_merge($loads, $v['postload']); }
    $class = $page_mode == $k? "class='tab on'" : "class='tab off' $nav_rollover_text";
    print "<td $class height='15' title='".$hotkeys->tt($v['label'])."'>";
    $class = $page_mode == $k? "tab on" : "tab off";
    print "<a href='$rootUrl/$page_type.php?id=$id&setmode=$k'>".$hotkeys->ll($v['label']);
    print getTabCounts($zen,$id,$loads)."</a></td>";
    print "<td width='3'><img src='$imageUrl/empty.gif' width='3' height='1'></td>\n";
  }
  print "</tr></table>";

?>