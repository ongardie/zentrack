<?
  /*
  **  EDIT DATA GROUP
  **  
  **  Modifies an existing data group
  **
  */
  
  
  include("admin_header.php");

  $page_tile = "Edit Data Group";
  include("$libDir/nav.php");

  $group         = $zen->get_data_group($group_id);
  $group_details = $zen->get_data_group_details($group_id);
  if ( !is_array($group_details) ) {
    $group_details=array();
  }
  $TODO = 'EDIT';
  if ( strlen($group['table_name']) > 0 ) {
    include("$templateDir/groupDetailsForm.php");
  }
  else {
    include("$templateDir/customGroupDetailsForm.php");
  }
  include("$libDir/footer.php");

?>
