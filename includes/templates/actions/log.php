
<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=uptr("Log")?></span>
   <br>
   <span class="small">(<?=tr("Create a log entry, or log hours worked")?>)</span>
 </td>
</tr>
<tr>
 <td class="titleCell">
   <?=tr("Select an activity")?>
 </td>
</tr>
<tr>
 <td>
<select name="log_action">
  <?
    foreach( $log_actions as $a ) {
       print ($a == $log_action || (!$log_action && $a == 'LOG') )?
	 "<option selected>$a</option>\n" :
         "<option>$a</opton>\n";
    }  
  ?>
</select>
  </td>			     
</tr>
<tr>
  <td class="titleCell">
    <?=tr("Enter the hours worked for this entry")?> <span class="small">(<?=tr("accepts up to 2 decimal places")?>)</span>
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
    <?=tr("Click button to create log")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?=uptr("Log")?> " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>			     
