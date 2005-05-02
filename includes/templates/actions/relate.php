<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" action="<?=$SCRIPT_NAME?>" name='relateTicketForm'>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=uptr("Relate Ticket")?></span>
   <br>
   <span class="small">(<?=tr("Associate this ticket with others")?>)</span>
 </td>
</tr>
<tr>
 <td class="titleCell">
   <?=tr("Enter Ticket IDs")?>
 </td>
</tr>
<tr>
 <td>
    <textarea cols='20' rows='4' 
	name='relations'><?=strip_tags($relations)?></textarea>
     &nbsp;<input type='button' class='searchbox' value=' ... ' 
	onClick='popupWindowScrolls("<?=$rootUrl?>/helpers/ticketSearchbox.php?return_form=relateTicketForm&return_field=relations","popupHelper",375,500)'>
     <br><span class='note'> <?=tr("Enter ticket ids, separated by commas")?></span>
  </td>			     
</tr>
<tr>
  <td class="titleCell">
     <?=tr("Comments or Instructions")?> 
	&nbsp;<span class="small">(<?=tr("optional")?>)</span>
  </td>
</tr>
<tr>
  <td>
    <textarea cols="50" rows="4" name="comments"><?=
      strip_tags($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="titleCell">
    <?=tr("Click button to assign relations")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?=uptr("Relate")?> " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>
