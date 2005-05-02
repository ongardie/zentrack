<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       T    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
//echo $ie;
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "t"),
								2 => array(1 => $title, 2 => "<", 3 => "u"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "t"),
								2 => array(1 => $title, 2 => "<", 3 => "u"),
									3 => array(1 => "inextern", 2 => "=", 3 => $ie)
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

 
<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       U    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "u"),
								2 => array(1 => $title, 2 => "<", 3 => "v"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "u"),
								2 => array(1 => $title, 2 => "<", 3 => "v"),
									3 => array(1 => "inextern", 2 => "=", 3 => $ie)
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
   
<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       V    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "v"),
								2 => array(1 => $title, 2 => "<", 3 => "w"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "v"),
								2 => array(1 => $title, 2 => "<", 3 => "w"),
									3 => array(1 => "inextern", 2 => "=", 3 => $ie)
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

