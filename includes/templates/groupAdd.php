<?
  // generate some text to display based on whether this
  // is an edit page or an add page
  $td = ($TODO == 'EDIT');
  $blurb = ($td)? "Modify Data Group" : "Create New Data Group";
  $button = ($td)? "Save Changes" : "Create Group";
  $url = ($td)? "edit" : "add";
?>
<form method="post" action="<?=$rootUrl?>/admin/<?=$url?>GroupSubmit.php" name='groupAddForm'>
<? if( $td ) { print "<input type='hidden' name='group_id' value='".$zen->ffv($group_id)."'>\n"; } ?>
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
  <?=$blurb?>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Group Information")?> (<?=tr("* = required")?>)
  </td>
</tr>  
<tr>
  <td class="bars">
    <?=tr("Table Name")?>*
  </td>
    <?
             $t = "\t<td class='bars'>";
             $te = "</td>\n";
             $tables=$zen->getDataGroupTablesArray();
             print "$t<select name='NewTableName'>\n";
             foreach($tables as $tbl_k=>$tbl_v) {
               $sel=($group['table_name']==$tbl_v)? " selected" : "";
               print "<option value='$tbl_v'$sel>$tbl_k</option>\n";
             }
             print "$te";
    ?>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Group Name")?>*
  </td>
  <td class="bars">
    <input type="text" name="NewGroupName" value="<?=$zen->ffv($group['group_name'])?>" size="40" maxlength="100">
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Description")?>
  </td>
  <td class="bars">
    <input type="text" name="NewDescript" value="<?=$zen->ffv($group['descript'])?>" size="40" maxlength="255">
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Eval Type")?>
  </td>
  <td class="bars">
    <select name='NewEvalType' onChange='toggleEvalText(this)'>
      <option<?=$group['eval_type'] == 'Matches'? ' selected':''?>>Matches</option>
      <option<?=$group['eval_type'] == 'Javascript'? ' selected':''?>>Javascript</option>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Eval Script")?>
  </td>
  <td class="bars">
    <textarea name='NewEvalText' cols='50' rows='4'<?=
	       $group['eval_type'] != 'Javascript'? ' disabled=true class="greytext"' : ' class="fieldtext"'
     ?>><?=$zen->ffv($group['eval_text'])?></textarea>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Click ? to ?",array($button,$blurb))?>.
  </td>
</tr>  
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value="<?=$button?>" class="submit">
  </td>
</tr>
</table>

</form>
<script language='javascript'>
   function toggleEvalText( selectObj ) {
     var fld = window.document.groupAddForm.NewEvalText;
     if( selectObj.options[ selectObj.selectedIndex ].text == 'Javascript' ) {
       fld.disabled = false;
       fld.style.color = '<?=$zen->settings['color_bar_text']?>';
     }
     else {       
       window.document.groupAddForm.NewEvalText.disabled = true;
       fld.style.color = '<?=$zen->settings['color_grey']?>';
     }
   }
</script>