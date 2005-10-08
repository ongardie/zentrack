<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <table width="600" cellpadding="2" cellspacing="2">
  <tr>  
  <td class='subTitle'>
  <?=tr("Notify List")?>
  </td>
  </tr>  
  <tr>
  <td valign="top">
  <form action="<?=$rootUrl?>/actions/dropFromNotify.php" method="post">
  <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
  <?
  $notify_list = $zen->get_notify_list($id);
  if( is_array($notify_list) ) {
    ?>
    <table width='100%'>
    <tr>
    <td class='subTitle' align='center'><?=tr("Name")?></td>
    <td class='subTitle' align='center'><?=tr("Email")?></td>
    <td class='subTitle' align='center'><?=tr("Delete")?></td>
    </tr>
    <?  
    foreach($notify_list as $n) {
      if( $n["user_id"] ) {
        $u = $zen->get_user($n["user_id"]);
        $name = $zen->formatName($u);
        $email = $u["email"];
      }
      else {
        $email = $n["email"];
        $name = ($n["name"])? $n["name"] : "&nbsp;";
      }
      print "<tr class='cell'";
      print " onmouseover='mClassX(this, \"bars\", \"hand\")' onmouseout='mClassX(this)'";
      print " onclick='checkMyBox(\"drops_{$n['notify_id']}\", event)'>\n";
      print "\t<td>$name</td>\n";
      print "\t<td>$email</td>\n";
      print "\t<td><input id='drops_{$n['notify_id']}' type='checkbox' "
      ."name='drops[]' value='{$n['notify_id']}'></td>\n";
      print "</tr>\n";
    }
    ?>
    </table>
    </td>
    </tr>
    <tr> 
    <td align="right">
    <?
    if( $zen->checkAccess($login_id,$ticket["bin_id"],"notify_set") ) {
    ?><input type="submit" value="<?=tr("Drop Recipients")?>" class="actionButton"><?
    }
    
  }
  else {
    print "<b>".tr("No recipients on notify list")."</b>";
  }
  ?>
  </form>
  </td>
  </tr>
    <?
    if( $zen->checkAccess($login_id,$ticket["bin_id"],"notify") ) {
    ?>
     <tr><td align='right'>
      <form action="<?=$rootUrl?>/actions/addToNotify.php">
      <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
      <input type="submit" value="<?=tr("Add Recipient")?>" class="actionButton">  
      </form>
     </td></tr>
    <? } ?>
  </table>