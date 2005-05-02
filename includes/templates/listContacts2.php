<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

/*
*Person bar to show some info
*/

if( is_array($tickets) ) {
      ?>
        <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>'>
      <?   
    //show title bar  
    if ($setmode=="all"){
	    ?>
		<td width="32" height="25" valign="middle" title="<?=tr("ID of the contact")?>" class="titleCell" >
		<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span><?=tr("ID")?></span></b></span></div>
		</td>

		<td height="25" valign="middle" title="<?=tr("The name of the contact")?>" class="titleCell">
		<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span><?=tr("Name")?></span></b></span></div>
		</td>
		<?if ($overview=="extern") { ?>
		<td height="25" valign="middle" title="<?=tr("The company of the contact")?>" class="titleCell">
		<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span><?=tr("Company")?></span></b></span></div>
		</td>
		<?}?>
		<td height="25" valign="middle" title="<?=tr("The e-mail of the contact")?>" class="titleCell">
		<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span><?=tr("E-mail")?></span></b></span></div>
		</td>

		<td height="25" valign="middle" title="<?=tr("The telephone of the contact")?>" class="titleCell">
		<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span><?=tr("Telephone Nr.")?></span></b></span></div>
		</td>
	    <?
    }
    //show the results             
		$link  = "$rootUrl/contact.php";
   	$td_ttl = "title='".tr("Click here to view the Contact")."'";   
   	
   foreach($tickets as $t) {    

      ?>
   <tr  class='priority1' onclick='ticketClk("<?=$link?>?pid=<?=$t["person_id"]?>")' onMouseOver='mClassX(this, "priority1Over", true)' onMouseOut='mClassX(this, "priority1", false)'>
   <td height="25" width="5%" valign="middle" <?=$td_ttl?>>
    <?=$t["person_id"]?>
   </td>
   <td height="25" width="25%" valign="middle" <?=$td_ttl?>>
    <?=ucfirst($t["lname"])?>&nbsp;<?=($t["fname"])?",".ucfirst($t["fname"]):",".ucfirst($t["initials"])?>
   </td>
   <?if ($overview=="extern") { ?>
   <td height="25" width="25%" valign="middle" <?=$td_ttl?>><?
   	 if ( isset($t["company_id"])&& $t["company_id"]>"0") {
	 $contact = $zen->get_contact($t["company_id"],"ZENTRACK_COMPANY","company_id");
	  if( is_array($contact) ) {
      echo strtoupper($contact['title']);
      if ($contact['title']){
	      echo " " .strtolower($contact['office']);
      }
    }	  
  }
}
   ?>
   </td>
   <td height="25" width="25%" valign="middle" <?=$td_ttl?>>
   <?=$t["email"]?>
   </td>
   <td width="20%" valign="middle" <?=$td_ttl?>>
   <?=strtolower($t["telephone"])?>
   </td>
   </tr>       
   <?
   }      
   $contact= NULL;  
   print "</table>\n";
   
} else {
  
    print "<p>&nbsp;</p><ul><b>".tr('No contacts in this section.').".</b></ul>";
}
  
?>
