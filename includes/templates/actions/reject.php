
<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold">REJECT TICKET</span>
   <br>
   <span class="small">(Return ticket to sender)</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
     Reason <span class="highlight">(required)</span>
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
    Click button to reject
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" REJECT " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>			     
