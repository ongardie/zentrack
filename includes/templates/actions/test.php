<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=uptr("Test Ticket")?></span>
   <br>
   <span class="small">(<?=tr("Set testing to completed on ticket")?>)</span>
 </td>
</tr>
<tr>
 <td class="titleCell">
   <?=tr("Enter hours worked")?>
 </td>
</tr>
<tr>
 <td>
   <input type="text" name="hours" size="4" maxlength="8" value="<?=strip_tags($hours)?>">
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
    Click button to complete testing
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?=tr("Tested")?> " class="submit">
  </td>
</tr>
<tr>
</table>

</form>			     
