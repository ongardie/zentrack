<?  
  unset($users);
  $td = ($TODO == 'EDIT');
  if( $td ) {
    $userBins = $zen->getUsersBins($login_id,"level_edit");  
  }
  else {
    $userBins = $zen->getUsersBins($login_id,"level_create");
  }
  if( !is_array($userBins) || !count($userBins) ) {
    print "<span class='error'>";
    if( $td ) {
      print tr("You do not have permission to edit tickets.");
    }
    else {
      print tr("You do not have permission to create tickets.");
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
     
  $view = $td? 'ticket_edit' : 'ticket_create';
  $map =& new ZenFieldMap($zen);
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
<form method="post" name="ticketForm" action="<?=($td)? "editTicketSubmit.php" : "$rootUrl/addSubmit.php"?>" onSubmit='return validateTicketForm()'>
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     <?=tr("Ticket Information")?>
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
  <?=tr("Click button to")?> <?=($td)? tr("save your changes"):tr("create your ticket")?>.
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value=" <?=tr(($td)?"Save":"Create")?> " class="submit">
  </td>
</tr>
</table>

<script language='Javascript' type='text/javascript'>

 function validateTicketForm() {
   var errs = new Array();
   if( !document.ticketForm.title.value ) {
     errs[ errs.length ] = "<?=tr("? is required",array( tr("Title") ))?>";
   }
   
<?
$varfields = $zen->getCustomFields(0,'Ticket', 'New');
if( is_array($varfields) && count($varfields) ) {
  foreach($varfields as $v) {
    $k = $v['field_name'];
    $l = $v['field_label'];
    if( $v['js_validation'] ) {
      print preg_replace('/\{form\}/', 'document.ticketForm', $v['js_validation']);
    }
    else {
      $f = "document.ticketForm.{$k}";
      $e = 'errs[ errs.length ]';
      switch( getVarfieldDataType($k) ) {
        case "menu":
        // if the value of the menu selection is '', then
        // the required status is significant
        if( $v['is_required'] ) {
          print "if( {$f}.options[ {$f}.selectedIndex ].value == '' )"
          . " { {$e} = '{$l} is required'; }\n";
        }
        case "boolean":
        // no validation for checkboxes
        break;
        case "number":
        // make sure it is a valid number
        print "if( {$f}.value.match( /[^0-9.]/ ) ) { {$e} = '"
        .tr('? is not a valid number',array(tr($l)))."'; }\n";
        default:
        // nothing to do for dates or strings, just
        // check the required status
        // numbers fall through to here also
        if( $v['is_required'] ) {
          print "if( !{$f}.value ) { {$e} = '"
          .tr('? is required',array(tr($l)))."'; }\n";
        }
      }
    }
  }
}
?>
   if( errs.length > 0 ) {
     var str = "<?=tr("Please correct the following errors:")?>\n----------\n";
     for( var i=0; i < errs.length; i++ ) {
       str += errs[i]+"\n";
     }
     alert(str);
     return false;
   }
   return true;
 }

</script>
