<table width="645" cellpadding="0" cellspacing="0" border="0">
<tr> 
  <td class="ticketCell" height="300" valign="top">
<br>
<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       ALL    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
//echo $ie;


$sort = $title." asc";
$ie=($overview=="intern")?2:1;
  
  if ($overview=="company") {  
		$tickets = $zen->get_contacts("",$tabel,$sort);
  } else {
	  $parms = array(1 => array(1 => "inextern", 2 => "=", 3 => $ie)
	  );	
	  $tickets = $zen->get_contacts($parms,$tabel,$sort);
  }
  
  if( is_array($tickets) && count($tickets) ) {
    
	  if ($overview=="company"){
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
</td>
</tr>
</table>

<br>  