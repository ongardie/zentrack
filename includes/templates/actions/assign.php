<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=uptr("Assign Ticket")?></span>
   <br>
   <span class="small">(<?=tr("Assign the ticket to a new user")?>)</span>
 </td>
</tr>
<tr>
 <td class="titleCell">
   <?=tr("Select a Recipient")?>
 </td>
</tr>
<tr>
 <td>
<select name="user_id">
<?
  //$bins = $zen->getUsersBins($login_id,"level_assign");
  // ticket can only be assigned to users who may access
  // the ticket's current bin
  $bins = array($ticket["bin_id"]);
  $users = $zen->get_users($bins,"level_user");
  if( is_array($bins) && is_array($users) ) {
    foreach($users as $v) {
      if( $v["user_id"] != $login_id ) {
	$sel = ($v["user_id"] == $user_id)? "selected" : "";
	print "<option value='$v[user_id]' $sel>".$zen->formatName($v,1)."</option>\n";
      }
    }
  }
  else {
    print "<option value=''>--".tr("none")."--</option>\n";
  }
?>
</select>
  </td>			     
</tr>
<tr>
  <td class="titleCell">
     <?=tr("Comments or Instructions")?> <span class="small">(<?=tr("optional")?>)</span>
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
    <?=tr("Click button to assign")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" ASSIGN " class="submit">
<p class='note'><?=tr("Note").":".tr("Only users who have permission to work on tickets in the current bin are listed.")?></p>
  </td>
</tr>
<tr>
</table>

</form>			     
