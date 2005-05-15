<?
if( !ZT_DEFINED ) { die("Illegal Access"); }


/*
*Show the contacts that are connected to a company
*/
//echo($company_id);
if ($company_id>"0") {
$company = $zen->get_contact($company_id,"ZENTRACK_COMPANY","company_id");
}

if (is_array($company)) {

$name ="<A HREF='".$rootUrl."/contact.php?cid=".$company['company_id']."'>".ucfirst($company["title"])." ".ucfirst($company["office"])."</A>";
}

?>
   <table cellpadding="0" cellspacing="0" border="0">
  <tr>
   <td class="ticketCell">
   <table align="center" width='570' border="0">
     <tr>
       <td valign="top"><table border="0"
          width="430" cellpadding="0" cellspacing="1">

    <tr>
	   <td class="titleCell" colspan="4"><p align="center"><?=$contractnr?></p></td>
	  </tr>
	  <tr>
	   <td class="smallTitleCell" colspan="2" ><?=uptr("Info")?></td>
	   <td class="smallTitleCell"  colspan="2" width="50%"><?=uptr("Dates")?></td>
	  </tr>
	  <tr>
     <td class="small" width="20%"><?=tr("Title")?>:</td>
	   <td class="small" width="30%"><?=$title?></td>
	   <td class="small" width="20%"><?=tr("Start Date")?>:</td>
	   <td class="small" width="30%"><?if($stime){echo $zen->showDate($stime);}?></td>
	  </tr>
	  <tr>
	   <td class="small" width="20%"><?=tr("Company")?>:</td>
	   <td class="small" width="30%"><?=$name?></td>
	   <td class="small" width="20%"><?=tr("Expiration Date")?>:</td>
	   <td class="small" width="30%"><?if($dtime){echo $zen->showDate($dtime);}?></td>
	  </tr>
	  <tr>
	   <td class="small" width="20%"></td>
	   <td class="small" width="30%"></td>
	   <td class="small" width="20%"></td>
	   <td class="small" width="30%"></td>
	  </tr>
<?
 if(!empty($description)) {
?>
	  <tr>
	   <td class="smallTitleCell" colspan="4"><?=uptr("Description")?></td>
	  </tr>
	  <tr>
	   <td class="small" colspan="4"><?=(get_magic_quotes_runtime())?nl2br(stripslashes($description)):nl2br($description); ?></td>
	  </tr>
<?
}
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

  $class = '';
  foreach($items as $t) {
    $class = $class == 'bars'? 'cell' : 'bars';
    ?>
    <tr class='<?=$class?>'>
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
  $value = "ARCHIVE";
} else {
  $active = "1";
  $value = "ACTIVATE";
}

print "<tr>\n<form name='archief_form' action='$rootUrl/actions/agreement_archive.php'>\n";
print "<td>\n";
print "<input type='submit' class='actionButtonContact'  value='$value'";
print " onClick='return confirm(\"";
print tr("Are you sure you want to archive this agreement?");
print "\")'";
print ">\n";
print "<input type='hidden' name='id' value='$agree_id'>\n";
print "<input type='hidden' name='active' value='$active'>\n";
print "</td>\n</form>\n</tr>\n";


print "<tr>\n<form name='delete_form' action='$rootUrl/actions/agreement_delete.php'>\n";
print "<td>\n";
print "<input type='submit' class='actionButtonContact'  value='".uptr('delete')."'";
print " onClick='return confirm(\"".tr("Are you sure you want to permanently delete this agreement?")."\")'";
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
<br>