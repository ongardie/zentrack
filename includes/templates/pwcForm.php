<?
  $user = $zen->getUser($login_id);
  if( $user["password"] == $zen->encval($user["lname"]) ) {
    print "<p class='hot'>Your password is currently set to the system default.  Please update.</p>\n";
  }
?>

<form method="post" action="<?=$SCRIPT_NAME?>">
<blockquote>
<table width="300" cellpadding="5">
<tr>
  <td colspan="2" class="titleCell" align="center" height="20">
    <b>Change User Password</b>
  </td>
</tr>
<?
  if( $zen->settings["check_pwd_simple"] ) {
?>
<tr>
  <td colspan="2" class="bars">
    Your password must be at least 6 characters long and 
    contain at least 1 non-letter character
  </td>
<tr>
<?
  }
?>
<tr>
  <td class="bars">
    <b>New Password</b>
  </td>
  <td class="bars">
    <input type="password" name="newPass1" size="25" maxlength="25">
  </td>
</tr>
<tr>
  <td class="bars">
    <b>Retype New Password</b>
  </td>
  <td class="bars">
    <input type="password" name="newPass2" size="25" maxlength="25">
  </td>
</tr>
<tr>
  <td class="titleCell" colspan="2">
    Please keep track of your new password.
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
    <input type="submit" value="Set Password" class="submit">
  </td>
</tr>
</table>
</blockquote>

<input type="hidden" name="TODO" value="SET">
</form>


