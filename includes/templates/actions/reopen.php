
<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=uptr("Reopen Ticket")?></span>
   <br>
   <span class="small">(<?=tr("Open ticket closed in error")?>)</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
     <?=tr("Comments or Instructions")?>
	&nbsp;<span class="small">(<?=tr("required")?>)</span>
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
    <?=tr("Click button to open")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?=uptr("Reopen")?> " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>			     
