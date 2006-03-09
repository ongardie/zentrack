<? if( !ZT_DEFINED ) { die("Illegal Access"); } 
  $button = $skip? "Update" : "Create";
  
  // prepare hot keys
  $fields = array(
    "title"       => "Title",
    "office"      => "Office",
    "address1"    => "Address Line 1",
    "address2"    => "Address Line 2",
    "address3"    => "Address Line 3",
    "pobox"       => "P.O. Box",
    "postcode"    => "Postal Code(Zip)",
    "postcode2"   => "Location",
    "country"     => "Country",
    "place"       => "County / State",
    "telephone"   => "Telephone No.",
    "fax"         => "Fax No.",
    "email"       => "Email",
    "website"     => "Website",
    "description" => "Description"
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

<form method="post" name="contactForm" action="<?=($skip)? "editContactSubmit.php" : "$rootUrl/addContactSubmit.php"?>">
<input type="hidden" name="id" value="<?=$zen->ffv($id)?>">
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
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->getSetting("color_background")?>">
<tr>
  <td colspan="2" width="640" class="subTitle" align="center">
     <?=tr("Contact Information")?>
  </td>
</tr>
  
<tr>
  <td colspan="2" class="headerCell">
    <?=tr("Details")?>
  </td>
</tr>
  

<tr>
  <td class="bars">
    <?=hkLabel("title")?>:
  </td>
  <td class="bars">
    <input type="text" name="title" size="20" maxlength="50"
      value="<?=$zen->ffv($title)?>" title="<?=hkTip("title")?>">
  </td>
</tr>            
    
<tr>
  <td class="bars">
    <?=hkLabel("office")?>
  </td>
  <td class="bars">
    <input type="text" name="office" size="20" maxlength="50"
value="<?=$zen->ffv($office)?>" title="<?=hkTip("office")?>">
  </td>
</tr>          
    
<tr>
  <td class="bars">
    <?=hkLabel("address1")?>
  </td>
  <td class="bars">
    <input type="text" name="address1" size="30" maxlength="50"
      value="<?=$zen->ffv($address1)?>" title="<?=hkTip("address1")?>">
  </td>
</tr>  
    
<tr>
  <td class="bars">
    <?=hkLabel("address2")?>
  </td>
  <td class="bars">
    <input type="text" name="address2" size="30" maxlength="50"
      value="<?=$zen->ffv($address2)?>" title="<?=hkTip("address2")?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=hkLabel("address3")?>
  </td>
  <td class="bars">
    <input type="text" name="address3" size="30" maxlength="50"
      value="<?=$zen->ffv($address3)?>" title="<?=hkTip("address3")?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=hkLabel("pobox")?>
  </td>
  <td class="bars">
    <input type="text" name="pobox" size="20" maxlength="50"
value="<?=$zen->ffv($pobox)?>" title="<?=hkTip("pobox")?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=hkLabel("postcode")?>
  </td>
  <td class="bars">
    <input type="text" name="postcode" size="20" maxlength="50"
value="<?=$zen->ffv($postcode)?>" title="<?=hkTip("postcode")?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=hkLabel("postcode2")?>
  </td>
  <td class="bars">
    <input type="text" name="postcode2" size="20" maxlength="50"
      value="<?=$zen->ffv($postcode2)?>" title="<?=hkTip("postcode2")?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=hkLabel("country")?>
  </td>
  <td class="bars">
    <input type="text" name="country" size="20" maxlength="50"
      value="<?=$zen->ffv($country)?>" title="<?=hkTip("country")?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=hkLabel("place")?>
  </td>
  <td class="bars">
    <input type="text" name="place" size="20" maxlength="50"
      value="<?=$zen->ffv($place)?>" title="<?=hkTip("place")?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=hkLabel("telephone")?>
  </td>
  <td class="bars">
    <input type="text" name="telephone" size="20" maxlength="20"
      value="<?=$zen->ffv($telephone)?>" title="<?=hkTip("telephone")?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=hkLabel("fax")?>
  </td>
  <td class="bars">
    <input type="text" name="fax" size="20" maxlength="50"
      value="<?=$zen->ffv($fax)?>" title="<?=hkTip("fax")?>">
  </td>
</tr>  

<tr>
  <td class="bars">
    <?=hkLabel("email")?>
  </td>
  <td class="bars">
    <input type="text" name="email" size="20" maxlength="50"
      value="<?=$zen->ffv($email)?>" title="<?=hkTip("email")?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=hkLabel("website")?>
  </td>
  <td class="bars">
    <input type="text" name="website" size="20" maxlength="50"
      value="<?=($website)?$zen->ffv($website):"http://"?>" title="<?=hkTip("website")?>">
  </td>
</tr>   

<tr>
  <td colspan="2" class="bars">
    <?=hkLabel("description")?>
  </td>
</tr>
  
<tr>
  <td colspan="2" class="bars">
    <textarea cols="60" rows="5" title="<?=hkTip("description")?>" name="description"><?= $zen->ffv($description) ?></textarea>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle indent">
   <? renderDivButtonFind($button); ?>
  </td>
</tr>
</table>
</form>
<script>setFocalPoint('contactForm','title')</script>