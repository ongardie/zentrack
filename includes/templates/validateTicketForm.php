<?  
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**
   PREREQUISITES:
     (ZenFieldMap)$map - contains properties for fields
     (string)$formview - the current view (probably project_create or ticket_create)
     (string)$page_type - (optional) either 'ticket' or 'project'
  **/
  $fields = $map->getFieldMap($formview);
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
      case "radio":
      case "select-multiple":
        var val = 0;
        for (i=0; i<obj.options.length; i++) {
          if (obj.options[i].selected) {
            val++;
          }
        }
        return val>0;
      case "hidden":
        if( validateHidden && validateHidden[obj.name] ) {
          return obj.value != null && obj.value.length; 
        }
      case "button":
      case "submit":
      case "password":
      case "reset":
      default:
        return true;
    }
 }

 function validateTicketForm(formObj) {
   var errs = new Array();
<?
foreach($fields as $f=>$field) {
  // we don't want to validate any hidden fields using javascript, this is
  // a potential problem.
  if( $field['is_required'] && $field['is_visible'] && $field['field_type'] != 'label'
      && $f != 'status') {
    $label = $map->getLabel($formview,$f);
    $tr = $zen->fixJSVal(tr("? is required",array(tr($label))));
    if ($map->fieldName($f) == 'custom_multi') {
      $fm=$f.'[]';
    } else {
      $fm=$f;
    }
    print "\tif( !validateField(formObj.elements['$fm']) ) { errs[errs.length] = $tr; }\n";
  }
}
if ( ($formview == 'ticket_edit' || $formview == 'project_edit') && 
      $zen->settingOn('edit_reason_required') && $zen->settingOn('log_edit') ) {
    $tr = $zen->fixJSVal(tr("? is required",array(tr("Edit Reason"))));
    print "\tif( !validateField(formObj.elements['edit_reason']) ) { errs[errs.length] = $tr; }\n";
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
