      <br>
      <p class='error'><?=tr("Changing the Bin Configuration has a large system impact.") . '  '
          .tr("Please consider this before making modifications.")?></p>
      <p class='error'><?=tr("Bins cannot be destroyed, to maintain data integrity.")?></p>
      <p class='smallBold'><?=tr("To remove a bin from use, uncheck the 'active' box.")?></p>

      <ul>
      <form name='binForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
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
	     print "<input type='hidden' name='newID[$j]' value='".$zen->ffv($v['bid'])."'>\n";
	     print "$t<input type='text' name='newBin[$j]' "
	       ." value='".$zen->ffv($v['name'])."' size='20' maxlength='25'>$te";
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
    <?=tr('Press MORE to create new bins')?>
    <br>
    <?=tr('Press LESS to remove blank rows')?>
    <br>
    <?=tr('Press Save to save changes')?>
    <br>
    <?=tr('Press Reset to return to original values')?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='4'>
	 <input type='submit' value='<?=uptr('More')?>' onClick="return setTodo('MORE')">
         &nbsp;
         <input type='submit' value='<?=uptr('less')?>' onClick="return setTodo('LESS')">
	 &nbsp;
	 <input type='submit' class='submit' value='<?=tr('Save')?>' onClick="return setTodo('Save')">
	 &nbsp;
	 <input type='submit' class='submitPlain' value='<?=tr('Reset')?>' onClick="return setTodo('Reset')">
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

	 function setTodo( val ) {
	   document.binForm.TODO.value = val;
	 } 	 
      </script> 








