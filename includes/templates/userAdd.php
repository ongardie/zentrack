<?
  // generate some text to display based on whether this
  // is an edit page or an add page
  $td = ($TODO == 'EDIT');
  $blurb = ($td)? "Edit User Account" : "Create New User Account";
  $button = ($td)? "Save Changes" : "Create Account";
  $url = ($td)? "edit" : "add";
?>
<form method="post" action="<?=$rootUrl?>/admin/<?=$url?>UserSubmit.php">
<? if( $td ) { print "<input type='hidden' name='user_id' value='".strip_tags($user_id)."'>\n"; } ?>
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
  <?=$blurb?>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    User Information (* = required)
  </td>
</tr>  
<tr>
  <td class="bars">
    Last Name*
  </td>
  <td class="bars">
    <input type="text" name="lname" value="<?=strip_tags($lname)?>" size="40" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
    First Name
  </td>
  <td class="bars">
    <input type="text" name="fname" value="<?=strip_tags($fname)?>" size="40" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
    Initials*
  </td>
  <td class="bars">
    <input type="text" name="initials" value="<?=strip_tags($initials)?>" size=5 maxlength="5">
    <br><span class="small">(Letter and numbers only)</span>
  </td>
</tr>
<tr>
  <td class="bars">
    Email
  </td>
  <td class="bars">
    <input type="text" name="email" value="<?=strip_tags($email)?>" size="40" maxlength="100">
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    Account Settings
  </td>
</tr>
<tr>
  <td class="bars">
    User Login Name*
  </td>
  <td class="bars">
    <input type="text" name="login" value="<?=strip_tags($login)?>" size="20" maxlength="25">
  </td>
</tr>
<tr>
  <td class="bars">
    Default Acces Level
  </td>
  <td class="bars">
    <input type="text" name="access_level" value="<?=($access_level)? strip_tags($access_level) : 0?>" 
           size="3" maxlength="2">
    <br><span class="small">(This grants the user the specified level of 
	access to all bins not otherwise indicated by 'user access'.  Use zero if unsure.)</span>
  </td>
</tr>
<tr>
  <td class="bars">
    Role (tester,manager,etc)
  </td>
  <td class="bars">
    <input type="text" name="notes" value="<?=strip_tags($notes)?>" size="50" maxlength="255">
  </td>
</tr>
<tr>
  <td class="bars">
    Home Bin
  </td>
  <td class="bars">
    <select name="homebin">
      <?
       if( is_array($zen->bins) ) {
	  foreach($zen->bins as $k=>$v) {
	     print ($k == $homebin)? 
	       "<option selected value='$k'>$v</option>\n" : "<option value='$k'>$v</option>\n";
	  }
       }
      ?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    Active
  </td>
  <td class="bars">
    <input type="checkbox" name="active" value="1" 
	<?=(!strlen($active) || $active)? "checked" : ""?>>
    <br><span class="small">(Uncheck this box to disable this user account.)</span>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    Click <?=$button?> to <?=$blurb?>.
  </td>
</tr>  
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value="<?=$button?>" class="submit">
  </td>
</tr>
</table>

</form>
