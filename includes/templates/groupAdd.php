<?
  // generate some text to display based on whether this
  // is an edit page or an add page
  $td = ($TODO == 'EDIT');
  $blurb = ($td)? "Modify Data Group" : "Create New Data Group";
  $button = ($td)? "Save Changes" : "Create Group";
  $url = ($td)? "edit" : "add";
?>
<form method="post" action="<?=$rootUrl?>/admin/<?=$url?>GroupSubmit.php">
<? if( $td ) { print "<input type='hidden' name='group_id' value='".strip_tags($group_id)."'>\n"; } ?>
  
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
    <input type="text" name="NewGroupName" value="<?=strip_tags($group['group_name'])?>" size="40" maxlength="100">
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Description")?>
  </td>
  <td class="bars">
    <input type="text" name="NewDescript" value="<?=strip_tags($group['descript'])?>" size="40" maxlength="255">
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
