<? if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**
   * Process fields which will appear in an editable ticket form.
   *
   * REQUIREMENTS:
   *   $zen - zenTrack
   *   $map - ZenFieldMap
   *   $formview - view we are creating (ticket_create, project_edit, ticket_tab_3, etc)
   *   $form_name - name of the html form
   *   $ticket - the ticket object containing values
   *   $td - true if this is an edit form, false if it is a new ticket
   */
   
  // calculate the bins which this user can access
  $access_level = $map->getViewProp($formview, 'access_level');
  $userBins = $zen->getUsersBins($login_id, $access_level);

  if( $ticket['deadline'] > 0 ) { $ticket['deadline'] = $zen->showDateTime($ticket['deadline']); }
  if( $ticket['start_date'] > 0 ) { $ticket['start_date'] = $zen->showDateTime($ticket['start_date']); }
  if( $ticket['ctime'] > 0 ) { $ticket['ctime'] = $zen->showDateTime($ticket['ctime']); }
  if( $ticket['otime'] > 0 && $td ) { $ticket['otime'] = $zen->showDateTime($ticket['otime']); }

  //$formview = $td? 'ticket_edit' : 'ticket_create';
  $context_vals = array('view' => $formview, 'form' => $form_name);
  $fields = $map->listFieldsForView($formview);
  $hidden_fields = array();
  $visible_fields = array();
  $sections = array();
  foreach($fields as $f) {
    $field = $map->getFieldFromMap($formview,$f);
    if( !$field['is_visible'] ) { $hidden_fields[] = $f; }
    else { 
      $visible_fields[] = $f;
      if( $field['field_type'] == 'section' ) { $sections[] = $f; }
    }
  }
  
  $context = new ZenFieldMapRenderContext($context_vals);
  foreach($hidden_fields as $f) {
    $context->set('field', $f);
    if (strpos($f,"custom")===false) {
      $context->set('value', $ticket[$f]);
    } else {
      $context->set('value', $$f);
    }
    print $map->renderTicketField($context);
  }
  
  $searchbox_vals = array();
  
  $context = new ZenFieldMapRenderContext($context_vals);
  $context->set('force_label', $override_as_label);
  foreach($visible_fields as $f) {
    $context->set('field', $f);
    if (strpos($f,"custom")===false) {
      $context->set('value', $ticket[$f]);
    } else {
      $context->set('value', $$f);
    }
    if( in_array($f, $sections) ) {
      print "<tr><td colspan='2' class='headerCell indent'>";
      print $map->renderTicketField($context);
      print "</td></tr>\n";
    }
    else {
      $maplabel = $map->getLabel($formview, $f);
      if( $map->isReadOnlyField($formview, $f, $context) ) {
        $hk = false;
      }
      else if( $map->getFieldProp($formview, $f, 'field_type') == 'searchbox' ) {
        $hk = $hotkeys->activateSearchbox($maplabel, $form_name, $f);
      }
      else {
        $hk = $hotkeys->activateField($maplabel, $form_name, $f);
      }
      print "<tr><td class='bars'>";
      print $hk? $hk->getLabel() : $maplabel;
      if( $map->getFieldProp($formview, $f, 'is_required') ) { print "<span class='error bigBold'>*</span>"; }
      print "</td><td class='bars'>";
      if( $td && $page_type == 'project' && $f == 'type_id' ) {
        // do not allow type to be edited for projects
        print Zen::ffv($map->getTextValue($formview, $f, $ticket[$f]));
      }
      else {
        if( $map->getFieldProp($formview, $f, 'field_type') == 'searchbox' ) {
          if( $ticket[$f] ) {
            $searchbox_vals[$f] = explode(',',$ticket[$f]);
          }
          else {
            $searchbox_vals[$f] = false;
          }
        }
        print $map->renderTicketField($context);
      }
      print "</td></tr>\n";
    }
  }

  if( count($searchbox_vals) ) {
    print "<script type='text/javascript'>\n";
    print " var validateHidden = new Array();\n";
    print "addToOnload( function() { \n";
    foreach($searchbox_vals as $k=>$v) {
      print " validateHidden['$k'] = true;\n";
      if( !$v ) { continue; }
      foreach($v as $val) {
        if( $k == 'project_id' || $k == 'ticket_id' || $k == 'relations' ) {
          $t = $zen->get_ticket($val);
          $text = Zen::ffv($t['title']);
        }
        else {
          $text = Zen::ffv($map->getTextValue($formview, $k, $val));
        }
        print "  addSearchboxVal(";
        print $zen->fixJsVal($form_name).",";
        print $zen->fixJsVal($k).",";
        print $zen->fixJsVal($val).",";
        print $zen->fixJsVal($text).',';
        print $map->hasMultipleValues($formview, $k)? 1 : 0;
        print ");\n";
      }
    }
    print "} );";
    print "</script>\n";
  }
?>