
<form method="post" action="<?=$SCRIPT_NAME?>" name='relateTicketForm'>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold">RELATE TICKET</span>
   <br>
   <span class="small">(Associate this ticket with others)</span>
 </td>
</tr>
<tr>
 <td class="titleCell">
   Enter ticket ids, seperated by carriage returns
 </td>
</tr>
<tr>
 <td>
    <textarea cols='20' rows='4' 
	name='relations'><?=strip_tags($relations)?></textarea>
     &nbsp;<input type='button' class='searchbox' value=' ... ' 
	onClick='return popupWindowScrolls("/helpers/ticketSearchbox.php?return_form=relateTicketForm&return_field=relations","popupHelper",375,500)'>
     <br><span class='note'>Type ids separated by commas, or press 'search'</span>
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
    Click button to assign relations
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" RELATE " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>			     
