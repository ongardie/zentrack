      <br>
      <p class='error'><?=tr("Changing this configuration list has a large system impact.")?>  <?=tr("Please consider this before making modifications.")?></p>
      <p class='error'><?=tr("Items in this list cannot be destroyed, to maintain data integrity.")?></p>
      <p class='smallBold'><?=tr("To remove a ? from use, uncheck the 'active' box.",array($type))?></p>
	
      <ul>
      <form name='configForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='4'>
	   <b><?=tr("Edit the Active ?s",array(ucfirst($type)))?></b>
	 </td>
	 </tr>
	 <tr>
	 <td width="30" class='cell' align='center'><b><?=tr("ID")?></b></td>
	 <td class='cell' align='center'><b><?=tr("Name")?></b></td>
	 <td width="30" class='cell' align='center'><b><?=tr("Order")?></b></td>
	 <td width="30" class='cell' align='center'><b><?=tr("Active")?></b></td>
	 </tr>
    <? 
         unset($js_vals);
         $num = count($vars) + $more;
	 if( is_array($vars) ) {
	   $newtext = "-".tr("new")."-";
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
	   foreach($vars as $v) {
	     print "<tr>\n";
	     $i = ($v["$id_type"])? $v["$id_type"] : $newtext;
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
	   print $t.$newtext.$te;
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
    <?=tr("Press MORE to create new rows")?>
    <br>
    <?=tr("Press LESS to remove blank rows")?>
    <br>
    <?=tr("Press Save to save changes")?>
    <br>
    <?=tr("Press Reset to return to original values")?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='4'>
	 <input type='submit' name='TODO' value='<?=uptr("More")?>'>
         &nbsp;
         <input type='submit' name='TODO' value='<?=uptr("Less")?>'>	
	 &nbsp;
	 <input type='submit' class='submit' name='TODO' value='<?=uptr("Save")?>'>
	 &nbsp;
	 <input type='submit' class='submitPlain' name='TODO' value='<?=uptr("Reset")?>'>
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
		 alert("<?=tr("There is already an entry with that value.")?>");
		 f.selectedIndex = bin[num];
		 return false;
	       }
	     }
	   }
	   bin[num] = val;
	   return true;
	 }
      </script> 








