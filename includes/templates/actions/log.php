
<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold">LOG / HOURS</span>
   <br>
   <span class="small">(Create a log entry, or log hours worked)</span>
 </td>
</tr>
<tr>
 <td class="titleCell">
   Select an activity
 </td>
</tr>
<tr>
 <td>
<select name="action">
  <?
    foreach( $log_actions as $a ) {
       print ($a == $action || (!$action && $a == 'LOG') )?
	 "<option selected>$a</option>\n" :
         "<option>$a</opton>\n";
    }  
  ?>
</select>
  </td>			     
</tr>
<tr>
  <td class="titleCell">
    Enter the hours worked on this project <span class="small">(accepts up to 2 decimal places)</span>
  </td>
</tr>
<tr>
  <td>
    <input type="text" name="hours" size="4" maxlength="8" value="<?=strip_tags($hours)?>">
  </td>
</tr>
<tr>
  <td class="titleCell">
     Comments or Instructions
  </td>
</tr>
<tr>
  <td>
    <textarea cols="50" rows="4" name="comments"><?=
      htmlentities(stripslashes($comments))?></textarea>
  </td>
</tr>
<tr>
  <td class="titleCell">
    Click button to create log
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" LOG " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>			     
