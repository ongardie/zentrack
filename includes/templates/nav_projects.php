<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Projects")?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$nav_rollover_text?> title='<?=$hotkeys->tt("Projects")?>'>
    <a href='<?=$rootUrl?>/projects.php' class='leftNavLink'><?=$hotkeys->ll("Projects","Browse")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$nav_rollover_text?> title='<?=$hotkeys->tt("New Project")?>'>
    <a href='<?=$rootUrl?>/newProject.php' class='leftNavLink'><?=$hotkeys->ll("New Project")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
    <div class='recentHistory'><?=tr("Recent Projects")?></div>
    <?
      $history =& $zen->getHistoryManager();
      $list = $history->getList('project');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<br><a href='$rootUrl/project.php?id=$k'>$k - ".substr($zen->ffv($v),0,10)."</a>\n";
        }
      }
      else {
        print "-none-";
      }
    ?>
  </td>
</tr>