      <br>
      <p class='error'><?=tr("Changing the custom fields definition is a new facility.") . '  '
          .tr("Please read documentation before trying to do it.")?></p>
      <p class='error'><?=tr("You cannot add nor delete custom fields using this interface.") . '  '
          .tr("This is only for modifying the current custom fields.")?></p>
      <p class='error'><?=tr("You can add and delete custom fields modifying the DB structure and then using this tool.")?></p>
      <p class='smallBold'><?=tr("For more information please refer to the documentation.")?></p>

      <ul>
      <form name='editCustomsForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='10'>
	   <b>Edit the Available Custom Fields</b>
	 </td>
	 </tr>
	 <tr>
	 <td width="60" class='cell' align='center'><b>Field Name</b></td>
	 <td class='cell' align='center'><b>Field Label</b></td>
	 <td class='cell' align='center'><b>Order</b></td>
	 <td width="30" class='cell' align='center'><b>Required</b></td>
	 <td width="30" class='cell' align='center'><b>For Project</b></td>
	 <td width="30" class='cell' align='center'><b>For Ticket</b></td>
	 <td width="30" class='cell' align='center'><b>In Search</b></td>
	 <td width="30" class='cell' align='center'><b>In List</b></td>
	 <td width="30" class='cell' align='center'><b>In Custom Tab</b></td>
	 <td width="30" class='cell' align='center'><b>In Detail Tab</b></td>
	 </tr>
    <?
         unset($js_vals);
         $num = count($vars);
	 if( is_array($vars) ) {
	   $j = 0;
	   $t = "\t<td class='bars' align='center'>";
	   $te = "</td>\n";
	   foreach($vars as $v) {
	     print "<tr>\n";
	     $i = $v["field_name"];
	     print "$t$i$te";
	     print "<input type='hidden' name='newFieldName[$j]' value='".$zen->ffv($v['field_name'])."'>\n";
	     print "$t<input type='text' name='newFieldLabel[$j]' "
	       ." value='".$zen->ffv($v['field_label'])."' size='20' maxlength='50'>$te";
	     print "$t<input type='text' name='newSortOrder[$j]' "
	       ." value='".$zen->ffv($v['sort_order'])."' size='5' maxlength='5'>$te";
	     print "$t<input type='checkbox' name='newIsRequired[$j]' value='1'";
	     print ($v["is_required"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newForProject[$j]' value='1'";
	     print ($v["use_for_project"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newForTicket[$j]' value='1'";
	     print ($v["use_for_ticket"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newShowInSearch[$j]' value='1'";
	     print ($v["show_in_search"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newShowInList[$j]' value='1'";
	     print ($v["show_in_list"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newShowInCustom[$j]' value='1'";
	     print ($v["show_in_custom"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newShowInDetail[$j]' value='1'";
	     print ($v["show_in_detail"])? " checked" : "";
	     print ">$te";
	     print "</tr>\n";
	     $js_vals[] = ($v["sort_order"])? $v["sort_order"] : 0;
	     $j++;
	   }
	 }

    ?>
<tr>
  <td class="titleCell" colspan="10">
    <?=tr('Press Save to save changes')?>
    <br>
    <?=tr('Press Reset to return to original values')?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='2'>
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
           document.editCustomsForm.TODO.value = val;
         }
      </script>
                                                                                                                             

