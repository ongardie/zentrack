
<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=uptr("Yank Ticket")?></span>
   <br>
   <span class="small">(<?=tr("Pull ticket from the current owner")?>)</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
     Reason <span class="small">(<?=tr("optional")?>)</span>
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
    <?=tr("Click button to yank ticket")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?=uptr("Yank")?> " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>			     
