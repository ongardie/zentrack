<?
  /*
  **  EDIT BEHAVIOR
  **  
  **  Modifies an existing behavior
  **
  */
  
  
  include("admin_header.php");
  if( $TODO == 'DONE' ) {
    $skip = 1;
  } else {
    $page_title = ( $TODO == "NEW" )? "New Behavior" : "Edit Behavior";
    if ( $TODO != "NEW" ) {
      $beh_arr = $zen->getBehaviorList(array($behavior_id));
      if( is_array($beh_arr) ) {
        $behavior=$beh_arr[$behavior_id];
        $TODO = "EDIT";
        extract($behavior);
      } else {
        $skip=2;
      }
    }
  }

  $field_list=$zen->getBehaviorDestinationFieldsArray();

  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( $skip == 1 ) {
    include("$templateDir/adminMenu.php");
  } else if ( $skip == 2 ) {
    print "<ul><b>" . tr("That behavior could not be found") . "</b>";
    print "<br><a href='$rootUrl/admin/behaviors.php'>" . tr("Click Here to view available behaviors") . "</a></ul>\n";
  } else {
    include("$templateDir/behaviorAdd.php");
  }
                                                                                                                             
  include("$libDir/footer.php");

?>
