
<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold">ASSIGN TICKET</span>
   <br>
   <span class="small">(Assign the ticket to a new user)</span>
 </td>
</tr>
<tr>
 <td class="titleCell">
   Select a Recipient
 </td>
</tr>
<tr>
 <td>
<select name="userID">
<?
  $bins = array_keys($zen->getAccess($login_id));
  foreach($zen->get_users($bins) as $v) {
    if( $v["userID"] != $login_id ) {
      $sel = ($v["userID"] == $userID)? "selected" : "";
      print "<option value='$v[userID]' $sel>".$zen->formatName($v,1)."</option>\n";
    }
  }
?>
</select>
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
    Click button to assign
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" ASSIGN " class="submit">
  </td>
</tr>
<tr>
</table>

</form>			     
