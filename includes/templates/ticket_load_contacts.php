<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

?>
<table width="600" align="center" cellpadding="2" cellspacing="2">
<tr>     
<td align="right">
     <form action="<?=$rootUrl?>/actions/addToContacts.php" name='contactForm'>
     <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
     <input type="submit"
         value=" <?=tr("Add Contacts")?> " class="actionButton" 
         style="width:125;color:#CCFFCC">  
     </form>
     </td>
   </tr>   
	 <tr>  
     <td class='titleCell'>
       <?=tr("Related Contacts", array($page_type))?>    
     </td>
   </tr>
     
   <tr>
     <td valign="top">
     <form action="<?=$rootUrl?>/actions/dropFromContacts.php" method="post">
     <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
<?
  
   $parms = array(1 => array(1 => "ticket_id", 2 => "=", 3 => $id),);
   $sort = "ticket_id asc";
   
  $tickets = $zen->get_contacts($parms,"ZENTRACK_RELATED_CONTACTS",$sort);


if ($tickets){
?>
<table width='500' border="0">
<tr>
  <td class='subTitle' width='10%' ><?=tr("ID")?></td>	
  <td class='subTitle' align='center'><?=tr("Name")?></td>
  <td class='subTitle' align='center'><?=tr("Telephone")?></td>
  <td class='subTitle' align='center'><?=tr("E-mail")?></td>
  <td class='subTitle' width='5%' align='center'><?=tr("Delete")?></td>
</tr>
<?  
//print_r($tickets);
    foreach($tickets as $n) {
	    
	   if ($n["type"]=="1"){
		   $table = "ZENTRACK_COMPANY";
		   $col = "company_id";
		   $cpid = $n["cp_id"]; 
		   $c1 = "cid" ;
		   $n1 = "title";
		   $n2 = "office";
	   } else {
	   	 $table = "ZENTRACK_EMPLOYEE";
		 	 $col = "person_id";
		   $cpid = $n["cp_id"];
		 	 $c1 = "pid"	;
		 	 $n1 = "lname";
		   $n2 = "fname";
		 }
		 
  	$u=$zen->get_contact($n["cp_id"],$table,$col);
    $cpid = $zen->checkNum($cpid);
    $tc = "onclick='ticketClk(\"$rootUrl/contact.php?$c1=$cpid\")'";
?>	
      <tr class='bars' onMouseOver='mClassX(this, "cell", "hand")' onMouseOut='mClassX(this)'>
      <td <?=$tc?>><?=$zen->ffv($cpid)?></td>
      <td <?=$tc?>><?= $zen->ffv(ucfirst($u[$n1]))." ".$zen->ffv($u[$n2]) ?></td>
      <td <?=$tc?>><?= $zen->ffv($u["telephone"]) ?></td>
      <td <?
        if( !$u['email'] ) { print $tc; }
      ?>><A id='link_<?=$cpid?>' HREF="mailto:<?=$zen->ffv($u['email'])?>"><?=$zen->ffv($u["email"])?></A></td>
      <td onClick='checkMyBox("drops_<?=$zen->ffv($n['clist_id'])?>", event)'><input 
          id='drops_<?=$zen->ffv($n['clist_id'])?>' type='checkbox' name='drops[]' 
          value='<?=$zen->ffv($n['clist_id'])?>'></td>
      </tr>
<?
    }
?>
</table> 
<table width='600'>
<tr>
<td align="right">
         <input type="<?=$zen->ffv($button)?>" 
	  value=" <?=tr("Drop Contacts")?> " 
	  class="actionButton" style="width:125;color:<?=$zen->ffv($color)?>"> 
</td>
</tr>
</table>
</form>
<?
  } else {
	   print "<b>".tr("No related contacts")."</b>";
  }
?>     
  </td>
</tr>
</table>