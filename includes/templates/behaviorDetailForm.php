      <br>
      <p class='error'><?=tr("This screen will let you list, add, edit and delete behavior rules.") . '  '
          .tr("Please refer to documentation.")?></p>
      <ul>
      <form name='behaviorDetailForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <input type='hidden' name='behavior_id' value='<?=$behavior_id?>'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='4'>
	   <b>Edit the Behavior Rules</b>
	 </td>
	 </tr>
	 <tr>
	 <td class='cell' align='center'><b><?=tr("Compare Field")?></b></td>
	 <td class='cell' align='center'><b><?=tr("Operator")?></b></td>
	 <td class='cell' align='center'><b><?=tr("Compare Value")?></b></td>
	 <td class='cell' align='center'><b><?=tr("Sort Order")?></b></td>
	 </tr>
    <? 
         $num = count($elements) + $more;
	 if( is_array($elements) ) {
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
           foreach ($elements as $item) {
             if (isset($item['field_name'])) {
	       print "<tr>\n";
               print "$t<select name='NewFieldName[{$j}]'>\n";
               print "<option value=''>".tr('-new/delete-')."</option>\n";
               foreach($field_list as $fl=>$fn) {
                 $sel=($item['field_name']==$fn)? " selected" : "";
                 print "<option value='{$fn}'{$sel}>{$fl}</option>\n";
               }
               print "$te";
               print "$t<select name='NewComparator[{$j}]'>\n";
               foreach($comp_opers as $key=>$label) {
                 $sel=($item['field_operator']==$key)? " selected" : "";
                 print "<option value='{$key}'{$sel}>{$label}</option>\n";
               }
               print "$te";
	       $item['field_value'] = $zen->ffv($item['field_value']);
               print "{$t}<input type='text' name='NewMatchValue[{$j}]' "
		 ." value='{$item['field_value']}' size='20' maxlength='255'>{$te}";
               print "{$t}<input type='text' name='NewSortOrder[{$j}]' "
		 ." value='{$item['sort_order']}' size='3' maxlength='3'>{$te}";
	       print "</tr>\n";
	       $j++;
             }
	   }
	 }
	 for( $i=0; $i<$more; $i++ ) {
	   print "<tr>\n";
           print "$t<select name='NewFieldName[{$j}]'>\n";
           print "<option value='' selected>".tr('-new/delete-')."</option>\n";
           foreach($field_list as $fl=>$fn) {
             print "<option value='$fn'>$fl</option>\n";
           }
           print "$te";
           print "$t<select name='NewComparator[{$j}]'>\n";
           foreach($comp_opers as $key=>$val) {
             $sel = ($key == 'eq')? " selected" : "";
             print "<option value='{$key}'{$sel}>{$val}</option>\n";
           }
           print "$te";
           print "{$t}<input type='text' name='NewMatchValue[{$j}]' "
	     ." value='' size='20' maxlength='255'>{$te}";
           print "$t"."<input type='text' name='NewSortOrder[{$j}]' "
	     ." value='' size='3' maxlength='3'>{$te}";
	   print "</tr>\n";
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
	 function setTodo( val ) {
	   document.behaviorDetailForm.TODO.value = val;
	 } 	 
      </script> 

