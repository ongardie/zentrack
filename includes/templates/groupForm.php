<?
         $elnk="$rootUrl/admin/editGroup.php";
         $llnk="$rootUrl/admin/editGroupDetails.php";
?>
      <br>
      <p class='error'><?=tr("Edit existing groups or create a new group.")?></p>
      <p>Note that behaviors are meant to provide suggested values to
         the user.  They are not meant to be used as a control mechanism
         and could be circumvented by creative users.</p>
      <ul>
      <form name='groupForm' action='<?=$elnk?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <table cellpadding="4" cellspacing="1" class='cell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='6'>
	   <b><?=tr("Data Groups")?></b>
	 </td>
	 </tr>
	 <tr>
           <td width="30" class='cell' align='center'><b><?=uptr("id")?></b></td>
           <td class='cell' align='center'><b><?=tr("Group Name")?></b></td>
           <td class='cell' align='center'><b><?=tr("Table Name")?></b></td>
           <td class='cell' align='center'><b><?=tr("Entries")?></b></td>
           <td class='cell' align='center'><b><?=tr("Description")?></b></td>
           <td class='cell' align='center'><b><?=tr("Actions")?></b></td>
	 </tr>
    <? 
         $tables=$zen->getDataGroupTablesArray();
         unset($js_vals);
         $num = count($vars);
	 if( is_array($vars) ) {
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
	   foreach($vars as $v) {
	     $key = $v['group_id'];
	     print "<tr>\n";

	     // the id for the row
	     print $t.$key.$te;

	     // the group's name
	     print $t.$zen->ffv($v['group_name']).$te;

	     // the table for this group
             print $t;
             foreach($tables as $tbl_k=>$tbl_v) {
               if ($v['table_name']==$tbl_v) {
                 print $tbl_k;
               }
             }

	     // the number of details for this row
             print "$te\n";
	     $c = $counts["$key"] > 0? $counts["$key"] : 0;
	     print $t.$c.$te;

	     // description for the row
	     print $t.$zen->ffv($v['descript']).$te;

	     // the action links
             print $t;
             print "<span class='small'>"
	       . "[<a href='".$elnk."?group_id=".$v['group_id']."'>"
	       .uptr('properties')."</a>]";
             print "<br>";
             print "<span class='small'>"
	       . "[<a href='".$llnk."?group_id=".$v['group_id']."'>"
	       .uptr('entries')."</a>]";
             print $te;

	     print "</tr>\n";
             $js_vals[] = ($v["group_name"])? $v["group_name"] : 0;
	     $j++;
	   }
	 }
    ?>
<tr>
  <td class="titleCell" colspan="6">
    <?=tr('Press NEW to create new data groups')?>
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
           document.groupForm.TODO.value = val;
         }
      </script>
                                                                                                                             

