	<?
	$sort = "dtime asc";
	$parms = array(1 => array(1 => "status", 2 => "=", 3 => "1")
);

	$tickets = $zen->get_contacts($parms,"ZENTRACK_AGREEMENT",$sort);
	
	
if( is_array($tickets) && count($tickets) ) {
 
   ?>
<table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>' border="0">
<tr bgcolor="<?=$zen->settings["color_title_background"]?>" >

<td width="32" height="25" valign="middle" title="<?=tr("ID of the agreement")?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("ID")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The nr of the agreement")?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Nr")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The title of the agreement")?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Title")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The company of the agreement")?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Company")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The expiration date of the agreement")?>">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=tr("Expiration Date")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

</tr>
<?      
$link  = "$rootUrl/agreement.php";
$td_ttl = "title='".tr("Click here to view the Agreement")."'";
   	
   foreach($tickets as $t) {    

      ?>
   <tr  class='priority6' onclick='ticketClk("<?=$link?>?id=<?=$t["agree_id"]?>")' onMouseOver='mClassX(this, "priority6Over", true)' onMouseOut='mClassX(this, "priority6", false)'>
   <td height="25" width="5%" valign="middle" <?=$td_ttl?>>
    <?=$t["agree_id"]?>
   </td>
   <td height="25" width="25%" valign="middle" <?=$td_ttl?>>
    <?=$t["contractnr"]?>
   </td>
   <td height="25" width="35%" valign="middle" <?=$td_ttl?>>
   <?=$t["title"]?>
   </td>
      <td height="25" width="25%" valign="middle" <?=$td_ttl?>><?
   	 if ( !empty($t["company_id"])) {
	 $contact = $zen->get_contact($t["company_id"],"ZENTRACK_COMPANY","company_id");
	  if( is_array($contact) ) {
      echo strtoupper($contact['title']);
      if ($contact['title']){
	      echo " " .strtolower($contact['office']);
      }
    }	  
  }
   ?>
   </td>
   <td width="20%" valign="middle" <?=$td_ttl?>>
   <?=($t["dtime"])?$zen->showDate($t["dtime"]):"n/a";?>
   </td>
   </tr>       
   <?
   } 
  
?>
</table>
<?
}