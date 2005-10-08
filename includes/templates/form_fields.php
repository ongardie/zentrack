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

  if( strlen($ticket['deadline']) ) { $ticket['deadline'] = $zen->showDateTime($ticket['deadline']); }
  if( strlen($ticket['start_date']) ) { $ticket['start_date'] = $zen->showDateTime($ticket['start_date']); }
  if( strlen($ticket['ctime']) ) { $ticket['ctime'] = $zen->showDateTime($ticket['ctime']); }
  if( strlen($ticket['otime']) && $td ) { $ticket['otime'] = $zen->showDateTime($ticket['otime']); }

  //$formview = $td? 'ticket_edit' : 'ticket_create';
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
  
  foreach($hidden_fields as $f) {
    print $map->renderTicketField($formview, $form_name, $f, $ticket[$f]);
  }
  
  foreach($visible_fields as $f) {
    if( in_array($f, $sections) ) {
      print "<tr><td colspan='2' class='subTitle indent'>";
      print $map->renderTicketField($formview, $form_name, $f);
      print "</td></tr>\n";
    }
    else {
      print "<tr><td class='bars'>";
      print $map->getLabel($formview, $f);
      print "</td><td class='bars'>";
      if( $td && $page_type == 'project' && $f == 'type_id' ) {
        // do not allow type to be edited for projects
        print $map->getTextValue($formview, $f, $ticket[$f]);
      }
      else {
        print $map->renderTicketField($formview, $form_name, $f, $ticket[$f], null, $override_as_label);
      }
      print "</td></tr>\n";
    }
  }

?>