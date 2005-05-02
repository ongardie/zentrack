<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

   $rollover_text = " onclick=\"mClk(this);\" "
      ."onmouseout=\"mOut(this,'".$zen->settings["color_background"]."', '');\" "
      ."onmouseover=\"mOvr(this,'".$zen->settings["color_bars"]."', '');\"";
   $row = "background:".$zen->settings["color_background"];
?>
  <table width="600" align="center" cellpadding="2" cellspacing="2">
  <tr> 
     <form action="<?=$rootUrl?>/actions/upload.php">
     <input type="hidden" name="id" value="<?=strip_tags($id)?>">
     <td align="right">
       <?
         if( $zen->actionApplicable($id,"upload",$login_id) ) {
	    $button = "submit";
	    $color = $zen->settings["color_highlight"];
	 } else {
	    $button = "button";
	    $color = $zen->settings["color_alt_background"];
	 }
       ?>
       <input type="<?=$button?>" value=" <?=uptr("Add Attachment")?> " class="actionButton" style="width:125;color:<?=$color?>">
     </td>
     </form>
   </tr>  
   <tr>  
     <td class="titleCell">
        <?=tr("Attachments on ? #?",array($page_type,$id))?>
     </td>
  </tr>
   <tr>
    <td colspan="2">
<?
  // get attachments and display a list
  // of them
  $attachments = $zen->get_attachments($id);
  if( is_array($attachments) && count($attachments) > 0) {
     ?>
       <table width="100%" cellpadding='2' cellspacing='1' border='0'>
       <tr>
         <td class='bars' width='150'><?=tr("Attachment")?></td>
         <td class='bars' width='50'><?=tr("Log ID")?></td>
         <td class='bars' width='50'><?=tr("Type")?></td>
         <td class='bars'><?=tr("Description")?></td>
       </tr>
     <?
     foreach($attachments as $a) {
	?>
	  <tr style="<?=$row?>">
	  <td <?=$rollover_text?>>
	    <a href='<?=$zen->settings["url_view_attachment"]?>?aid=<?=$a["attachment_id"]?>' 
	    class='rowLink' target='_blank'><?=$a[name]?></a></td>
	  <td <?=($a["log_id"])? $rollover_text:"";?>>
	    <?= ($a["log_id"])?
	         "<a href='".$zen->settings["url_view_log"]
                    ."?lid=$a[log_id]' class='rowLink'>$a[log_id]</a>" :
	         "n/a";
	    ?>
	  </td>
	  <td class='plainCell'>
	    <?=$a["filetype"]?>
	  </td>
	  <td class='plainCell'>
	    <?=$a["description"]?>
	  </td>
	  </tr>
        <?
     }    
     print "</table>\n";
  } else {
     print tr("No attachments exist for this ?", array($page_type));
  }
?>
    </td>
   </tr>
   </table>

