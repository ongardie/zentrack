<?
  /*
  **  EDIT DATA GROUP
  **  
  **  Modifies an existing data group
  **
  */
  
  
  include("admin_header.php");
  if( $TODO == 'Save' ) {
    if( $zen->demo_mode == "on" ) {
      $msg = tr("Process completed successfully. Groups were not updated since this is a demo site.");
      $skip = 1;
    } else {
      $j = 0;
      for( $i=0; $i<count($NewValue); $i++ ) {
        if( $NewUseInGroup[$i] ) {
          $groupDetailItem = array(
                "value"       => $NewValue[$i],
                "sort_order"  => $NewSortOrder[$i]
                                   );
          $updateParams[] = $groupDetailItem;
          $j++;
        }
      }
      $zen->updateDataGroupDetails($group_id, $updateParams) ;
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
    if ( strlen($group['table_name']) > 0 ) {
      $query     = "SELECT * FROM ".$group['table_name']." WHERE active=1";
      $elements  = $zen->db_query($query);
      include("$templateDir/groupDetailsForm.php");
    }
    else {
      include("$templateDir/customGroupDetailsForm.php");
    }
  } else {
    include("$templateDir/adminMenu.php");
  }
  include("$libDir/footer.php");


?>
