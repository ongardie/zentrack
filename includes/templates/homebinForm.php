
<form method="post" action="<?=$SCRIPT_NAME?>">

<blockquote>
<table width="300" cellpadding="5">
<tr>
  <td colspan="2" class="titleCell" align="center" height="20">
    <b>Change Your Default Bin</b>
  </td>
</tr>
<tr>
  <td class="bars">
    <b>New Default Bin</b>
  </td>
  <td class="bars">
    <select name="homebin">
      <option value=''>--All--</option>
<?
  $userBins = $zen->getUsersBins($login_id);
  $user = $zen->getUser($login_id);
  $homebin= $user["homebin"];
  if( is_array($userBins) ) {
    foreach($userBins as $k=>$v) {
      if( $k ) {
	$check = ( $k == $homebin )? "selected" : "";
	$n = $zen->bins["$k"];
	print "<option $check value='$k'>$n</option>\n";
      }
    }
  }
?>
    </select>
  </td>
</tr>
<tr>
  <td class="titleCell" colspan="2">
    Click 'Update' to change your default bin
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
    <input type="submit" value="Update" class="submit">
  </td>
</tr>
</table>
</blockquote>

<input type="hidden" name="TODO" value="BIN">
</form>


