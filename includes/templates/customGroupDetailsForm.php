      <br>
      <p class='error'><?=tr("This screen will let you list, add, edit and delete data group details.") . '  '
          .tr("Please refer to documentation.")?></p>
      <ul>
      <form name='customGroupDetailsForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <input type='hidden' name='group_id' value='<?=$group_id?>'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='4'>
	   <b>Edit the Custom Data Group Details</b>
	 </td>
	 </tr>
	 <tr>
	 <td class='cell' align='center'><b>Item</b></td>
	 <td width="30" class='cell' align='center'><b>Sort Order</b></td>
	 <td width="30" class='cell' align='center'><b>Delete</b></td>
	 </tr>
    <? 
         unset($js_vals);
         $num = count($elements) + $more;
	 if( is_array($elements) ) {
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
           foreach ($elements as $item) {
             if (isset($item['value'])) {
	       print "<tr>\n";
               print "$t"."<input type='text' name='NewValue[".$j."]' value='";
//               print ($item['value']) ? "$item['value']" : "-new-";
               print $item['value'];
               print "' size='20' maxlength='255' onChange='return checkDetails($j, this)'>"."$te";
               print "$t"."<input type='text' name='NewSortOrder[".$j."]' value='".$item['sort_order'];
               print "' size='3' maxlength='3'>"."$te";
	       print "$t<input type='checkbox' name='NewDelete[$j]' value='1'";
	       print ( $NewDelete[$j] ) ? " checked>$te" : ">$te";
	       print "</tr>\n";
               $js_vals[]=($item['value'])?$item['value'] : 0;
	       $j++;
             }
	   }
	 }
	 for( $i=0; $i<$more; $i++ ) {
	   print "<tr>\n";
           print "$t"."<input type='text' name='NewValue[".$j."]' value='";
           print "-new-";
           print "' size='20' maxlength='255' onChange='return checkDetails($j, this)'>"."$te";
           print "$t"."<input type='text' name='NewSortOrder[".$j."]' value='0";
           print "' size='3' maxlength='3'>"."$te";
	   print "$t<input type='checkbox' name='NewDelete[$j]' value='1'";
	   print ">$te";
	   print "</tr>\n";
	   $js_vals[] = 0;
	   $j++;
	 }

    ?>
<tr>
  <td class="titleCell" colspan="4">
    <?=tr('Press MORE to create new detail items')?>
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
         var detail = [ <?=join(",",$js_vals)?> ];
         function checkDetails( num, f ) {
	   if( num == "" )
	     num = 0;
	   val = f.selectedIndex+"";
	   for( i=0; i<detail.length; i++ ) {
	     if( i != num ) {
	       if( detail[i] > 0 && detail[i] == val ) {
		 alert("There is already a detail item with that value.");
		 f.selectedIndex = detail[num];
		 return false;
	       }
	     }
	   }
	   detail[num] = val;
	   return true;
	 }

	 function setTodo( val ) {
	   document.customGroupDetailsForm.TODO.value = val;
	 } 	 
      </script> 








