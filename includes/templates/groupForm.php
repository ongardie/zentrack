      <br>
      <p class='error'><?=tr("This screen will let you list, add, edit and delete data groups.") . '  '
          .tr("Please refer to documentation.")?></p>
      <ul>
      <form name='groupForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='5'>
	   <b>Edit the Data Groups</b>
	 </td>
	 </tr>
	 <tr>
	 <td width="30" class='cell' align='center'><b>ID</b></td>
	 <td class='cell' align='center'><b>Table Name</b></td>
	 <td class='cell' align='center'><b>Group Name</b></td>
	 <td class='cell' align='center'><b>Description</b></td>
	 </tr>
    <? 
         $tables=$zen->getDataGroupTablesArray();
         $elnk="$rootUrl/admin/editGroup.php";
         $llnk="$rootUrl/admin/editGroupDetails.php";
         unset($js_vals);
         $num = count($vars);
	 if( is_array($vars) ) {
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
	   foreach($vars as $v) {
	     print "<tr>\n";
	     print "$t".$v['group_id']."$te";
             print "$t";
             foreach($tables as $tbl_k=>$tbl_v) {
               if ($v['table_name']==$tbl_v) {
                 print "$tbl_k";
               }
             }
             print "$te\n";
	     print "$t".$zen->ffv($v['group_name'])."$te";
	     print "$t".$zen->ffv($v['descript'])."$te";
             print "$t";

             print "<span class='small'>"
                 . "[<a href='".$elnk."?group_id=".$v['group_id']."'>".uptr('edit')."</a>]";
             print "<br>";
             print "<span class='small'>"
                 . "[<a href='".$llnk."?group_id=".$v['group_id']."'>".uptr('edit details')."</a>]";

             print "$te";

	     print "</tr>\n";
             $js_vals[] = ($v["group_name"])? $v["group_name"] : 0;
	     $j++;
	   }
	 }
    ?>
<tr>
  <td class="titleCell" colspan="5">
    <?=tr('Press NEW to create new data groups')?>
    <br>
    <?=tr('Press DONE when you have finished with the edition')?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='5'>
	 <input type='submit' value='<?=uptr('New')?>'>
         &nbsp;
         <input type='submit' value='<?=uptr('Done')?>'>
	 &nbsp;
         </td>
      </tr>
      </table>
      </ul>

      </form>








