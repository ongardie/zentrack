<?  
  /**
   PREREQUISITES:
     (ZenFieldMap)$map - contains properties for fields
     (string)$view - the current view (probably project_create or ticket_create)
     (string)$page_type - (optional) either 'ticket' or 'project'
  **/


  unset($users);
  $td = ($TODO == 'EDIT');
  
  // determine what type of page we are looking at and create some useful labels
  if( !isset($page_type) ) { 
    $page_type = strpos($view,'project')===0? 'project' : 'ticket'; 
  }
  $plural = $page_type == 'project'? 'projects' : 'tickets';
  $ucfirst = ucfirst($page_type);
  
  // calculate the bins which this user can access
  if( $td ) {
    $userBins = $zen->getUsersBins($login_id,"level_edit");  
  }
  else {
    $level = $page_type=='project'? 'level_create_proj' : "level_create";
    $userBins = $zen->getUsersBins($login_id,$level);
    $id = 0;
    $creator_id = $login_id;
    $status = 'OPEN';
  }
  
  // blow up if this user does not have proper access to any bins
  if( !is_array($userBins) || !count($userBins) ) {
    print "<span class='error'>";
    if( $td ) {
      print tr("You do not have permission to edit ?.", array($plural));
    }
    else {
      print tr("You do not have permission to create ?.", array($plural));
    }
    print "</span>\n";
    include("$libDir/footer.php");
    exit;
  }
  if( !$deadline && !$td )
     $deadline = $zen->getDefaultValue("default_deadline");
  if( !$start_date && !$td )
     $start_date = $zen->getDefaultValue("default_start_date");
     
  if( strlen($deadline) ) { $deadline = $zen->showDateTime($deadline); }
  if( strlen($start_date) ) { $start_date = $zen->showDateTime($start_date); }
  if( strlen($ctime) ) { $ctime = $zen->showDateTime($ctime); }
  if( strlen($otime) && $td ) { $otime = $zen->showDateTime($otime); }
  else { $otime = time(); }
     
  //$view = $td? 'ticket_edit' : 'ticket_create';
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
  
  // calculate the destination of our form results
  if( $td ) {
    $formDest = $page_type == 'project'? 'editProjectSubmit.php' : 'editTicketSubmit.php';
  }
  else {
    $formDest = $page_type == 'project'? 'addProjectSubmit.php' : 'addSubmit.php';
  }
?>
<form method="post" name="ticketForm" action="<?=$formDest?>" onSubmit='return validateTicketForm()'>
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     <?=tr("$ucfirst Information")?>
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
  <td class="titleCell" colspan="2" align="center">
  <?=tr("Click button to")?> <?=($td)? tr("save your changes"):tr("create your $page_type")?>.
  </td>
</tr>
<?
  if ($td && $zen->settings['edit_reason_required']=='on' && $zen->settings['log_edit']=='on') {
    $er_vals=array('field_cols'   => '60',
                   'field_rows'   => '5',
                   'field_name'   => 'edit_reason',
                   'field_events' => '',
                   'field_value'  => '');
    $er_template=new zenTemplate("$templateDir/fields/textarea.template");
    $er_template->values($er_vals);
?>
<tr>
  <td class="bars">
    <?=tr("Edit Reason")?><br>
    (<?=tr("Mandatory")?>)
  </td>
  <td class="bars">
<?
    print $er_template->process();
?>
  </td>
</tr>
<?
  }
?>
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value=" <?=tr(($td)?"Save":"Create")?> " class="submit">
  </td>
</tr>
</table>
</form>

<?
  include_once("$libDir/templates/validateTicketForm.php");
?>
