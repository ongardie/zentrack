
<form method="post" name="contactForm" action="<?=($skip)? "editContacteSubmit.php" : "$rootUrl/addContacteSubmit.php"?>">
<?
if(isset($creator_id)) { ?>
<input type="hidden" name="creator_id" value="<?=strip_tags($creator_id)?>">	
<?
}
if(isset($create_time)) { ?>
<input type="hidden" name="create_time" value="<?=strip_tags($create_time)?>">	
<?
}
?>

<input type="hidden" name="id" value="<?=strip_tags($person_id)?>">
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     <?=tr("Contact Information")?>
  </td>
</tr>
  
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Details")?>
  </td>
</tr>

<tr>
  <td class="bars">
    <?=tr("Last name")?>:
  </td>
  <td class="bars">
    <input type="text" name="lname" size="20" maxlength="50"
value="<?=strip_tags($lname)?>">
  </td>
</tr>    

<tr>
  <td class="bars">
    <?=tr("First name")?>:
  </td>
  <td class="bars">
    <input type="text" name="fname" size="20" maxlength="25"
      value="<?=strip_tags($fname)?>">
  </td>
</tr>               
          
<tr>
  <td class="bars">
    <?=tr("Initials")?>:
  </td>
  <td class="bars">
    <input type="text" name="initials" size="5" maxlength="15"
value="<?=strip_tags($initials)?>">
  </td>
</tr>  
    
<tr>
  <td class="bars">
    <?=tr("Title")?>:
  </td>
  <td class="bars">
    <input type="text" name="jobtitle" size="20" maxlength="50"
value="<?=strip_tags($jobtitle)?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=tr("Department")?>:
  </td>
  <td class="bars">
    <input type="text" name="department" size="20" maxlength="50"
value="<?=strip_tags($department)?>">
  </td>
</tr> 


<tr>
  <td class="bars">
    <?=tr("Telephone")?>:
  </td>
  <td class="bars">
    <input type="text" name="telephone" size="20" maxlength="50"
      value="<?=strip_tags($telephone)?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=tr("Mobile")?>:
  </td>
  <td class="bars">
    <input type="text" name="mobiel" size="20" maxlength="20"
      value="<?=strip_tags($mobiel)?>">
  </td>
</tr>  

<tr>
  <td class="bars">
    <?=tr("Email")?>:
  </td>
  <td class="bars">
    <input type="text" name="email" size="30" maxlength="50"
value="<?=strip_tags($email)?>">
  </td>
</tr> 

<?

if (isset($cid)) {
?>
	<input type="hidden" name="company_id" value="<?=strip_tags($cid)?>">		
<?
	} else {
	$company = $zen->get_contact_all();
	if (is_array($company)) {
	?>
		<tr>
  	<td class="bars">
    <?=tr("Company")?>:
  	</td>
  	<td class="bars">
		<select name="company_id">
  	<option value=''>--<?=tr("none")?>--</option>
		<?
		foreach($company as $p) {
			$sel = ($p["company_id"] == $company_id)? " selected" : "";
			$val =($p['office'])?strtoupper($p[title])." ,".$p[office]:strtoupper($p[title]);
	  	print "<option value='$p[company_id]' $sel>".$val."</option>\n";
		}
	?>
	</select>
	</td>
	</tr>
	<?
	}
}

?> 

<tr>
  <td class="bars">
    <?=tr("Type")?>:
  </td>
  <td class="bars">
      <?if($inextern==extern) {echo "selected";}?>
     <select name="inextern">
    <option <?if($inextern==1) {echo "selected";}?> value='1'>External</option>
    <option <?if($inextern==2) {echo "selected";}?> value='2'>Internal</option>
    </select>
  </td>
</tr>   

<tr>
  <td colspan="2" class="bars">
    <?=tr("Notes")?>:
  </td>
</tr>
  
<tr>
  <td colspan="2" class="bars">
    <textarea cols="60" rows="5" name="description"><?= 
   ereg_replace("&","&amp;",stripslashes($description)); 
    ?></textarea>
  </td>
</tr>
<tr>
  <td class="titleCell" colspan="2" align="center">
  <?=tr("Click button to")?> <?=($td)? tr("save your changes"):tr("create your contact")?>.
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value=" <?=($skip)?"Save":"Create"?> " class="submit">
  </td>
</tr>
</table>