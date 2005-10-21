<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

$hotkeys->loadSection('tab_contacts');
$GLOBALS['zt_hotkeys'] = $hotkeys;

?>
<table width="600" cellpadding="0" class='formtable' cellspacing="1">
	 <tr>  
     <td colspan='5' class='subTitle indent' width='100%'>
       <?=tr("Related Contacts", array($page_type))?>    
     </td>
   </tr>
<?
  
   $parms = array(array("ticket_id", "=", $id));
   $sort = "ticket_id asc";
   
  $tickets = $zen->get_contacts($parms,"ZENTRACK_RELATED_CONTACTS",$sort);


if ($tickets){
?>
 <form name='dropContactsForm' action="<?=$rootUrl?>/actions/dropFromContacts.php" method="post">
 <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
 <input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>
 <tr>
  <td class='headerCell'><?=tr("ID")?></td>	
  <td class='headerCell' width='50%'><?=tr("Name")?></td>
  <td class='headerCell'><?=tr("Telephone")?></td>
  <td class='headerCell'><?=tr("E-mail")?></td>
  <td class='headerCell'><?=tr("Delete")?></td>
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
		 	 $c1 = "pid";
		 	 $n1 = "lname";
		   $n2 = "fname";
		 }
		 
  	$u=$zen->get_contact($n["cp_id"],$table,$col);
    $cpid = $zen->checkNum($cpid);
    $tc = "onclick='checkMyBox(\"drops_".$zen->ffv($n['clist_id'])."\", event)' ";
    $img = "<div style='float:right'><a href='#' onclick='ticketClk(\"$rootUrl/contact.php?$c1=$cpid\",this,event);return false;'>";
    $img .= "<img src='$imageUrl/24x24/magnify.png' border='0' width='24' height='24'></a></div>";
?>	
    <tr class='bars' <?=$row_rollover_eff?>>
    <td <?=$tc?>><?=$zen->ffv($cpid)?></td>
    <td <?=$tc?>><?= $img." ".$zen->ffv(ucfirst($u[$n1]))." ".$zen->ffv($u[$n2]) ?></td>
    <td <?=$tc?>><?= $u['telephone']? $zen->ffv($u["telephone"]) : '&nbsp;' ?></td>
    <td <?=$tc?>><?
      if( $email ) {
      ?><A id='link_<?=$cpid?>' HREF="mailto:<?=$zen->ffv($u['email'])?>"><?=$zen->ffv($u["email"])?></A>
      <? } else { ?>&nbsp;<? } ?></td>
    <td <?=$tc?>><input 
        id='drops_<?=$zen->ffv($n['clist_id'])?>' type='checkbox' name='drops[]' 
        value='<?=$zen->ffv($n['clist_id'])?>'></td>
    </tr>
<?
    }
?>
<tr>
<td class='subTitle' colspan='5'>
  </div>
  <div style='float:right'>
  <? renderDivButton($hotkeys->find('Drop Contacts'), "window.document.forms['dropContactsForm'].submit()"); ?>
  </div>
</form>
  <div style='float:left'>
  <form action="<?=$rootUrl?>/actions/addToContacts.php" name='ContactsAddForm'>
  <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
  <? renderDivButton($hotkeys->find('Add Contact'), "window.document.forms['ContactsAddForm'].submit()"); ?>
  <input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>
  </form>
</td>
</tr>
<? } else { ?>
<tr><td valign='top' colspan='5' class='bars'>
<b><?=tr("No contacts found")?></b>
</td></tr>
<tr>
<td colspan='5' class='subTitle'>
  <form action="<?=$rootUrl?>/actions/addToContacts.php" name='ContactsAddForm'>
  <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
  <? renderDivButton($hotkeys->find('Add Contact'), "window.document.forms['ContactsAddForm'].submit()"); ?>
  <input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>
  </form>
</td>
</tr>
<? } ?>     
</table>
<p>&nbsp;
<form action='<?=$rootUrl?>/newContact.php' target="_BLANK" name='newContactForm'>
  <input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>
  <? renderDivButton($hotkeys->find('Create New Contact'), "window.document.forms['newContactForm'].submit()", 150); ?>
</form>
