  <form name="ticket_customForm" action="<?=$rootUrl?>/actions/editCustomSubmit.php">

  <table width="600" align="center" cellpadding="2" cellspacing="2">
<?
  $cfd=$zen->getCustomFields(0,$page_type,"C");
  foreach($cfd as $f) {
    $k=$f['field_name'];    
    $v = $varfields["$k"];
?>
  <tr>
     <td class='bars'><?=tr($f['field_label'])?></td>
     <td class='bars'>
     <?= genVarfield('ticket_customForm', $f, $v) ?>
     </td>
  </tr>
<?     
  }
?>
    <tr>
         <input type="hidden" name="id" value="<?=strip_tags($id)?>">
         <td align="right">
   <?
    $button = "submit";
    $color = $zen->settings["color_highlight"];
   ?>
   <input type="<?=$button?>" value=" <?=uptr("Save")?> " class="actionButton" style="width:125;color:<?=$color?>">
         </td>
     </tr>
   </table>
   </form>
