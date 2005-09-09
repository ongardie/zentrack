<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <table width="600" align="center" cellpadding="2" cellspacing="2">
  <tr> 
  <td align="right">
  <form action="<?=$rootUrl?>/actions/addToNotify.php">
  <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
  <?
  if( $zen->checkAccess($login_id,$ticket["bin_id"],"notify") ) {
    $button = "submit";
    $color = $zen->getSetting("color_highlight");
  } else {
    $button = "button";
    $color = $zen->getSetting("color_alt_background");
  }
  ?>
  <input type="<?=$button?>"
  value=" <?=tr("Add Recipient")?> " class="actionButton" 
  style="width:125;color:<?=$color?>">  
  </form>
  </td>
  </tr>
  <tr>  
  <td class='titleCell'>
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
    <table width='500'>
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
	    $button = "submit";
	    $color = $zen->getSetting("color_highlight");
    } else {
	    $button = "button";
	    $color = $zen->getSetting("color_alt_background");
    }
    ?>
    <input type="<?=$button?>" 
	  value=" <?=tr("Drop Recipients")?> " 
	  class="actionButton" style="width:125;color:<?=$color?>">  
    <?
  }
  else {
    print "<b>".tr("No recipients on notify list")."</b>";
  }
  ?>
  </form>
  </td>
  </tr>
  </table>
  
