      <br>
      <p class='error'>Changing this configuration list has a large system impact.  Please 
	 consider this before making modifications.</p>
      <p class='error'>Items in this list cannot be destroyed, to maintain data integrity.</p>
      <p class='smallBold'>To remove a <?=$type?> from use, uncheck the 'active' box.</p>

      <ul>
      <form name='configForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <trf>
	 <td class='titleCell' align='center' colspan='4'>
	   <b>Edit the Active <?=ucfirst($type)?></b>
	 </td>
	 </tr>
	 <tr>
	 <td width="30" class='cell' align='center'><b>ID</b></td>
	 <td class='cell' align='center'><b>Name</b></td>
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
	     $i = ($v["$id_type"])? $v["$id_type"] : "-new-";
	     print "$t$i$te";
	     print "<input type='hidden' name='newID[$j]' value='$v[$id_type]'>\n";
	     print "$t<input type='text' name='newName[$j]' "
	       ." value='$v[name]' size='20' maxlength='25'>$te";
	     print "$t<select name='newPri[$j]' "
	       ." onChange='return checkOrder($j, this)'>\n"
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
	   print "$t<input type='text' name='newName[$j]' "
	     ." value='' size='20' maxlength='25'>$te";
	   print "$t<select name='newPri[$j]' "
	     ." onChange='checkOrder($j, this)'>\n"
	     .admin_number_pulldown( $num )."</select>\n$te";
	   print "$t<input type='checkbox' name='newActive[$j]' value='1' checked>$te";
	   print "</tr>\n";	   
	   $js_vals[] = 0;
	   $j++;
	 }

    ?>
<tr>
  <td class="titleCell" colspan="4">
    Press MORE to create new rows
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
         function checkOrder( num, f ) {
	   if( num == "" )
	     num = 0;
	   val = f.selectedIndex+"";
	   for( i=0; i<bin.length; i++ ) {
	     if( i != num ) {
	       if( bin[i] > 0 && bin[i] == val ) {
		 alert("There is already an entry with that value.");
		 f.selectedIndex = bin[num];
		 return false;
	       }
	     }
	   }
	   bin[num] = val;
	   return true;
	 }
      </script> 








