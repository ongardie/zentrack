
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
<select name="user_id">
<?
  $bins = $zen->getUsersBins($login_id,"level_assign");
  if( is_array($bins) ) {
    foreach($zen->get_users($bins) as $v) {
      if( $v["user_id"] != $login_id ) {
	$sel = ($v["user_id"] == $user_id)? "selected" : "";
	print "<option value='$v[user_id]' $sel>".$zen->formatName($v,1)."</option>\n";
      }
    }
  }
  else {
    print "<option value=''>--none--</option>\n";
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
