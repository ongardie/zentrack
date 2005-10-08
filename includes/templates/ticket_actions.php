<?  if( !ZT_DEFINED ) { die("Illegal Access"); } ?><table><tr><?

$iconDir = "$imageDir/48x48";
$actions = $zen->getActions();
foreach($actions as $k=>$v) {
  if( !$v['button'] ) { continue; }
  
  //actionApplicable( $id, $action, $user_id = '', $noaccess = 0 )
  $use = $zen->actionApplicable($ticket, $k, $login_id);
  
  if( $use ) { 
    print "<td class='icon' onmouseover='mClassX(this, \"icon iconDown\", true)'";
    print " onmouseout='mClassX(this, \"icon\")' onclick='mClk(this)'>";
    print "<a class='leftNavLink' href='$rootUrl/actions/$k.php?id=$id'>";
    if( $v['img'] ) {
      print "<img src='$imageUrl/24x24/{$v['img']}' border='0' width='24' height='24'>";
    }
    print "<br>{$v['label']}";
    print "</a>";
    print "</td>";
  }
  else {
    print "<td class='icon iconOff'>";
    if( $v['img'] ) {
      print "<img src='$imageUrl/24x24/{$v['img']}' border='0' width='24' height='24'>";
    }
    print "<br>{$v['label']}";
    print "</td>";
  }

}

?></tr></table>