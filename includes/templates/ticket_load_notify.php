<? if( !ZT_DEFINED ) { die("Illegal Access"); } 

  $on = $zen->actionApplicable($ticket['id'],'notify',$login_id);
  $drop = $on && $zen->checkAccess($login_id,$ticket['bin_id'],'notify_drop');
  $add = $on && $zen->checkAccess($login_id,$ticket["bin_id"],"notify_add");
  $colspan = $drop? 5 : 4;
  $hotkeys->loadSection('tab_notify');
  $GLOBALS['zt_hotkeys'] = $hotkeys;

?>

  <table width="600" cellpadding="0" cellspacing="1" class='formtable'>
  <tr>  
  <td class='subTitle indent' colspan='<?=$colspan?>'>
  <?=tr("Notify Recipients")?>
  </td>
  </tr>  
  <?
  $notify_list = $zen->get_notify_list($id);
  if( is_array($notify_list) ) {
    for($i=0; $i<count($notify_list); $i++) {
      $n = $notify_list[$i];
      if( $n["user_id"] ) {
        $u = $zen->get_user($n["user_id"]);
        $notify_list[$i]["name"] = $zen->formatName($u);
        $notify_list[$i]["email"] = $u["email"];
      }
    }
    $notify_list = $hotkeys->activateList($notify_list, "name", "name", "checkMyRow(\"drops_{notify_id}\", false)");
    
    ?>
    <form name='dropNotifyForm' action="<?=$rootUrl?>/actions/dropFromNotify.php" method="post">
    <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
    <input type="hidden" name="setmode" value="<?=$zen->ffv($page_mode)?>">
    <tr>
    <td class='headerCell'><?=tr("Name")?></td>
    <td class='headerCell'><?=tr("Email")?></td>
    <? if($drop) {?> <td class='headerCell'><?=tr("Delete")?></td> <? } ?>
    </tr>
    <?  
    foreach($notify_list as $n) {
      print "<tr class='bars'";
      print $row_rollover_eff;
      //print " onmouseover='if(window.document.body && mClassX){mClassX(this, \"altBars\", \"hand\");}' ";
      //print " onmouseout='if(window.document.body && mClassX){mClassX(this);}'";
      print " onclick='checkMyRow(\"drops_{$n['notify_id']}\", event)' title='{$n['hotkey_tooltip']}'>\n";
      print "\t<td>{$n['hotkey_label']}</td>\n";
      print "\t<td>".eLink($n['email'])."</td>\n";
      if( $drop ) {
        print "\t<td><input id='drops_{$n['notify_id']}' type='checkbox' "
        ."name='drops[]' value='{$n['notify_id']}'></td>\n";
      }
      print "</tr>\n";
    }
    ?>
    <tr> 
    <td class='subTitle' colspan='<?=$colspan?>'>
    <? if( $drop ) { ?>
    <div style='float:right'>
    <? renderDivButtonFind('Drop Recipients'); ?>
    </div>
    <? } ?>
    </form>
    <? if( $add ) { ?>
      <div style='float:left'>
      <form name='notifyAddForm' action="<?=$rootUrl?>/actions/addToNotify.php">
      <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
      <input type="hidden" name="setmode" value="<?=$zen->ffv($page_mode)?>">
      <? renderDivButtonFind('Add Recipients'); ?>
      </form>
      </div>
    <? } ?>
    </td>
    </tr>
    <?
  }
  else {
    print "<tr><td class='bars bold'>".tr("No recipients on notify list")."</td></tr>";
    if( $add ) { 
    ?>
      <tr><td class='subTitle'>
      <form name='notifyAddForm' action="<?=$rootUrl?>/actions/addToNotify.php">
      <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
      <input type="hidden" name="setmode" value="<?=$zen->ffv($page_mode)?>">
      <? renderDivButtonFind('Add Recipients'); ?>
      </form>
      </td></tr>
    <? }
  }
  ?>
  </table>
