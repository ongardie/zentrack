      <br>
      <p class='error'><?=tr("This screen will let you list, add, edit and delete data group details.") . '  '
          .tr("Please refer to documentation.")?></p>
      <ul>
      <form name='groupDetailsForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='3'>
	   <b>Edit the Data Group Details</b>
	 </td>
	 </tr>
	 <tr>
	 <td width="30" class='cell' align='center'><b>Use in group</b></td>
	 <td class='cell' align='center'><b>Element</b></td>
	 <td class='cell' align='center'><b>Sort Order</b></td>
	 </tr>
    <? 
         $query = "SELECT * FROM ".$group['table_name']." WHERE active=1";
         $vars  = $zen->db_query($query);
	 if( is_array($vars) ) {
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
           for($i=0; $i<count($vars); $i++) {
	     print "<tr>\n";
             print "$t"."<input type='checkbox' name='NewUseInGroup[".$j."]' value='".$vars[$i][0]."'";
             $so=0;
             for($k=0; $k<count($group_details); $k++) {
               if($group_details[$k]['value'] == $vars[$i][0]) {
                 print " checked ";
                 $so=$group_details[$k]['sort_order'];
               }
             }
             print "><input type='hidden' name='NewValue[".$j."]' value='".$vars[$i][0]."'"."$te";
	     print "$t".$zen->ffv($vars[$i][1])."$te";
             print "$t"."<input type='text' name='NewSortOrder[".$j."]' value='".$so."' size='3' maxlength='3'>"."$te";
	     print "</tr>\n";
	     $j++;
	   }
	 }
    ?>
<tr>
  <td class="titleCell" colspan="3">
    <?=tr('Press Save to store your changes')?>
    <br>
    <?=tr('Press Reset to ignore them')?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='3'>
	 <input type='submit' value='<?=uptr('Save')?>'>
         &nbsp;
         <input type='submit' value='<?=uptr('Reset')?>'>
	 &nbsp;
         </td>
      </tr>
      </table>
      </ul>

      </form>








