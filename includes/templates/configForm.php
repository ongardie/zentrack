      <br>
      <p class='error'><?
         $str = "<a href='$rootUrl/help/find.php?s=admin&p=data_types'>".tr('Documentation')."</a>";
         print tr("Please refer to the ? before using this feature", array($str));
       ?></p>

<? if( $type == "type" ) { ?>
      <p><?=tr('There are two special types, which can be set by including either the word <span class="error">project</span> or <span class="error">note</span> in the bin name.')?></p>

     <p><?=tr('Projects act as containers, which can hold multiple tickets as "tasks" which are part of the projects completion requirements.')?></p>
     <p><?=tr('Notes are special tickets which do not require any actions.').'  '.
	       tr('They start their life closed, and do not need to be completed.').'  '. 
	       tr('Use them only for tracking and documentation.')?></p>
<? } ?>
	
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
         $js_vals = array();
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
	     print "<input type='hidden' name='newID[$j]' value='".$v[$id_type]."'>\n";
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
         <input type='hidden' name='TODO' value=''>
	 <input type='submit' value='<?=uptr("More")?>' onClick='return setToDo("MORE")'>
         &nbsp;
         <input type='submit' value='<?=uptr("Less")?>' onClick='return setToDo("LESS")'>	
	 &nbsp;
	 <input type='submit' class='submit' value='<?=uptr("Save")?>' onClick='return setToDo("Save")'>
	 &nbsp;
	 <input type='submit' class='submitPlain' value='<?=uptr("Reset")?>' onClick='return setToDo("Reset")'>
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
	 function setToDo(val) {
	   document.configForm.TODO.value = val;
           return true;
         }
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








