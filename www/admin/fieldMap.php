<?

  /*
  **  EDIT FIELD MAP
  **  
  **  Edit/create/delete/sort entries in the field map
  **
  */
  
  include("admin_header.php");
  $page_title = tr("Edit Field Map");
  include("$libDir/nav.php");
  function fmGetSet( $name, $key, $type = '' ) {
    // don't make updates on rows that don't exist (we may skip some fields occasionally
    if( !array_key_exists($name, $_POST) ) {
      return;
    }
    // get the updates array
    global $updates;
    global $zen;
    // process the type
    $t = substr($type,0,1);
    // handle fields which don't get posted (booleans which are not checked)
    if( !array_key_exists($key, $_POST[$name]) ) { 
      $updates[$name][$key] = $t == 'b'? 0 : null;
      return;
    }
    // format the value
    switch( $t ) {
      case "i": //int
        $v = $zen->checkNum($_POST[$name][$key]);
        break;
      case "b": //boolean
        $v = $_POST[$name][$key]? 1 : 0;
        break;
      case "t": //text
        $v = strip_tags($_POST[$name][$key]);
        break;
      default:
        $v = $_POST[$name][$key];
    }
    $updates[$name][$key] = $v;
  }
  
  if( !$view || !in_array($view, array_keys($GLOBALS['zt_field_dependencies']['views'])) ) {
    $view = 'ticket_create';
  }
  
  if( $TODO == 'save' ) {
    $deletes = array();
    $inserts = array();
    $vprops = getFmViewProps($view);

    // copy values for editing
    $allFields = $map->getFieldMap();
    $updates = $allFields[$view];
    unset($allFields);
    //Zen::printArray($_POST, 'POST_VALS');
    
    $fields = $map->listFieldsForView($view);
    foreach($fields as $f) {
      // collect field properties
      $field = $map->getFieldFromMap($view, $f);
      $tprops = getFmTypeProps($field['field_type']);
      
      // remove deleted sections
      if( $field['field_type'] == 'section' && !isset($_POST[$f]) ) {
        $deletes[$f] = $field['field_map_id'];
      }
      // skip rows that aren't sent
      else if( !isset($_POST[$f]) ) { continue; }
      
      // field_label
      fmGetSet($f, 'field_label', 'text');
      // is_visible
      fmGetSet($f, 'is_visible', 'boolean');

      // num_cols
      fmGetSet($f, 'num_cols', 'int');
      
      // num_rows
      if( !$tprops['multiple'] && !$vprops['multiple'] ) {
        $updates[$f]['num_rows'] = 1;
      }
      else { fmGetSet($f, 'num_rows', 'int'); }

      // the rest does not apply to sections
      if( $field['field_type'] == 'section' ) { continue; }
      
      // properties for this field
      $fprops = getFmFieldProps($view, ZenFieldMap::fieldName($f));

      // field_type is automagic for view_only
      if( $vprops['view_only'] ) { $updates[$f]['field_type'] = 'label'; }
      // we don't give the user an option on the form, so don't bother here either
      else if( count($fprops['types']) == 1 ) { $updates[$f]['field_type'] = $fprops['types'][0]; }
      else if( array_key_exists('field_type', $_POST[$f]) &&
               !in_array($_POST[$f]['field_type'], $fprops['types']) ) {
        // here we have a problem, someone has tried to set a type that is
        // not valid
        $errs[] = "$f cannot be set to field_type '".$_POST[$f]['field_type']."'";
      }
      // otherwise we post it normally
      else if( array_key_exists('field_type', $_POST[$f]) )
        { fmGetSet($f, 'field_type'); }
      
      // is_required
      if( $vprops['view_only'] ) { $updates[$f]['is_required'] = false; }
      else if( $view == 'search_form' ) { $updates[$f]['is_required'] = false; }
      else if( $fprops['always_required'] ) { $updates[$f]['is_required'] = true; }
      else { fmGetSet($f, 'is_required', 'boolean'); }
      
      // default_val has some special considerations
      if( !$vprops['view_only'] ) {
        if( $fprops['default'] ) { fmGetSet($f, 'default_val'); }
      }
    }
    
    foreach($_POST as $k=>$v) {
      if( strpos($k, 'section') === 0 && $vprops['sections'] && !array_key_exists($k,$updates) ) {
        // skip section0, it's a template
        if( $k == 'section0' ) { continue; }
        // add the style
        $inserts[$k] = array(
          "field_name"  => $k,
          "field_label" => strip_tags($_POST[$k]['field_label']),
          "is_visible"  => $_POST[$k]['is_visible']? 1 : 0,
          "which_view"  => $view,
          "sort_order"  => 500,
        );
      }
    }

    // set the sort order
    $i = 1;
    asort($_POST['orderset']);
    foreach( $_POST['orderset'] as $k=>$v ) {
      if( array_key_exists($k, $updates) ) {
        $updates[$k]['sort_order'] = $i++;
      }
      else if( array_key_exists($k, $inserts) ) {
        $inserts[$k]['sort_order'] = $i++;
      }
    }

    $total = count($updates) + count($inserts) + count($deletes);
    if( !$total && !$errs ) {
      $errs[] = "Nothing to update";
    }
    if( !$errs ) {
      $res = $map->updateFieldMap($view, $updates, $inserts, $deletes);
      print "<p><b>$res[0] of $res[1] updates were saved</b></p>\n";
    }
    
    //cfalonso changed the following line with the next 3 because it didn't work properly:
    //$fields = $updates;
    $fields = $map->getFieldMap($view);
    //Zen::printArray($orderset,'RECEIVED ORDERSET');
    //Zen::printArray($updates,'UPDATES');
    //Zen::printArray($inserts,'INSERTS');
    //Zen::printArray($deletes,'DELETES');
    
  }
  else {
    $fields = $map->getFieldMap($view);
  }
  
  $zen->printErrors($errs);

  include("$templateDir/fieldMapForm.php");
  
  include("$libDir/footer.php");


?>
