<?
  /**
   * creates a form for adding entries to the contact list
   */
?>


<script type="text/javascript">
function printpopup(varialbe)
{
location.href ="<?=$_ENV['SCRIPT_NAME']?>?id=<?=$id?>&company_id="+varialbe
}
</script>

<form method='post' action='<?=$zen->ffv($SCRIPT_NAME)?>' name='ContactsAddForm'>
<input type='hidden' name='id' value='<?=$id?>'>
<input type='hidden' name='actionComplete' value='1'>

<table width="50%" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=tr("Add a Contact")?></span>
 </td>
</tr>
<?
  // collect contact data
	$companies = $zen->get_contact_all();	
	if (empty($company_id)) {
		$parms = array(1 => array(1 => "company_id", 2 => "=", 3 => "0"),
		);
	} else {
		$parms = array(1 => array(1 => "company_id", 2 => "=", 3 => $company_id),
		);
	}
	$sort = "lname asc";
	$people = $zen->get_contacts($parms,"ZENTRACK_EMPLOYEE",$sort);

  $company_title = $company_id;
  
  // determine column span
  $colspan = 1;
  if( $companies || $people ) {
    $colspan = 2;
  }
  
  
	if (is_array($companies)||count($companies)) {
	?>
<tr>
<td class='titleCell' colspan='<?=$colspan?>'>
<?
echo tr("Select a contact");
?>
</td>
</tr>
<tr>

   <td class='bars'><?=tr("Company")?></td>
    <td class='bars'>

		<select name="company_id" onChange="printpopup(document.forms['ContactsAddForm'].company_id.value)">
  	<option value=''>--<?=tr("none")?>--</option>
		<?
		foreach($companies as $p) {
      if( $p['company_id'] == $company_id ) {
        $sel = " selected";
        $company_title = $p['title'];
      }
      else {
        $sel = ""; 
      }
			$val =($p['office'])? strtoupper($p['title'])." ,".$p['office'] : strtoupper($p['title']);
	  	print "<option value='$p[company_id]' $sel>$val</option>\n";
		}
	?>
	</select>
  
    </td>
	<?
	}
	
	if (is_array($people)||count($people)) {
  ?>
  </tr>
  <tr>
    <td class='bars'><?= tr("Person") ?></td>
    <td class='bars'>
		<select name="person_id">
  	<option value=''>--<?=tr("none")?>--</option>
		<?
		foreach($people as $p) {
			$val =($p['fname'])?ucfirst($p[lname])." ,".ucfirst($p[fname]):ucfirst($p[lname]);
	  	print "<option value='$p[person_id]' >".$val."</option>\n";
		}
	?>
	  </select>
  <?
    if( $company_id ) { print '<br>'.tr("(Employees of '?' only)", $company_title); } 
  ?>
    </td>
	<?
	}
  else if( $company_id ) {
  ?>
  <tr>
    <td class='bars'><?=tr('Person')?></td>
    <td class='bars'>
      <?=tr('There are no employees assigned to this company.')?>  
      <br><a href='<?=$rootUrl?>/actions/contact_employee.php?cid=<?=$company_id?>'>
        <?=tr('Click Here')?></a> 
      <?=tr('to add one')?>.
    </td>
  </tr>
  <?
  }
  
  if( !$people && !$companies ) {
    print tr("There are no contacts to add.");
  }
	?>
  
  <br>&nbsp;
</td>
</tr>

<tr>
  <td class="titleCell" colspan='<?=$colspan?>'>
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

<?
  if( $people || $companies ) {
?>
  <p>&nbsp;
  <form action='<?=$rootUrl?>/newContact.php'>
    <input type='submit' class='actionButton' value=' <?=tr("New Contact")?> '>
  </form>
<?
  }
?>
