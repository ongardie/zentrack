<?{
  /**
   * Parses form input and creates an array called $varfield_params which contains the values needed
   * to run $zen->updateVarfieldVals()
   *
   * Depends on the following variables to determine which custom fields are used:
   *   $customFieldsArray - the results of $zen->getCustomFields() call
   */

  $varfield_fields = array();
  foreach($customFieldsArray as $f) {
    $k = $f['field_name'];
    $v = $f['field_label'];
    $r = $f['is_required'];
    $varfield_type = ereg_replace("[^a-z_]", "", $k);
    switch($varfield_type) {
    case "custom_number":
      if( !strlen($$k) ) {
	$cfv = 'NULL';
	$cft = 'ignore';
      } else {
	$cfv = $$k;
	$cft = "int";
      }
      break;
    case "custom_date":
      if( !strlen($$k) ) {
	$cfv = 'NULL';
	$cft = "ignore";
      }
      else {
	$cfv = $zen->dateParse($$k);
	$cft = "int";
      }
      break;
    default:
      $cfv = $$k;
      $cft = "text";
      break;
    }
    $varfield_fields[$k] = $cft;
    $$k = $cfv;
    // check for required fields
    if ($r && !$$k) {
      $errs[] = ucfirst($v)." ".tr("is a required field");
    }
  }

  $varfield_params = array();
  if( !$errs ) {
    $zen->cleanInput($varfield_fields);
    // create an array of existing fields
    foreach(array_keys($varfield_fields) as $f) {
      $varfield_params["$f"] = $$f;
    }    
  }
  
}?>