<?
  /**
   * creates a form for adding entries to the contact list
   */
?>


<script type="text/javascript">
function printpopup(varialbe)
{
location.href ="<?=$rootUrl.$zen->ffv($SCRIPT_NAME)?>?id=<?=$id?>&company_id="+varialbe
}
</script>

<form method='post' action='<?=$zen->ffv($SCRIPT_NAME)?>' name='ContactsAddForm'>
<input type='hidden' name='id' value='<?=$id?>'>
<input type='hidden' name='actionComplete' value='1'>

<table width="100%" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=tr("Add Contact to list")?></span>
 </td>
</tr>
<tr>
<td>
<?
echo tr("Select only one contact.");
?>
</td>
</tr>
<tr>
<td>
<?
echo tr("Company:");
	$company = $zen->get_contact_all();
	if (is_array($company)||count($company)) {
	
	?>

		<select name="company_id" onChange="printpopup(document.forms['ContactsAddForm'].company_id.value)">
  	<option value=''>--<?=tr("none")?>--</option>
		<?
		foreach($company as $p) {
			$sel = ($p["company_id"] == $company_id)? " selected" : "";
			$val =($p['office'])?strtoupper($p[title])." ,".$p[office]:strtoupper($p[title]);
	  	print "<option value='$p[company_id]' $sel>".$val."</option>\n";
		}
	?>
	</select>
	<?
	}
	if (empty($company_id)) {
		$parms = array(1 => array(1 => "company_id", 2 => "=", 3 => "0"),
		);
	} else {
		$parms = array(1 => array(1 => "company_id", 2 => "=", 3 => $company_id),
		);
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
	<?
	}
	?>
</td>
</tr>

<tr>
  <td class="titleCell">
    <?=tr("Click button to add contact")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value="<?=uptr("Add")?>" class="submit" >
  </td>
</tr>
<tr>
</table>


</form>