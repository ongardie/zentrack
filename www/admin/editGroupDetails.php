<?
  /*
  **  EDIT DATA GROUP
  **  
  **  Modifies an existing data group
  **
  */
  
  
  include("admin_header.php");

  if( $TODO == 'MORE' ) {
    $more = $more+3;
  } else if( $TODO == 'LESS' ) {
    $more = 0;
  }

  $elements=array();

//When the action is MORE or LESS, we fill the elements array with the values from the Form
//This only can happen when using a Custom-type group, because standard table groups cannot
//trigger these kind of actions
  if( $TODO == 'MORE' || $TODO == 'LESS' ) {
    for( $i=0; $i<count($NewValue); $i++ ) {
      if( $NewValue[$i] && strlen($NewValue[$i])>0 && $NewValue[$i] != "-new-" ) {
        $elements[] = array(
                        "value"      => $NewValue[$i],
                        "sort_order" => $NewSortOrder[$i]
                        );
      }
    }
  } else if( $TODO == 'Save' ) {
//When the action is Save and demo_mode is on, we don't save the changes to the database
    if( $zen->demo_mode == "on" ) {
      $msg = tr("Process completed successfully. Groups were not updated since this is a demo site.");
      $skip = 1;
    } else {
      $j = 0;
//When the action is Save and we are using a standard table type group we fill the elements array this way:
      if ( strlen($group['table_name']) > 0 ) {
        for( $i=0; $i<count($NewValue); $i++ ) {
          if( $NewUseInGroup[$i] ) {
            $elements[] = array(
                  "value"       => $NewValue[$i],
                  "sort_order"  => $NewSortOrder[$i]
                                );
            $j++;
          }
        }
      } else {
//When the action is Save and we are using a custom type group we fill the elements array this way:
        for( $i=0; $i<count($NewValue); $i++ ) {
          if( $NewValue[$i] && strlen($NewValue[$i])>0 && $NewValue[$i]!="-new-" && !$NewDelete[$i] ) {
            $elements[] = array(
                  "value"       => $NewValue[$i],
                  "sort_order"  => $NewSortOrder[$i]
                                );
            $j++;
          }
        }
      }
//Last commands for the Save action when demo_mode is not on:
      $zen->updateDataGroupDetails($group_id, $elements) ;
      $msg = tr("? elements were saved in the selected group. Updates complete", array($j));
      $skip = 1;
    }
  }
  $page_title = ($skip)? tr("Admin Section") : tr("Edit Data Group");
  include("$libDir/nav.php");
  $zen->printErrors($errs);

  if( !$skip ) {
    $group         = $zen->get_data_group($group_id);
    $group_details = $zen->get_data_group_details($group_id);
    if ( !is_array($group_details) ) {
      $group_details=array();
    }
    $TODO = 'EDIT';
//When we are editing a standard table type group we fill the elements array this way and call
//the groupDetailsForm template
    if ( strlen($group['table_name']) > 0 ) {
      $query     = "SELECT * FROM ".$group['table_name']." WHERE active=1";
      $elements  = $zen->db_query($query);
      include("$templateDir/groupDetailsForm.php");
    }
    else {
//When we are editing a custom type group we fill the elements array this way and call
//the customGroupDetailsForm template
      foreach ($group_details as $i) {
        if ( $i['value'] && strlen($i['value'])>0 && $i['value']!="-new-" ) {
          $elements[]=$i;
        }
      }
      include("$templateDir/customGroupDetailsForm.php");
    }
  } else {
    include("$templateDir/adminMenu.php");
  }
  include("$libDir/footer.php");


?>
