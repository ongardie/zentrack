<?  
  /**
   PREREQUISITES:
     (ZenFieldMap)$map - contains properties for fields
     (string)$view - the current view (probably project_create or ticket_create)
     (string)$page_type - (optional) either 'ticket' or 'project'
  **/
?>

<script language='Javascript' type='text/javascript'>

 function validateField( obj ) {
    switch( obj.type ) {
      case "checkbox":
        return obj.checked;
      case "text":
      case "textarea":
      case "file":
        return obj.value != null && obj.value.length;
      case "select":
      case "select-one":
        var val = obj.options[ obj.selectedIndex ].value;       
        return val != null && val != "";    
      case "select-multiple":
      case "radio":
        return true;
      case "button":
      case "submit":
      case "hidden":
      case "password":
      case "reset":
      default:
        return false;
    }
 }

 function validateTicketForm() {
   var errs = new Array();
<?
foreach($fields as $f) {
  $field = $map->getFieldFromMap($view,$f);
  // we don't want to validate any hidden fields using javascript, this is
  // a potential problem.
  if( $field['is_required'] && $field['is_visible'] && $field['field_type'] != 'label' ) {
    $label = $map->getLabel($view,$f);
    $tr = $zen->fixJSVal(tr("? is required",array(tr($label))));
    print "\tif( !validateField(document.ticketForm.$f) ) { errs[errs.length] = $tr; }\n";
  }
}
if ($td && $zen->settings['edit_reason_required']=='on' && $zen->settings['log_edit']=='on') {
    $tr = $zen->fixJSVal(tr("? is required",array(tr("Edit Reason"))));
    print "\tif( !validateField(document.ticketForm.edit_reason) ) { errs[errs.length] = $tr; }\n";
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
