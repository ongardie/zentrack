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
    <?=tr("User Information")?> (<?=tr("* = required")?>)
  </td>
</tr>  
<tr>
  <td class="bars">
    <?=tr("Last Name")?>*
  </td>
  <td class="bars">
    <input type="text" name="lname" value="<?=strip_tags($lname)?>" size="40" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("First Name")?>
  </td>
  <td class="bars">
    <input type="text" name="fname" value="<?=strip_tags($fname)?>" size="40" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Initials")?>*
  </td>
  <td class="bars">
    <input type="text" name="initials" value="<?=strip_tags($initials)?>" size=5 maxlength="5">
    <br><span class="small">(Letter and numbers only)</span>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Email")?>
  </td>
  <td class="bars">
    <input type="text" name="email" value="<?=strip_tags($email)?>" size="40" maxlength="100">
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Account Settings")?>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Login Name")?>*
  </td>
  <td class="bars">
    <input type="text" name="login" value="<?=strip_tags($login)?>" size="20" maxlength="25">
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Default Access Level")?>
  </td>
  <td class="bars">
    <input type="text" name="access_level" value="<?=($access_level)? strip_tags($access_level) : 0?>" 
           size="3" maxlength="2">
    <br><span class="small">
      (<?=tr("This grants the user the specified level of access to all bins not otherwise indicated by 'user access'.")?>  <?=tr("Use zero if unsure.")?>)
      </span>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Notes")?>
  </td>
  <td class="bars">
    <input type="text" name="notes" value="<?=strip_tags($notes)?>" size="50" maxlength="255">
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Home Bin")?>
  </td>
  <td class="bars">
    <select name="homebin">
      <?
       if( is_array($zen->bins) ) {
         print "<option $check value='-1'>-All-</option>\n";
         foreach($zen->getBins(1) as $v) {
           $k = $v["bid"];
           print ($k == $homebin)? 
             "<option selected value='$k'>$v[name]</option>\n" : "<option value='$k'>$v[name]</option>\n";
         }
       }
      ?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Active")?>
  </td>
  <td class="bars">
    <input type="checkbox" name="active" value="1" 
	<?=(!strlen($active) || $active)? "checked" : ""?>>
    <br><span class="small">(<?=tr("Uncheck to disable this account.")?>)</span>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Click ? to ?",array($button,$blurb))?>.
  </td>
</tr>  
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value="<?=$button?>" class="submit">
  </td>
</tr>
</table>

</form>
