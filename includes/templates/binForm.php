      <br>
      <p class='error'>Changing the Bin Configuration has a large system impact.  Please 
	 consider this before making modifications.</p>
      <p class='error'>Bins cannot be destroyed, to maintain data integrity.</p>
      <p class='smallBold'>To remove a bin from use, uncheck the 
	 'active' box.</p>

      <p>There are two special bin types, which can be set manually in 
	the includes/configVars.php file (poor method), or set here (preferred
	method) by naming a bin with either the word "project" or "note" in
	the bin name.</p>

     <p>Projects act as containers, which can hold multiple tickets as "tasks" 
	which are part of the projects completion requirements.</p>

     <p>Notes are special tickets which do not require any actions 
	(they start their life closed, and do not need to be completed), 
	and are used only for tracking and documentation</p>

      <ul>
      <form name='binForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='4'>
	   <b>Edit the Active Bins</b>
	 </td>
	 </tr>
	 <tr>
	 <td width="30" class='cell' align='center'><b>ID</b></td>
	 <td class='cell' align='center'><b>Bin Name</b></td>
	 <td width="30" class='cell' align='center'><b>Order</b></td>
	 <td width="30" class='cell' align='center'><b>Active</b></td>
	 </tr>
    <? 
         unset($js_vals);
         $num = count($vars) + $more;
	 if( is_array($vars) ) {
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
	   foreach($vars as $v) {
	     print "<tr>\n";
	     $i = ($v["bid"])? $v["bid"] : "-new-";
	     print "$t$i$te";
	     print "<input type='hidden' name='newID[$j]' value='$v[bid]'>\n";
	     print "$t<input type='text' name='newBin[$j]' "
	       ." value='$v[name]' size='20' maxlength='25'>$te";
	     print "$t<select name='newPri[$j]' "
	       ." onChange='return checkBins($j, this)'>\n"
	       .admin_number_pulldown( $num, $v["priority"] )."</select>\n$te";
	     print "$t<input type='checkbox' name='newActive[$j]' value='1'";
	     print ($v["active"])? " checked" : "";
	     print ">$te";
	     print "</tr>\n";
	     $js_vals[] = ($v["priority"])? $v["priority"] : 0;
	     $j++;
	   }
	 }
	 for( $i=0; $i<$more; $i++ ) {
	   print "<tr>\n";
	   print $t."-new-".$te;
	   print "<input type='hidden' name='newID[$j]' value=''>\n";
	   print "$t<input type='text' name='newBin[$j]' "
	     ." value='' size='20' maxlength='25'>$te";
	   print "$t<select name='newPri[$j]' "
	     ." onChange='checkBins($j, this)'>\n"
	     .admin_number_pulldown( $num )."</select>\n$te";
	   print "$t<input type='checkbox' name='newActive[$j]' value='1' checked>$te";
	   print "</tr>\n";	   
	   $js_vals[] = 0;
	   $j++;
	 }

    ?>
<tr>
  <td class="titleCell" colspan="4">
    Press MORE to create new bins
    <br>
    Press LESS to remove blank rows
    <br>
    Press Save to save changes
    <br>
    Press Reset to return to original values
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='4'>
	 <input type='submit' name='TODO' value='MORE'>
         &nbsp;
         <input type='submit' name='TODO' value='LESS'>	
	 &nbsp;
	 <input type='submit' class='submit' name='TODO' value='Save'>
	 &nbsp;
	 <input type='submit' class='submitPlain' name='TODO' value='Reset'>
         </td>
      </tr>
      </table>
      </ul>

      <input type='hidden' name='more' value='<?=$more?>'>
      </form>
      <script language='javascript'>
	 var i;
         var ci;
         var bin = [ <?=join(",",$js_vals)?> ];
         function checkBins( num, f ) {
	   if( num == "" )
	     num = 0;
	   val = f.selectedIndex+"";
	   for( i=0; i<bin.length; i++ ) {
	     if( i != num ) {
	       if( bin[i] > 0 && bin[i] == val ) {
		 alert("There is already a bin with that value.");
		 f.selectedIndex = bin[num];
		 return false;
	       }
	     }
	   }
	   bin[num] = val;
	   return true;
	 }
      </script> 








