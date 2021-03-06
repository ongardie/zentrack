<? if( !ZT_DEFINED ) { die("Illegal Access"); } 

  $button = $skip? "Update" : "Create";
  
  // prepare hot keys
  $fields = array(
    "company_id"  => "Company",
    "lname"       => "Last Name",
    "fname"       => "First Name",
    "initials"    => "Initials",
    "jobtitle"    => "Title",
    "department"  => "Department",
    "telephone"   => "Telephone",
    "mobiel"      => "Mobile",
    "email"       => "Email",
    "inextern"    => "Type",
    "description" => "Notes"
  );
  $hotkeys->activateButton($button, 'contactForm');
  $keystrokes = $hotkeys->activateFieldList($fields, 'contactForm');
  
  function hkLabel($field) {
    $hk = $GLOBALS['keystrokes'][$field];
    return $hk->getLabel();
  }
  
  function hkTip($field) {
    $hk = $GLOBALS['keystrokes'][$field];
    return $hk->getTooltip();
  }
  
?>

<form method="post" name="contactForm" action="<?=($skip)? "editContacteSubmit.php" : "$rootUrl/addContacteSubmit.php"?>">
<?
if(isset($creator_id)) { ?>
<input type="hidden" name="creator_id" value="<?=$zen->ffv($creator_id)?>">	
<?
}
if(isset($create_time)) { ?>
<input type="hidden" name="create_time" value="<?=$zen->ffv($create_time)?>">	
<?
}
?>

<input type="hidden" name="id" value="<?=$zen->ffv($person_id)?>">
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->getSetting("color_background")?>">
<tr>
  <td colspan="2" width="640" class="subTitle" align="center">
     <?=tr("Contact Information")?>
  </td>
</tr>
  
<tr>
  <td colspan="2" class="headerCell">
    <?=tr("Info")?>
  </td>
</tr>

<?

	$company = $zen->get_contact_all();
  if( isset($cid) ) {
    $cid = $zen->checkNum($cid); 
  }
  if ( $cid ) {
    foreach($company as $c) {
      if( $c['company_id'] == $cid ) {
			   $cn = $c['office']?
            strtoupper($c['title'])." ,".$c['office'] : strtoupper($c['title']);
         break;
      }
    }
    if( !$cn ) { $cn = $cid." (untitled company) "; }
?>
  <tr>
  <td class='bars'>
    <?=tr("Company")?>:  
	  <input type="hidden" name="company_id" value="<?=$zen->ffv($cid)?>">
  </td>
  <td class='bars'><?=$zen->ffv($cn)?></td>
  </tr>
<?
	} else {
	if (is_array($company)) {
	?>
		<tr>
  	<td class="bars">
    <?=hkLabel("company_id")?>
  	</td>
  	<td class="bars">
		<select name="company_id" title="<?=hkTip('company_id')?>"
  	<option value=''>--<?=tr("none")?>--</option>
		<?
		foreach($company as $p) {
			$sel = ($p["company_id"] == $company_id)? " selected" : "";
			$val =($p['office'])?strtoupper($p['title'])." ,".$p['office']:strtoupper($p['title']);
	  	print "<option value='{$p['company_id']}' $sel>".$zen->ffv($val)."</option>\n";
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
    <?=hkLabel("lname")?>
  </td>
  <td class="bars">
    <input type="text" name="lname" size="20" maxlength="50"
value="<?=$zen->ffv($lname)?>" title="<?=hkTip('lname')?>">
  </td>
</tr>    

<tr>
  <td class="bars">
    <?=hkLabel("fname")?>
  </td>
  <td class="bars">
    <input type="text" name="fname" size="20" maxlength="25"
      value="<?=$zen->ffv($fname)?>" title="<?=hkTip('fname')?>">
  </td>
</tr>               
          
<tr>
  <td class="bars">
    <?=hkLabel("initials")?>
  </td>
  <td class="bars">
    <input type="text" name="initials" size="5" maxlength="15"
value="<?=$zen->ffv($initials)?>" title="<?=hkTip('initials')?>">
  </td>
</tr>  
    
<tr>
  <td class="bars">
    <?=hkLabel("jobtitle")?>
  </td>
  <td class="bars">
    <input type="text" name="jobtitle" size="20" maxlength="50"
value="<?=$zen->ffv($jobtitle)?>" title="<?=hkTip('jobtitle')?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=hkLabel("department")?>
  </td>
  <td class="bars">
    <input type="text" name="department" size="20" maxlength="50"
value="<?=$zen->ffv($department)?>" title="<?=hkTip('department')?>">
  </td>
</tr> 


<tr>
  <td class="bars">
    <?=hkLabel("telephone")?>
  </td>
  <td class="bars">
    <input type="text" name="telephone" size="20" maxlength="50"
      value="<?=$zen->ffv($telephone)?>" title="<?=hkTip('telephone')?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=hkLabel("mobiel")?>:
  </td>
  <td class="bars">
    <input type="text" name="mobiel" size="20" maxlength="20"
      value="<?=$zen->ffv($mobiel)?>" title="<?=hkTip('mobiel')?>">
  </td>
</tr>  

<tr>
  <td class="bars">
    <?=hkLabel("email")?>
  </td>
  <td class="bars">
    <input type="text" name="email" size="30" maxlength="50"
value="<?=$zen->ffv($email)?>" title="<?=hkTip('email')?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=hkLabel("inextern")?>
  </td>
  <td class="bars">
      <?if($inextern==extern) {echo "selected";}?>
     <select name="inextern" title="<?=hkTip('inextern')?>">
    <option <?if($inextern==1) {echo "selected";}?> value='1'>External</option>
    <option <?if($inextern==2) {echo "selected";}?> value='2'>Internal</option>
    </select>
  </td>
</tr>   

<tr>
  <td colspan="2" class="headerCell">
    <?=hkLabel("description")?>
  </td>
</tr>
  
<tr>
  <td colspan="2" class="bars">
    <textarea cols="60" rows="5" title="<?=hkTip('description')?>" name="description"><?=$zen->ffv($description)?></textarea>
  </td>
</tr>
<tr>
  <td colspan="2" class="navCell indent" align='right'>
   <? renderDivButtonFind($button); ?>
  </td>
</tr>
</table>
</form>
<script>setFocalPoint('contactForm','company_id')</script>