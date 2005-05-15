<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<script language='javascript' type='text/javascript'>
  function checkMyBox(fieldName, event) {
    if( !event ) { event = window.event; }
    if( document.getElementById ) {
      var elem = document.getElementById(fieldName);
      if( elem ) {
        if( !event || !event.target || event.target.type != 'checkbox' ) {
          elem.checked = elem.checked? false : true;
        }
      }
      if( elem.parentNode ) {
        elem.parentNode.parentNode.oldStyle = elem.checked? 'invalidCell' : 'cell';
      }
    }
  }
</script>

<form method="post" name="agreementForm" action="<?=($skip)? "editAgreementSubmit.php" : "$rootUrl/addAgreementSubmit.php"?>">
<input type="hidden" name="id" value="<?=$zen->ffv($id)?>">
<input type='hidden' name='TODO' value='submit_form'>
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
    <?=tr("Agreement ID")?>:
  </td>
  <td class="bars">
    <input type="text" name="contractnr" size="20" maxlength="25"
      value="<?=$zen->ffv($contractnr)?>">
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
value="<?=$zen->ffv($title)?>">
  </td>
</tr>

<tr>
  <td class="bars" >
    <?=tr("Start Date")?>:
  </td>
  <td class="bars">
    <input type="text" name="stime" size="12" maxlength="10"
value="<?=($stime)?$zen->showDate($zen->ffv($stime)):""?>">
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
value="<?=($dtime)?$zen->showDate($dtime):""?>">
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
	    $zen->ffv($description)
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

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Items")?>
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
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
	$contacts = $zen->get_contacts($parms,"ZENTRACK_AGREEMENT_ITEM",$sort);

  if (is_array($contacts)) {
	 //print_r($contacts);

	 foreach($contacts as $t) {
      ?>
   <tr class='cell'
       onmouseover='mClassX(this, "altCellInv", "hand")'
       onmouseout='mClassX(this)'
       onclick='checkMyBox("drops_<?=$t['item_id']?>", event)'>
   <td height="25" width="20" valign="middle">
    <?=$t["item_id"]?>
   </td>
   <td height="25" width="200" valign="middle">
    <?=$zen->ffv($t["name1"])?>
   </td>
   <td height="25"  width="400" valign="middle">
   <pre><?=$zen->ffv($t["description1"])?></pre>
   </td>
   <td><input id='drops_<?=$t['item_id']?>'
          type='checkbox' name='drops[]'
          value='<?=$zen->ffv($t['item_id'])?>'></td>
   </tr>
   <?
   } ?>
   <tr>
	<td colspan="2">
         <input type="submit"
	  value=" <?=tr("Drop Items")?> "
          class="actionButton"
          onClick='return rerouteAgreementForm("removeItems")'
         >
	</td>
	</tr>
	<?
  } else {
	 echo "No items are set" ;
  }

  ?>

   </table>
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Add Item")?>
  </td>
</tr>
<tr>
<td class="bars" colspan="2">
	<?=tr("Name")?>:
    <input type="text" name="name1" size="30" maxlength="40" value="<?=$zen->ffv($name1)?>">

	<?=tr("Description")?>:
    <textarea cols="22" rows="2" name="description1"><?=$zen->ffv($description1)?></textarea>

	</td>
</tr>
<tr>
<td>
<input type="submit" value=" <?=tr("Add Item")?> "
   onClick='return rerouteAgreementForm("addItems")'
   class="actionButton">
</td>
</tr>
</form>

</table>

<script language='javascript'>
  function rerouteAgreementForm( action ) {
    document.agreementForm.action = '<?=$_SERVER['PHP_SELF'];?>';
    document.agreementForm.TODO.value = action;
    return true;
  }
</script>
