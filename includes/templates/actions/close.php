
<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold">CLOSE TICKET</span>
   <br>
   <span class="small">(Set status to closed/pending)</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
    Enter any hours worked not previously accounted for <span class="small">(optional)</span>
  </td>
</tr>
<tr>
  <td>
    <input type="text" name="hours" size="10" maxlength="10" value="<?=strip_tags($hours)?>">
  </td>
</tr>
<tr>
  <td class="titleCell">
     Comments or Instructions <span class="small">(optional)</span>
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
    Click button to close
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" CLOSE " class="submit">
  </td>
</tr>
<tr>
</table>

</form>			     
