
<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       OTHERS    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
//echo $ie;
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => "<", 3 => "a"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => "<", 3 => "a"),
									2 => array(1 => "inextern", 2 => "=", 3 => $ie)
);	
}

$sort = $title." asc";
      
	$tickets = $zen->get_contacts($parms,$tabel,$sort);
  if( is_array($tickets) && count($tickets) ) {
    if ($overview == "company") {
     include("$templateDir/listContacts.php");
   } else {
	   include("$templateDir/listContacts2.php"); 
   }
  } else {
     print tr("No contacts in this section.");
  }
  $tickets = NULL;
?>
     </td>
   </tr>
</table>

<br>  

