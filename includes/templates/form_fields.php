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
   *   $varfield - the custom field values
   *   $td - true if this is an edit form, false if it is a new ticket
   */
   
   /**
    * GENERATES an addbox, which is a special field used to enter values in a
    * form that will require a lookup and special processing later. Addbox is
    * currently only implemented for the ticket_create screen's notify list.
    * 
    * Using it for other things could be catastrophic.
    *
    * @param ZenFieldMapRenderContext $context
    */
   function renderAddbox($context) {
     global $templateDir;
     include("$templateDir/addBoxForm.php");
   }
   
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
  foreach($fields as $f) {
    $field = $map->getFieldFromMap($formview,$f);
    $t = $field['field_type'];
    // addboxes can't be stored as hidden values -- not implemented
    if( !$field['is_visible'] && $t != 'addbox' ) { $hidden_fields[] = $f; }
    else { 
      $visible_fields[] = $f;
    }
  }
  
  $context = new ZenFieldMapRenderContext($context_vals);
  foreach($hidden_fields as $f) {
    $context->set('field', $f);
    if (strcmp($f,"contacts")==0) {
      $contact_ids = array();
      if (is_array($contacts)) {
        foreach ($contacts as $contact) {
          $contact_ids[]=$contact['type'].'-'.$contact['cp_id'];
        }
      } else {
        $contact_ids[]=$contacts;
      }
      $context->set('value', join(',',$contact_ids));
    } else if (strpos($f,"custom")===false) {
      $context->set('value', $ticket[$f]);
    } else {
      $context->set('value', $varfields[$f]);
      //$context->set('value', $varfield_params[$f]);
    }
    print $map->renderTicketField($context);
  }
  
  $searchbox_vals = array();
  
  $context = new ZenFieldMapRenderContext($context_vals);
  $context->set('force_label', $override_as_label);
  foreach($visible_fields as $f) {
    $context->set('field', $f);
    $type = $map->getFieldProp($formview, $f, 'field_type');
    if( $type == 'addbox' ) {
      // no stored values for contact boxes
      $context->set('value', '');
    }
    else if (strcmp($f,"contacts")==0) {
      $contact_ids = array();
      if (is_array($contacts)) {
        foreach ($contacts as $contact) {
          $contact_ids[]=$contact['type'].'-'.$contact['cp_id'];
        }
      } else {
        $contact_ids[]=$contacts;
      }
      $context->set('value', $contact_ids);
    } else if (strpos($f,"custom")===false) {
      $context->set('value', $ticket[$f]);
    } else {
      $context->set('value', $varfields[$f]);
    }
    if( $type == 'section' ) {
      print "<tr><td colspan='2' class='headerCell indent'>";
      print $map->renderTicketField($context);
      print "</td></tr>\n";
    }
    else {
      $maplabel = $map->getLabel($formview, $f);
      if( $map->isReadOnlyField($formview, $f, $context) ) {
        $hk = false;
      }
      else if( $type == 'searchbox' ) {
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
        if( $type == 'searchbox' ) {
          if ( strcmp($f,'contacts')==0 && $contacts) {
            $searchbox_vals[$f] = $contact_ids;
          } else if( $ticket[$f] ) {
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
    print renderSearchboxJs($formview, $form_name, $searchbox_vals);
  }
?>
