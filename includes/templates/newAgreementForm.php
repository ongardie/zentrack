<form method="post" name="agreementForm" action="<?=($skip)? "editAgreementSubmit.php" : "$rootUrl/addAgreementSubmit.php"?>">
<input type="hidden" name="id" value="<?=strip_tags($id)?>">
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
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>" border="0">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     <?=tr("Agreement Information")?>
  </td>
</tr>
  
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Global")?>
  </td>
</tr>
  

<tr>
  <td class="bars" >
    <?=tr("Contract nr:")?>:
  </td>
  <td class="bars">
    <input type="text" name="contractnr" size="20" maxlength="25"
      value="<?=strip_tags($contractnr)?>">
  </td>
</tr>  
<?
$company = $zen->get_contact_all();
	if (is_array($company)) {
	?>
		<tr>
  	<td class="bars" >
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
 ?>   
<tr>
  <td class="bars" >
    <?=tr("Title")?>:
  </td>
  <td class="bars">
    <input type="text" name="title" size="30" maxlength="50"
value="<?=strip_tags($title)?>">
  </td>
</tr>          

<tr>
  <td class="bars" >
    <?=tr("Start Date")?>:
  </td>
  <td class="bars">
    <input type="text" name="stime" size="12" maxlength="10"
value="<?=($stime)?$zen->showDate(strip_tags($stime)):""?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
  onClick="popUpCalendar(this,document.agreementForm.stime, '<?=$zen->popupDateFormat()?>')"
  alt="Select a Date">
    &nbsp;(<?=tr("optional")?>)
  </td>
</tr>

<tr>
  <td class="bars" >
    <?=tr("Expiration Date")?>:
  </td>
  <td class="bars">
    <input type="text" name="dtime" size="12" maxlength="10"
value="<?=($dtime)?$zen->showDate(strip_tags($dtime)):""?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
  onClick="popUpCalendar(this,document.agreementForm.dtime, '<?=$zen->popupDateFormat()?>')"
  alt="Select a Date">
    &nbsp;(<?=tr("optional")?>)
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
    <?=tr("Description")?>:
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
  <?=tr("Click button to")?> <?=($td)? tr("save your changes"):tr("create your agreement")?>.
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value=" <?=($skip)?"Save":"Create"?> " class="submit">
   <br>
  </td>
</tr>
</form>

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Items")?>
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="hidden" name="id" value="<?=$id?>">
  <input type="hidden" name="test" value="test1">
  <table>
  <?
  if (!$id){
	  $parms = array(1 => array(1 => "agree_id", 2 => "=", 3 => "0")
		);
  } else {
	  $parms = array(1 => array(1 => "agree_id", 2 => "=", 3 => $id)
		);
  }
  
	$sort = "item_id asc";
	
	
	

	$tickets = $zen->get_contacts($parms,"ZENTRACK_AGREEMENT_ITEM",$sort);

  if (is_array($tickets)) {
	 //print_r($tickets); 
	
	 foreach($tickets as $t) {      
      ?>
   <tr  class='priority1' >
   <td height="25" width="20" valign="middle">
    <?=$t["item_id"]?>
   </td>
   <td height="25" width="200" valign="middle">
    <?=ucfirst($t["name1"])?>
   </td>
   <td height="25"  width="400" valign="middle">
   <?=ucfirst($t["description1"])?>
   </td>
   <td class='bars'><input type='checkbox' name='drops[]' value='<?=$t['item_id']?>'></td>
   </tr>   
   <?   
   } ?>
   <tr>
	<td colspan="2">
         <input type="submit" 
	  value=" <?=tr("Drop Items")?> " class="actionButton" style="width:125;color:#CCFFCC"> 
	</td>
	</tr>
	<?
  } else {
	 echo "No items are set" ;
  }
  
  ?>
 
   </table>
  </td>
  </form>
</tr>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<input type="hidden" name="id" value="<?=strip_tags($id)?>">
<input type="hidden" name="test" value="test">
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Add Item")?>
  </td>
</tr>
<tr>
<td class="bars" colspan="2">
	<?=tr("Name")?>:
    <input type="text" name="name1" size="30" maxlength="40" value="<?=strip_tags($name1)?>">

	<?=tr("Description")?>:
    <textarea cols="22" rows="2" name="description1"><?=stripslashes($description1)?></textarea>

	</td>
</tr>
<tr>
<td>
<input type="submit" value=" <?=tr("Add Item")?> " class="actionButton" style="width:125;color:#CCFFCC"> 
</td>
</tr>
</form>

</table>