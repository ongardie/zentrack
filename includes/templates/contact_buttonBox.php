<table width="120" cellpadding="0" cellspacing="0" border="0">
<tr>
<?
      
      $actions = array(
			"company",			
			"external",		     
			"internal",
			"all"
			);	

			$st=($setmode =="all")?"abc":$setmode;
			
	foreach($actions as $a) {
		
			$value = uptr($a);
			
			$ien=($a=="intern")?2:1;
			$st=($a=="all")?"all":$st;
			$ov=($a=="all")?$overview:$a;
				
			print "\n<form name='".$a."_form' action='$rootUrl/contacts.php'>\n";
			print "<td>\n";
			print "<input type='submit' class='actionButtonContact' $style value='$value' >\n";
			print "<input type='hidden' name='ie' value='$ien'>\n";
			print "<input type='hidden' name='setmode' value='$st'>\n";
			print "<input type='hidden' name='overview' value='$ov'>\n";
			print "</td>\n</form>\n\n";
  }
?>
</tr>
</table>