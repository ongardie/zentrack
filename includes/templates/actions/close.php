<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

  $view = 'ticket_close';
  $fields = $map->getFieldMap($view);
  $hidden_fields = array();
  $visible_fields = array();
  foreach($fields as $f=>$field) {
    if( !$field['is_visible'] ) { $hidden_fields["$f"] = $field; }
    else {
      $visible_fields["$f"] = $field;
    }
  }
?>

<form method="post" name="ticketForm" action="<?=$SCRIPT_NAME?>" onSubmit='return validateTicketForm()'>
<?
foreach($hidden_fields as $f=>$field) {
  //$view, $form_name, $field_name, $value = null, $prefix = ''
  print $map->renderTicketField($view, 'ticketForm', $f, $$f);
}
?>
<input type="hidden" name="id" value="<?=$zen->ffv($id)?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td colspan='2'>
   <span class="bigBold"><?=tr("Close Ticket")?></span>
   <br>
   <span class="small">(<?=tr("Set status to closed/pending")?>)</span>
 </td>
</tr>
<?

foreach($visible_fields as $f=>$field) {
  if( $field['field_type'] == 'section' ) {
    print "<tr><td colspan='2' class='subTitle'>";
    print $map->renderTicketField($view, 'ticketForm', $f);
    print "</td></tr>\n";
  }
  else {
    print "<tr><td class='bars' width='30%'>";
    print $map->getLabel($view, $f);
    print "</td><td class='bars'>";
    print $map->renderTicketField($view, 'ticketForm', $f, $$f);
    print "</td></tr>\n";
  }
}

?>

<tr>
  <td class="titleCell" colspan='2'>
    <?=tr("Click button to close")?>
  </td>
</tr>
<tr>
  <td colspan='2'>
    <input type="submit" value=" <?=uptr("Close")?> " class="submit">
  </td>
</tr>
<tr>
</table>
</form>			     
<?
  include_once("$libDir/templates/validateTicketForm.php");
?>
