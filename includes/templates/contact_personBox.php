<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

/* 
*Show the contacts that are connected to a company
*/
?>
   <table cellpadding="0" cellspacing="0">
  <tr>
   <td class="ticketCell">
   <table align="center" width='570'>     
     <tr>
       <td valign="top"><table border="0" width="430" cellpadding="0" cellspacing="1">      
    <tr>
	   <td class="titleCell" colspan="4"><p align="center"><?= ucfirst($lname).", "; echo($fname)? ucfirst($fname):ucfirst($initials);?> </p></td>  
	  </tr>
	  <tr>
	   <td class="smallTitleCell" colspan="2" ><?=uptr("Info")?></td>
	   <td class="smallTitleCell"  colspan="2" width="50%"><?=uptr("Numbers")?></td>
	  </tr>
	  <tr>
	   <td class="small" width="20%"><?=tr("Jobtitle")?>:</td> 
	   <td class="small" width="30%"><?=$jobtitle?></td>
	   <td class="small" width="20%"><?=tr("Telephone no")?>:</td> 	   
	   <td class="small" width="30%"><?=stripslashes($telephone)?></td>
	  </tr>
	  <tr>
	   <td class="small" width="20%"><?=tr("Department")?>:</td> 
	   <td class="small" width="30%"><?=$t["department"]?></td>  
	   <td class="small" width="20%"><?=tr("Mobile no")?>:</td>  
	   <td class="small" width="30%"><?=stripslashes($mobiel)?></td>
	  </tr>
	  <tr>
	   <td class="small" width="20%"><?=tr("E-mail")?>:</td> 
	   <td class="small" width="30%"><?if(!empty($email)){?><A HREF="mailto:<?=stripslashes($email)?>"><?=stripslashes($email)?></A><? }?></td> 
	   <td class="small" width="20%"></td> 
	   <td class="small" width="30%"></td> 
	  </tr>
<?
 if(!empty($description)) {
	 
?>	  
	  <tr>
	   <td class="smallTitleCell" colspan="4"><?=uptr("Commentary")?></td>  
	  </tr>
	  <tr>
	   <td class="small" colspan="4"><?= 
   (get_magic_quotes_runtime())?nl2br(stripslashes($description)):nl2br($description); 
    ?></td>
	  </tr>
<?
}
?>
	 </table>
	 
	 </td>
   <td valign="top" width='75'>
       
<table width="120" cellpadding="0" cellspacing="0" border="0">
<?
			//1=show ADD 0=don't show ADD
      $idi = $person_id ;
			
			print "<tr>\n<form name='edit_form' action='$rootUrl/actions/contact_edit.php'>\n";
			print "<td>\n";
			print "<input type='submit' class='actionButtonContact' $style value='EDIT'>\n";
			print "<input type='hidden' name='pid' value='$idi'>\n";	
			print "</td>\n</form>\n</tr>\n";

  		print "<tr>\n<form name='delete_form' action='$rootUrl/actions/contact_delete.php'>\n";
			print "<td>\n";
			print "<input type='submit' class='actionButtonContact' $style value='DELETE'"; 
			print " onClick='return confirm(\"Are you sure you want to permanently delete this contact\")'";
			print ">\n";
			print "<input type='hidden' name='pid' value='$idi'>\n";		
			print "</td>\n</form>\n</tr>\n";
      
			if(!$company_id) {
			print "<tr>\n<form name='edit_form' action='$rootUrl/contact.php'>\n";
			print "<td>\n";
			print "<input type='submit' class='actionButtonContact' $style value='VIEW TICKETS'>\n";
			print "<input type='hidden' name='pid' value='$idi'>\n";
			print "<input type='hidden' name='overview' value='tickets'>\n";	
			print "</td>\n</form>\n</tr>\n";
		}
?>
</table>
     </td>
     </tr>
    </table></td>
  </tr>
</table>
<br>
<?
if($company_id) {
  $contacts = $zen->get_contact($company_id,"ZENTRACK_COMPANY","company_id");
  if( is_array($contacts) ) {
      extract($contacts);
      $id = $company_id;
      include("$templateDir/contact_titleBox.php");
    }
		
}
?>