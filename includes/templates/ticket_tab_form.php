<? if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**
   * TICKET TAB FORM
   *
   * Generates a form for editing a given list of fields in a ticket tab
   *
   * $formview - (String) the field map view to use for deciding which fields to show
   * $map - (ZenFieldMap)
   * $actionName - where to send post data (defaults to $SCRIPT_NAME)
   * $submitName - name of submit button (defaults to 'Save')
   * $formTitle - title of the form
   * $formDesc - descriptive text for this form (optional)
   * $id - id of the ticket to display
   * $ticket - current contents of the ticket to display
   * $varfields - current varfield values for the ticket
   * $page_type - 'ticket' or 'project' (used by validateTicketForm.php)
   */
  $fields = $map->getFieldMap($formview);
  if( !isset($actionName) ) { $actionName = $SCRIPT_NAME; }
  if( !isset($submitName) ) { $submitName = 'Save'; }
  $hidden_fields = array();
  $visible_fields = array();
  foreach($fields as $f=>$field) {
    if( !$field['is_visible'] ) { $hidden_fields["$f"] = $field; }
    else {
      $visible_fields["$f"] = $field;
    }
  }
  
  /**
   * set up params for the form_fields include, which requires:
   *   $zen - zenTrack
   *   $map - ZenFieldMap
   *   $formview - view we are creating (ticket_create, project_edit, ticket_tab_3, etc)
   *   $form_name - name of the html form
   *   $ticket - the ticket object containing values
   *   $td - true if this is an edit form, false if it is a new ticket
   */
   $td = true;
   $form_name = "ticketTabForm";
?>
<form method="post" name="<?=$form_name?>" action="<?=$actionName?>" onSubmit='return validateTicketForm(this)'>
<input type="hidden" name="id" value="<?=$zen->ffv($id)?>">
<input type="hidden" name="actionComplete" value="1">
<input type='hidden' name='ticketTabAction' value='1'>
<input type='hidden' name='currentMode' value='<?=$zen->ffv($page_mode)?>'>
<table class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td colspan='2' class='subTitle'><?=tr($formTitle)?>
 <? if( isset($formDesc) ) { print "&nbsp;&nbsp;<span class='note'>".tr($formDesc)."</span>"; } ?>
 </td>
</tr>
<?
  include("$templateDir/form_fields.php");
?>

<tr>
  <td class="subTitle" colspan='2'>
  <? renderDivButton($hotkeys->find($submitName), "if( validateTicketForm(window.document.forms['$form_name']) ) { window.document.forms['$form_name'].submit(); }"); ?>
  </td>
</tr>
<tr>
</table>
<div class='error'><?=tr("Fields marked with ? are required", "<span class='bigBold'>*</span>")?></div>
</form>			     
<?
  include_once("$libDir/templates/validateTicketForm.php");
?>
