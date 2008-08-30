<? if( !ZT_DEFINED ) { die("Illegal Access"); }

$access = $zen->actionApplicable($id, "upload", $login_id);
$colspan = $access? 5 : 4;
if( $access ) {
  $hotkeys->loadSection('tab_attachments');
  ?>
  <form method='post' action='<?=$rootUrl?>/actions/dropAttachments.php' name='deleteAttachmentForm'>
  <input type="hidden" name="id" value="<?=$id?>">
  <input type='hidden' name='setmode' value="<?=$zen->ffv($page_mode)?>">
  <?
}
?>
  <table width="600" class='formtable' cellpadding="2" cellspacing="1">
   <tr>  
     <td class="subTitle indent" colspan='<?=$colspan?>'>
        <?=tr("Attachments")?>
     </td>
  </tr>
<?
  // get attachments and display a list
  // of them
  $attachments = $zen->get_attachments($id);
  if( is_array($attachments) && count($attachments) > 0) {
     ?>
       <tr>
         <td class='headerCell'><?=tr("Log ID")?></td>
         <td class='headerCell'><?=tr("Attachment")?></td>
         <td class='headerCell'><?=tr("Type")?></td>
         <td class='headerCell'><?=tr("Description")?></td>
         <? if( $access ) { ?>
         <td class='headerCell'><?=tr("Delete")?></td>
         <? } ?>
       </tr>
  <?
     $url = $zen->getSetting("url_view_attachment")."?aid=";
     $attachments = $hotkeys->activateList($attachments, "name", "description", "ticketClk('{$url}{attachment_id}', false, true)");
     foreach($attachments as $a) {
       $aid = $a['attachment_id'];
       $clk = "onclick=\"return ticketClk('$url$aid', event, true);\"";
	?>
	  <tr class='bars' <?=$row_rollover_eff?> title="<?=$a['hotkey_tooltip']?>">
	  <td <?=$clk?>>
	    <?= ($a["log_id"])?
          $a['log_id']." ".
	         "<a href='".$zen->getSetting("url_view_log")
                    ."?lid=".$zen->ffv($a['log_id'])."' class='rowLink'>"
                    ."<img src='$imageUrl/24x24/magnify.png' width='24' height='24' border='0'>"
                    ."</a>" :
	         "n/a";
	    ?>
	  </td>
	  <td <?=$clk?>>
	    <a href='<?=$url.$aid?>' 
	    class='rowLink' target='_blank'><?=$a['hotkey_label']?></a></td>
	  <td <?=$clk?>>
	    <?=$zen->ffv($a["filetype"])?>
	  </td>
	  <td <?=$clk?>>
	    <?=$zen->ffv($a["description"])?>
	  </td>
    <? if( $access ) { ?>
    <td class='bars' onclick='checkMyBox("drops_<?=$aid?>", event)'>
      <input id='drops_<?=$aid?>' type='checkbox' name='drops[]' value='<?=$aid?>'>
    </td>
    <? } ?>
	  </tr>
    <?
     }    
  } else {
     print "<tr><td class='bars' colspan='4'>".tr("No attachments exist for this ?", array($page_type))."</td></tr>";
  }
?>
  <? if( $access ) { ?>
  <tr> 
     <td class='subTitle' colspan='<?=$colspan?>'>
     <? if( is_array($attachments) && count($attachments) ) { ?>
       <div style='float:right'>
       <? renderDivButtonFind('Delete Attachments', 150); ?>
       </div>
     <? } ?>
       </form>
       <div style='float:left'>
       <form name='addAttachmentForm' action='<?=$rootUrl?>/actions/upload.php'>
       <input type="hidden" name="id" value="<?=$id?>">
       <input type='hidden' name='setmode' value="<?=$zen->ffv($page_mode)?>">
       <? renderDivButtonFind('Add Attachment', 150); ?>
       </form>
       </div>
     </td>
   </tr>  
   <? } ?>
</table>
