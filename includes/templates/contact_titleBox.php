<table cellpadding="0" cellspacing="0">
  <tr>
   <td class="ticketCell"><table 
     align="center" width='570'>     
     <tr>
       <td valign="top"><table border="0"
          width="440" cellpadding="2" cellspacing="1">
          
    <tr>
	   <td class="titleCell" colspan="3"><p align="center"><? echo strtoupper($title)." "; if(!empty($office)){ echo stripslashes($office);}?> </p></td>  
	  </tr>
	  <tr>
	   <td class="smallTitleCell" colspan="2" width="50%"><?=uptr("Info")?></td>
	   <td class="smallTitleCell"  width="50%"><?=uptr("Address")?></td>
	  </tr>
	  <tr>
	   <td class="small" colspan="2">
	   <? 
	   if(!empty($office)){ echo stripslashes($office)."<br>";}
	   if(!empty($email)){?><A HREF="mailto:<?=stripslashes($email)?>"><?=stripslashes($email)?></A><br><?}
	   if ($website == "http://" or $website == "") {
		 echo "<br>";  
		 } else {
	   if(!empty($website)){?><A TARGET="_blank" HREF="<?=stripslashes($website)?>"><?=stripslashes($website)?></A><?}}?>
	   </td>
	   <td class="small" rowspan="4">
	   <?
	   if(!empty($address1)){ echo stripslashes($address1)."<br>";}
	   if(!empty($address2)){ echo stripslashes($address2)."<br>";}
	   if(!empty($address3)){ echo stripslashes($address3)."<br>";}
	   if(!empty($postcode)){ echo stripslashes($postcode)."<br>";}
	   if(!empty($place)){ echo stripslashes($place)."<br>";}
	   if(!empty($pobox)){ echo stripslashes($pobox)."<br>";}
	   if(!empty($postcode2)){ echo stripslashes($postcode2)."<br>";}
	   if(!empty($country)){ echo stripslashes($country);}
	   ?>
	   </td>
	  </tr>
	  <tr>
	   <td class="smallTitleCell" colspan="2"><?=uptr("Numbers")?></td> 
	   <td class="small"></td>
	  </tr>
	  <tr>
	   <td class="small" width="100"><?=tr("Telephone no")?>:</td>  
	   <td class="small"><?=stripslashes($telephone)?></td>
	   <td class="small"></td>
	  </tr>
	  <tr>
	   <td class="small"><?=tr("Fax no")?>:</td> 
	   <td class="small"><?=stripslashes($fax)?></td> 
	   <td class="small"></td>
	  </tr>
	  <?
 if(!empty($description)) {
?>	  
	  <tr>
	   <td class="smallTitleCell" colspan="3"><?=uptr("Commentary")?></td>  
	  </tr>
	  <tr>
	   <td class="small" colspan="3"><?=(get_magic_quotes_runtime())?nl2br(stripslashes($description)):nl2br($description); ?></td>
	  </tr>
<?
}
?>
	 </table></td>
       <td valign="top" width='75'>
       
<table width="120" cellpadding="0" cellspacing="0" border="0">
<?
			
	//1=show ADD 0=don't show ADD
      
      $actions = array(
			"edit"  => 0,			
			"delete"  => 0,		     
			"employee"  => 1,
			"agreement"    => 1,
			);	
	//show the buttons
	foreach($actions as $a=>$v) {
		$value=($v==1)?"ADD ".uptr(ucfirst($a)):uptr(ucfirst($a));
		
			print "<tr>\n<form name='".$a."_form' action='$rootUrl/actions/contact_$a.php'>\n";
			print "<td>\n";
			print "<input type='submit' class='actionButtonContact' value='$value'"; 
			if ($a=="delete") {print " onClick='return confirm(\"Are you sure you want to permanently delete this contact\")'";}
			print ">\n";
			print "<input type='hidden' name='cid' value='$id'>\n";
			print "</td>\n</form>\n</tr>\n";
  }
  //button to show open tickets
  		print "<tr>\n<form name='tickets_form' action='$rootUrl/contact.php'>\n<td>\n";
			print "<input type='submit' class='actionButtonContact' value='VIEW TICKETS'>\n"; 
			print "<input type='hidden' name='cid' value='$id'>\n";
			print "<input type='hidden' name='overview' value='tickets'>\n";
			print "</td>\n</form>\n</tr>\n";
  
  //button to show the contacts or agreements
  if (empty($overview)&&!isset($pid)) $overview = "contact";
  
  if ($overview=="contact") {
  	  print "<tr>\n<form name='contact_form' action='$rootUrl/contact.php'>\n<td>\n";
			print "<input type='submit' class='actionButtonContact' value='VIEW AGREEMENTS'>\n"; 
			print "<input type='hidden' name='cid' value='$id'>\n";
			print "<input type='hidden' name='overview' value='agreement'>\n";
			print "</td>\n</form>\n</tr>\n";
	} else {
			print "<tr>\n<form name='agreement_form' action='$rootUrl/contact.php'>\n<td>\n";
			print "<input type='submit' class='actionButtonContact' value='VIEW CONTACTS'>\n"; 
			print "<input type='hidden' name='cid' value='$id'>\n";
			print "<input type='hidden' name='overview' value='contact'>\n";
			print "</td>\n</form>\n</tr>\n";
	}

       
?>
</table>
     </td>
     </tr>
    </table></td>
  </tr>
</table>

