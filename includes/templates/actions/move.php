
<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold">MOVE TICKET</span>
   <br>
   <span class="small">(Send ticket to another bin)</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
     Comments <span class="small">(optional)</span>
  </td>
</tr>
<tr>
  <td>
    <textarea cols="50" rows="4" name="comments"><?=
      strip_tags($comments)?></textarea>
  </td>
</tr>
<tr>
  <td>
    <select name='newBin'>
     <?
	$userBins = $zen->getUsersBins($login_id);
	if( is_array($userBins) ) {
	  foreach($userBins as $v) {
	    $n = $zen->bins["$v"];
	    print "<option value='$v'>$n</option>\n";
	  }
	} else {
	  print "<option value=''>--no bins--<option>\n";
	}
     ?>
    </select>
  </td>
</tr>
<tr>
  <td class="titleCell">
    Click button to move ticket
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" MOVE " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>			     
