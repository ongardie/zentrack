<?
  $view = 'ticket_close';
  $fields = $map->listFieldsForView($view);
  $hidden_fields = array();
  $visible_fields = array();
  $sections = array();
  foreach($fields as $f) {
    $field = $map->getFieldFromMap($view,$f);
    if( !$field['is_visible'] ) { $hidden_fields[] = $f; }
    else {
      $visible_fields[] = $f;
      if( $field['field_type'] == 'section' ) { $sections[] = $f; }
    }
  }
?>

<form method="post" name="ticketForm" action="<?=$SCRIPT_NAME?>" onSubmit='return validateTicketForm()'>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=tr("Close Ticket")?></span>
   <br>
   <span class="small">(<?=tr("Set status to closed/pending")?>)</span>
 </td>
</tr>
<?
foreach($hidden_fields as $f) {
  //$view, $form_name, $field_name, $value = null, $prefix = ''
  print $map->renderTicketField($view, 'ticketForm', $f, $$f);
}

foreach($visible_fields as $f) {
  if( in_array($f, $sections) ) {
    print "<tr><td colspan='2' class='subTitle'>";
    print $map->renderTicketField($view, 'ticketForm', $f);
    print "</td></tr>\n";
  }
  else {
    print "<tr><td class='bars'>";
    print $map->getLabel($view, $f);
    print "</td><td class='bars'>";
    print $map->renderTicketField($view, 'ticketForm', $f, $$f);
    print "</td></tr>\n";
  }
}

?>

<tr>
  <td class="titleCell">
    <?=tr("Click button to close")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?=uptr("Close")?> " class="submit">
  </td>
</tr>
<tr>
</table>
</form>			     
<?
  include_once("$libDir/templates/validateTicketForm.php");
?>
