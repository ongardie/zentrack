<?
/* 
*Show the contacts that are connected to a company
*/

if( is_array($contacts) ) {
   
		$link  = "$rootUrl/contact.php";
   
   foreach($contacts as $t) {      
      ?>
   <br>
      <table cellpadding="0" cellspacing="0" border="0">
  <tr>
   <td class="ticketCell">
   <table align="center" width='570' border="0">     
     <tr>
       <td valign="top"><table border="0"
          width="430" cellpadding="0" cellspacing="1">
          
    <tr>
	   <td class="titleCell" colspan="4"><p align="center"><?=$t["contractnr"]?></p></td>  
	  </tr>
	  <tr>
	   <td class="smallTitleCell" colspan="2" ><?=uptr("Info")?></td>
	   <td class="smallTitleCell"  colspan="2" width="50%"><?=uptr("Dates")?></td>
	  </tr>
	  <tr>
	   <td class="small" width="20%" colspan="2"><p align="center"><?=$t["title"]?></p></td> 
	   <td class="small" width="20%"><?=tr("Start Date")?>:</td> 	   
	   <td class="small" width="30%"><?if($t["stime"]){echo $zen->showDate($t["stime"]);}?></td>
	  </tr>
	  <tr>
	   <td class="small" width="20%"></td> 
	   <td class="small" width="30%"></td>  
	   <td class="small" width="20%"><?=tr("Expiration Date")?>:</td>  
	   <td class="small" width="30%"><?if($t["dtime"]){echo $zen->showDate($t["dtime"]);}?></td>
	  </tr>
	  <tr>
	   <td class="small" width="20%"></td> 
	   <td class="small" width="30%"></td> 
	   <td class="small" width="20%"></td> 
	   <td class="small" width="30%"></td> 
	  </tr>
<?
 if(!empty($t["description"])) {
?>	  
	  <tr>
	   <td class="smallTitleCell" colspan="4"><?=uptr("Description")?></td>  
	  </tr>
	  <tr>
	   <td class="small" colspan="4"><?=(get_magic_quotes_runtime())?nl2br(stripslashes($t["description"])):nl2br($t["description"]); ?></td>
	  </tr>
<?
}
//set default id
$agree_id = $t["agree_id"];
//set active
$status = $t["status"];

//show items
$parms = array(1 => array(1 => "agree_id", 2 => "=", 3 => $agree_id),
);
$sort = "item_id asc";

$items = $zen->get_contacts($parms,"ZENTRACK_AGREEMENT_ITEM",$sort);
?>
<tr>
	   <td class="smallTitleCell" colspan="4"><?=uptr("Items")?></td> 
</tr> 
<tr><td colspan="4"> 
<table>
	   <?
	     if (is_array($items)) {

		
	 			 foreach($items as $t) {      
      		?>
   					<tr  class='priority1'>
   					<td><?=$t["item_id"]?></td>
   					<td height="25" width="50%" align="middle">
    				<?=strtoupper($t["name1"])?>
   					</td>
   					<td height="25" width="50%" align="middle" >
   					<?=strtolower($t["description1"])?>
   					</td>
   					</tr>   
   				<?   
   				} 
   		
  		} else {
	 				echo "<tr><td colspan='4'>No items are set</td></tr>" ;
  		}?>
</table>
</td</tr>  	
<?//end items
?>
	 </table>
	 
	 </td>
   <td valign="top" width='75'>
       
<table width="120" cellpadding="0" cellspacing="0" border="0">
<?
			print "<tr>\n<form name='edit_form' action='$rootUrl/actions/agreement_edit.php'>\n";
			print "<td>\n";
			print "<input type='submit' class='actionButtonContact' value='EDIT'>\n";
			print "<input type='hidden' name='id' value='$agree_id'>\n";
			print "</td>\n</form>\n</tr>\n";
			
			if ($status=="1") {
				$active = "0";
				$value = "TO ARCHIVE";
			} else {
				$active = "1";
				$value = "MAKE ACTIVE";
			}
			
			print "<tr>\n<form name='archief_form' action='$rootUrl/actions/agreement_archive.php'>\n";
			print "<td>\n";
			print "<input type='submit' class='actionButtonContact'  value='$value'";
			print " onClick='return confirm(\"Are you sure you want to archive this agreement\")'";
			print ">\n";
			print "<input type='hidden' name='id' value='$agree_id'>\n";
			print "<input type='hidden' name='active' value='$active'>\n";
			print "</td>\n</form>\n</tr>\n";

			
  		print "<tr>\n<form name='delete_form' action='$rootUrl/actions/agreement_delete.php'>\n";
			print "<td>\n";
			print "<input type='submit' class='actionButtonContact'  value='DELETE'";
			print " onClick='return confirm(\"Are you sure you want to permanently delete this contact\")'";
			print ">\n";
			print "<input type='hidden' name='id' value='$agree_id'>\n";
			print "</td>\n</form>\n</tr>\n";
?>
</table>
     </td>
     </tr>
    </table>
    </td>
  </tr>
</table>
   <?
   
   }      
     
   
} else {
  
    print "<p>&nbsp;</p><ul><b>".tr('No contacts in this section.').".</b></ul>";
} 
?>