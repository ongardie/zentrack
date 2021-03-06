<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

$hotkeys->loadSection('tab_contacts');
$parms = array(array("ticket_id", "=", $id));
$sort = "ticket_id asc";

$list = $zen->get_contacts($parms,"ZENTRACK_RELATED_CONTACTS",$sort);
$editable = $zen->actionApplicable($id, 'contacts', $login_id) &&
   $zen->checkAccess($login_id, $ticket['bin_id'], 'level_contacts');

$colspan = $editable? 5 : 4;
?>
<table width="600" cellpadding="0" class='formtable' cellspacing="1">
	 <tr>  
     <td colspan='<?=$colspan?>' class='subTitle indent' width='100%'>
       <?=tr("Related Contacts", array($page_type))?>    
     </td>
   </tr>
<?

if ($list){
?>
 <form name='dropContactsForm' action="<?=$rootUrl?>/actions/dropFromContacts.php" method="post">
 <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
 <input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>
 <tr>
  <td class='headerCell'><?=tr("ID")?></td>	
  <td class='headerCell' width='50%'><?=tr("Name")?></td>
  <td class='headerCell'><?=tr("Telephone")?></td>
  <td class='headerCell'><?=tr("E-mail")?></td>
  <? if( $editable ) { ?>
  <td class='headerCell'><?=tr("Delete")?></td>
  <? } ?>
 </tr>
<?  
//print_r($contacts);
  $contacts = array();
  for($i=0; $i<count($list); $i++) {
    $n = $list[$i];
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
    $u = $zen->get_contact($n["cp_id"],$table,$col);
    $u['clist_id'] = $n['clist_id'];
    $u['label'] = $u[$n1].", ".$u[$n2];
    $contacts[] = $u;
  }
  
  $contacts = $hotkeys->activateList($contacts, 'label', 'label', "checkMyRow(\"drops_{clist_id}\", false)");
    
  foreach($contacts as $n) {
    $cpid = $zen->checkNum($cpid);
    $tc = "onclick='checkMyBox(\"drops_".$zen->ffv($n['clist_id'])."\", event)' ";
    $img = "<div style='float:right'><a href='$rootUrl/contact.php?$c1=$cpid'>";
    $img .= "<img src='$imageUrl/24x24/magnify.png' border='0' width='24' height='24'></a></div>";
?>	
    <tr class='bars' <?=$row_rollover_eff?> title='<?=$n['hotkey_tooltip']?>'>
    <td <?=$tc?>><?=$zen->ffv($cpid)?></td>
    <td <?=$tc?>><?= "$img {$n['hotkey_label']}" ?></td>
    <td <?=$tc?>><?= $n['telephone']? $zen->ffv($n["telephone"]) : '&nbsp;' ?></td>
    <td <?=$tc?>><?
      if( $n['email'] ) {
      ?><A id='link_<?=$cpid?>' HREF="mailto:<?=$zen->ffv($n['email'])?>"><?=$zen->ffv($n["email"])?></A>
      <? } else { ?>&nbsp;<? } ?></td>
    <? if( $editable ) { ?>
    <td <?=$tc?>><input 
        id='drops_<?=$zen->ffv($n['clist_id'])?>' type='checkbox' name='drops[]' 
        value='<?=$zen->ffv($n['clist_id'])?>'></td>
    </tr>
    <? } ?>
<?
  }
?>
<tr>
<td class='subTitle' colspan='<?=$colspan?>'>
  </div>
  <div style='float:right'>
  <? renderDivButton($hotkeys->find('Drop Contacts'), "window.document.forms['dropContactsForm'].submit()"); ?>
  </div>
</form>
  <? if( $editable ) { ?>
  <div style='float:left'>
  <form action="<?=$rootUrl?>/actions/addToContacts.php" name='ContactsAddForm'>
  <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
  <? renderDivButton($hotkeys->find('Add Contact'), "window.document.forms['ContactsAddForm'].submit()"); ?>
  <input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>
  </form>
  </div>
  <? } ?>
</td>
</tr>
<? } else { ?>
<tr><td valign='top' colspan='<?=$colspan?>' class='bars'>
<b><?=tr("No contacts found")?></b>
</td></tr>
  <? if( $editable ) { ?>
  <tr>
  <td colspan='<?=$colspan?>' class='subTitle'>
    <form action="<?=$rootUrl?>/actions/addToContacts.php" name='ContactsAddForm'>
    <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
    <? renderDivButton($hotkeys->find('Add Contact'), "window.document.forms['ContactsAddForm'].submit()"); ?>
    <input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>
    </form>
  </td>
  </tr>
  <? } ?>
<? } ?>     
</table>
<? if( $editabe ) { ?>
<p>&nbsp;
<form action='<?=$rootUrl?>/newContact.php' target="_BLANK" name='newContactForm'>
  <input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>
  <? renderDivButton($hotkeys->find('Create New Contact'), "window.document.forms['newContactForm'].submit()", 150); ?>
</form>
<? } ?>