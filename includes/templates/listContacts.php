<?
/*
*Company bar to show some info
*/
echo $user_id;
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

<td height="25" valign="middle" title="<?=tr("The title of the contact")?>" class="titleCell">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span><?=tr("Title")?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The email of the contact")?>" class="titleCell">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span><?=tr("E-mail")?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The telephone of the contact")?>" class="titleCell">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span><?=tr("Telephone Nr.")?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The website of the contact")?>" class="titleCell">
<div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span><?=tr("Website")?></span></b></span></div>
</td>
	    <?
    }
           
		$link  = "$rootUrl/contact.php";
   	$td_ttl = "title='".tr("Click here to view the Contact")."'";
   
   foreach($tickets as $t) {      
      ?>
   <tr  class='bars' onclick='ticketClk("<?=$link?>?cid=<?=$t['company_id']?>")' onMouseOver='mClassX(this, "cell", "hand")' onMouseOut='mClassX(this, "bars")'>
   <td height="25" width="5%" valign="middle" <?=$td_ttl?>>
    <?=$t["company_id"]?>
   </td>
   <td height="25" width="25%" valign="middle" <?=$td_ttl?>>
    <?=strtoupper($t["title"])?>&nbsp;<?=strtolower($t["office"])?>
   </td>
   <td height="25" width="25%" valign="middle" <?=$td_ttl?>>
   <?=strtolower($t["email"])?>
   </td>
   <td height="25" width="15%" valign="middle" <?=$td_ttl?>>
   <?=$t["telephone"]?>
   </td>
   <td  width="30%" valign="middle" <?=$td_ttl?>>
   <?=strtolower($t["website"])?>
   </td>
   </tr>       
   <?
   }      
     
   print "</table>\n";
   
} else {
  
    print "<p>&nbsp;</p><ul><b>".tr('No contacts in this section.').".</b></ul>";
}
  
?>
