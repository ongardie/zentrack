<?{
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**
   * creates a form for adding entries to the
   * ticket notify list
   */
}?>
<script type="text/javascript">
function printpopup(variable)
{
  location.href ="<?=$zen->ffv($SCRIPT_NAME)."?id=".$id ?>&company_id="+variable
}
</script>

<form method='post' action='<?=$zen->ffv($SCRIPT_NAME)?>' name='notifyAddForm'>
<input type='hidden' name='id' value='<?=$zen->ffv($id)?>'>
<input type='hidden' name='actionComplete' value='1'>

<table width="550" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=tr("Add Notify Recipient")?></span>
   <br>
   <span class="small">(<?=tr("Add recipients to the notify list for this ticket")?>)</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
     <?=tr("Enter registered users")?>
  </td>
</tr>
<tr>
  <td>
<?
  // make a user textarea and search button
  print "<textarea cols='20' rows='4' name='user_accts'>\n";
  print (isset($user_accts))? $zen->ffv($user_accts) : "";
  print "</textarea>\n";
  $onclick = "onClick='return popupWindowScrolls"
    ."(\"$rootUrl/helpers/userSearchbox.php?return_form=notifyAddForm"
    ."&return_field=user_accts\",\"popupHelper\",375,400)'";
  print "&nbsp;<input type='button' class='searchbox' "
    ." value=' ... ' $onclick>\n";
  print "<br><span class='note'>"
	.tr("Type ids separated by commas, or click on the button.")
	."</span>\n";
?>
  </td>
</tr>
<tr>
  <td class="titleCell">
     <?=tr("Or add an unregistered user")?>
  </td>
</tr>
<tr>
  <td class='subTitle'>
    <?=tr("Name")?>
  </td>
</tr>
<tr>
  <td>
    <input type='text' name='unreg_name' size='20' maxlength='255' 
           value='<?=$zen->ffv($unreg_name)?>'>
  </td>
</tr>
<tr>
  <td class='subTitle'>
    <?=tr("Email")?>
  </td>
</tr>
<tr>
  <td>
    <input type='text' name='unreg_email' size='20' maxlength='255' 
           value='<?=$zen->ffv($unreg_email)?>'>
  </td>
</tr>
  <? if( $zen->settingOn('allow_contacts') ) { ?>
<tr>
  <td class="titleCell">
     <?=tr("Or add a contact")?>
  </td>
</tr>
<tr>
<td class='subTitle'>
<br>
<?
  print tr("Company:");
  $company = $zen->get_contact_all();
  if (is_array($company)||count($company)) {
?>

  <select name="company_id" onChange="printpopup(document.forms['notifyAddForm'].company_id.value)">
    <option value=''>--<?=tr("none")?>--</option>
<?
   foreach($company as $p) {
      $sel = ($p["company_id"] == $company_id)? " selected" : "";
      $val =($p['office'])? strtoupper($p['title']) . " ," 
            . $p['office'] : strtoupper($p['title']);
      print "<option value='$p[company_id]' $sel>".$val."</option>\n";
    }
?>
  </select>
<?
  }
  if (empty($company_id)) {
    $parms = array(1 => array(1 => "company_id", 2 => "=", 3 => "0"));
  } else {
    $parms = array(1 => array(1 => "company_id", 2 => "=", 3 => $company_id));
  }
	
  $sort = "lname asc";
  $company = $zen->get_contacts($parms,"ZENTRACK_EMPLOYEE",$sort);
	
  if (is_array($company)||count($company)) {
    echo tr("Or Person:");
?>
    <select name="person_id">
      <option value=''>--<?=tr("none")?>--</option>
	<?
	  foreach($company as $p) {
            $val =($p['fname'])?ucfirst($p[lname])." ,".ucfirst($p[fname]):ucfirst($p[lname]);
	    print "<option value='$p[person_id]' >".$val."</option>\n";
          }
	?>
    </select>
    <br><br>
<?
  } //if( is_array($company).. )
  } //if( $zen->getSetting('allow_contacts')... )
?>
	
</td>
</tr>
<tr>
  <td class="titleCell">
    <?=tr("Click button to add recipients")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?=uptr("Add")?> " class="submit">
  </td>
</tr>
<tr>
</table>



</form>
