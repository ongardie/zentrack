<?
         $elnk="$rootUrl/admin/editBehavior.php";
         $llnk="$rootUrl/admin/editBehaviorDetails.php";
?>
      <br>
      <p class='error'><?=tr("Edit existing behaviors or create a new one.")?></p>
      <ul>
      <form name='behaviorForm' action='<?=$elnk?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <table cellpadding="4" cellspacing="1" class='cell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='7'>
	   <b>Edit the Behaviors</b>
	 </td>
	 </tr>
	 <tr>
	 <td width="30" class='cell' align='center'><b>ID</b></td>
	 <td class='cell' align='center'><b>Enabled</b></td>
	 <td class='cell' align='center'><b>Sort Order</b></td>
	 <td class='cell' align='center'><b>Behavior Name</b></td>
	 <td class='cell' align='center'><b>Match Type</b></td>
	 <td class='cell' align='center'><b>Field Name</b></td>
	 <td class='cell' align='center'><b>Group to apply</b></td>
	 </tr>
    <? 
         $groups=$zen->getDataGroups(0);
         unset($js_vals);
         $num = count($vars);
	 if( is_array($vars) ) {
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
	   foreach($vars as $k => $v) {
	     print "<tr>\n";
	     print "$t".$k."$te";
	     print "$t".$zen->ffv(($v['is_enabled'])?tr("Yes") : tr("No"))."$te";
	     print "$t".$v['sort_order']."$te";
	     print "$t".$zen->ffv($v['behavior_name'])."$te";
	     print "$t".$zen->ffv(($v['match_all'])?tr("All rules") : tr("Any rule"))."$te";
	     print "$t".$zen->ffv($v['field_name'])."$te";
             print "$t".$groups[$v['group_id']]."$te";
             print "$t";

             print "<span class='small'>"
                 . "[<a href='".$elnk."?behavior_id=".$v['behavior_id']."'>".uptr('edit')."</a>]";
             print "<br>";
             print "<span class='small'>"
                 . "[<a href='".$llnk."?behavior_id=".$v['behavior_id']."'>".uptr('edit details')."</a>]";

             print "$te";

	     print "</tr>\n";
             $js_vals[] = $k;
	     $j++;
	   }
	 }
    ?>
<tr>
  <td class="titleCell" colspan="7">
    <?=tr('Press NEW to create new behaviors')?>
    <br>
    <?=tr('Press DONE when you have finished with the edition')?>
  </td>
</tr>
      <tr>
         <td class='cell' colspan='3'>
         <input type='submit' class='submit' value='<?=tr('New')?>' onClick="return setTodo('NEW')">
         &nbsp;
         <input type='submit' class='submit' value='<?=tr('Done')?>' onClick="return setTodo('DONE')">
         </td>
      </tr>
      </table>
      </ul>

      </form>


      <script language='javascript'>
          function setTodo( val ) {
           document.behaviorForm.TODO.value = val;
         }
      </script>
                                                                                                                             

