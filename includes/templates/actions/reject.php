
<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=uptr("Reject Ticket")?></span>
   <br>
   <span class="small">(<?=tr("Return ticket to sender")?>)</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
     <?=tr("Reason")?> <span class="highlight">(<?=tr("required")?>)</span>
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
    <?=tr("Click button to reject")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?=uptr("Reject")?> " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>			     
