<?  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Projects")?></td>
</tr>
<?=ztGetNavigatorRow("", "/assignedProjects.php", tr('My Projects'));?>
<?=ztGetNavigatorRow($hotkeys->tt('New Project'), "/newProject.php", $hotkeys->ll("New Project"));?>
<?=ztGetNavigatorRow($hotkeys->tt('Advanced Search'), "/search.php", $hotkeys->ll("Advanced Search", "Search"));?>
<?=ztGetNavigatorRow("", "/searchLogs.php", tr("Search Logs"));?>
<!--
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>>
    <a href='<?=$rootUrl?>/assignedProjects.php' class='leftNavLink'><?=tr('My Projects')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("New Project")?>'>
    <a href='<?=$rootUrl?>/newProject.php' class='leftNavLink'><?=$hotkeys->ll("New Project")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title="<?=$hotkeys->tt("Advanced Search")?>">
    <a href='<?=$rootUrl?>/search.php' class='leftNavLink'><?=$hotkeys->ll("Advanced Search", "Search")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>>
    <a href='<?=$rootUrl?>/searchLogs.php' class='leftNavLink'><?=tr('Search Logs')?></a>
  </td>
</tr>
-->
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
    <div class='recentHistory' id='projectHistoryDiv' onMouseOver='setupHistoryDiv(this)'>
      <div><?=tr("Recent Projects")?></div>
    <?
      $history =& $zen->getHistoryManager();
      $list = $history->getList('project');
      if( count($list) ) {
        $otag="";
        $ctag="";
        foreach($list as $k=>$v) {
// If you want (or don't want) the current ticket in the Recent Tickets section to be bold,
// uncomment (or comment) the following modification:
          if ( !empty($id) && $id==$k ) {
            $otag="<b>";
            $ctag="</b>";
          } else {
            $otag="";
            $ctag="";
          }
// End of "current ticket in bold" section to un/comment.

          print "<br><a href='$rootUrl/project.php?id=$k' title='".$zen->ffv($v)."'>$otag".$k.tr("-").substr($zen->ffv($v),0,12).$ctag."</a>\n";
        }
      }
      else {
        print "-none-";
      }
    ?></div>
  </td>
</tr>
