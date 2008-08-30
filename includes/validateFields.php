<?{
  
  /*
  ** Validates input fields for add/edit operations
  **
  ** Depends on the following variables:
  **    (String)$view - the view which will be passed into the field map
  **    (ZenFieldMap)$map - the field map to collect field info from
  **
  ** Creates the following variables:
  **    (Array)$fields - key/value pairs of (String)field => (String)data_type
  **    (Array)$required - array of (String)field names which are required for this view
  **    (Array)$varfields - contains the values needed to run $zen->updateVarfieldVals() (if any)
  */
  if( !ZT_DEFINED ) { die("Illegal Access"); }
  
  $fields = array();
  $varfields = array();
  $required = array();
  $customFieldsArray = false;
  $customFieldsArray = $map->getFieldMap($view);
  $fprops = getFmFieldProps($view);
  if(is_array($customFieldsArray)) {
    foreach($customFieldsArray as $f=>$field) {
      // don't include sections
      if( $field['field_type'] == 'section' ) { continue; }
      // titles need to be truncated to correct length
      if( $f == 'title' && strlen($$f) > 250 ) {
        $params["$f"] = substr($$f,0,250);
      }
      // parse dates
      if( $fprops["$f"]['data_type'] == 'date' ) {
        $$f = $$f > 0? $zen->dateParse($$f) : null;
      }
      
      //if( !$field['is_visible'] ) { continue; }
      if( $field['is_required'] || $fprops["$f"]['always_required'] ) {
        $required[] = $f;
      }
      if ( ZenFieldMap::isVariableField($f) ) { $varfields["$f"] = $field; }
      else if( $f == 'relations' ) { $fields["$f"] = 'ignore'; }
      else if( $f != 'contacts' )  { $fields["$f"] = $fprops["$f"]['data_type']; }
    }
  }

  $zen->cleanInput($fields);
  
  if( !empty($relations) ) {
    // relations need special attention to insure all the values are valid ids
    $relations = is_array($relations)? $relations : explode(',',$relations);
    for($i=0; $i<count($relations); $i++) {
      $relations[$i] = $zen->checkNum($relations[$i]);
    }
    $relations = join(',',$relations);
  }
  
  // insure that the user/bin combination provided is allowed
  // we aren't worried about user/bin combinations if the user will be stripped
  $c = $view != 'ticket_close' || $zen->settingOn('retain_owner_closed');
  if( $c && $user_id && !$zen->checkAccess($user_id, $bin_id, 'level_user') ) {
    $errs[] = tr('The user assigned to this ticket does not have '.
                 'level_user priviledges for the selected bin (?)', $zen->getBinName($bin_id));
  }
  
  // do not allow self referencing tickets
  if( isset($id) && isset($project_id) && $id && $id == $project_id ) {
    $errs[] = tr("The parent project cannot be set to this project (itself)");
  }
  
  // check for required fields
  foreach($required as $r) {
    if( !strlen($$r) || (ZenFieldMap::noZeroVal($r) && $$r === 0) ) {
      $errs[] = tr("Required field missing:") . " " . ucfirst($r);
    }
  }
  
  // parse variable fields which appear in new ticket screen, 
  // store them in $varfields
  // insure that all requirements are met before proceeding
  // with the ticket save process
  if( count($varfields) ) {
    include("$libDir/parseVarfields.php");
  }
  
}?>
