<?
  /**
   PREREQUISITES:
     (ZenFieldMap)$map - contains properties for fields
     (string)$view - the current view (probably project_list or ticket_list)
  **/  
  
  $view = 'project_create';
  $fields = $map->getFieldMap($view);
  $text_fields = array();
  $other_fields = array();
  $hidden_fields = array();
  foreach($fields as $f=>$field) {
    if( $field['field_type'] == 'hidden' ) {
      $hidden_fields[$f] = $field;
    }
    else if( $field['field_type'] == 'text' || $field['field_type'] == 'textarea' ) {
      $text_fields[$f] = $field; }
    else { $other_fields[$f] = $field; }
  }
?>
<form action="<?=$SCRIPT_NAME?>" name="searchForm" method='POST'>
<input type="hidden" name="TODO" value="SEARCH">
<?
foreach($hidden_fields as $f=>$field) {
  $map->renderTicketField($view, 'searchForm', $f, $$f);
}
?>
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     <?=tr("Search For Tickets")?>
  </td>
</tr>

<?
if( count($text_fields) ) {
?>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Text Match")?>
  </td>
</tr>
<tr>
  <td class="bars">
     <?=tr("Containing")?>
  </td>
  <td class="bars">
   <input type="text" name="search_text" 
      value="<?=$zen->ffv($search_text)?>" size="25" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
     <?=tr("In any of these")?>
  </td>
  <td class="bars">
    <table><tr><td valign='top'>
<?
  $c = 0;
  if( !is_array($search_fields) || !count($search_fields) ) 
      { $search_fields = array('title','description'); }
  foreach($text_fields as $t=>$field) {
    if( $c > 0 ) { print "<br>"; }
    $checked = is_array($search_fields) && array_key_exists($t, $search_fields) && $search_fields[$t] > 0;
    print "<input type='checkbox' name='search_fields[$t]' value='1'$checked>&nbsp;".tr($t)."\n";
    if( count($text_fields) > 3 && ++$c == ceil(count($text_fields)/2) ) {
      print "</td><td>\n";
    }
  }
}
?>
    </td></tr></table>
  </td>
</tr>
<?
foreach( $other_fields as $f=>$field ) {
  if( !$field['is_visible'] ) { continue; }

  if( $field['field_type'] == 'section' ) {
    print "<tr><td colspan='2' class='subTitle'>";
    print $map->renderTicketField($view, 'searchForm', $f);
    print "</td></tr>\n";
  }
  else {
    print "<tr><td class='bars'>";
    print $map->getLabel($view, $f);
    print "</td><td class='bars'>";
    if( $field['field_type'] == 'date' ) {
      print "<span class='note'>between ";
      $name = strpos($f, 'custom_')===0? "dates_{$f}_begin" : "{$f}_begin";
      print $map->renderTicketField($view, 'searchForm', $f, $$name, $name);
      print " and ";
      $name = strpos($f, 'custom_')===0? "dates_{$f}_end" : "{$f}_end";
      print $map->renderTicketField($view, 'searchForm', $f, $$name, $name);
      print "</span>";
    }
    else {
      $name = "search_params[$f]";
      print $map->renderTicketField($view, 'searchForm', $f, $$name, $name);
    }
    print "</td></tr>\n";
  }
}
?>
<tr>
  <td colspan="2" class="subTitle">
	<?=tr("Click 'Search' to find results")?>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
     <input type="submit" class="submit" value="<?=tr("Search")?>">
  </td>
</tr>

</table>
  
</form>
