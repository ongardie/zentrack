<?{
   
  /*
  **  ADD GROUP SUBMIT
  **  
  **  Commits new zenTrack data group to db
  **
  */
  
  include("admin_header.php");
  $page_tile = tr("New Group Submit");

  if( !$active )
    $active = 0;

  $data_group_fields = array(
                             "NewTableName"       => "alphanum",
                             "NewGroupName"       => "html",
                             "NewDescript"        => "html",
			     "NewEvalType"        => "alphanum",
			     "NewEvalText"        => "html"
                             );

  $data_group_required = array("NewGroupName");


  $zen->cleanInput($data_group_fields);
  foreach($data_group_required as $d) {
    if( !strlen($$d) ) {
      $errs[] = tr("Table Name and Group Name are required");
    }
  }

  if( !$errs ) {
    if( $zen->demo_mode == "on" ) {
      $msg = tr("Process successful.  Group was not added, because this is a demo site.");
    } else {
      $group_id = $zen->addDataGroup( $NewGroupName, $NewTableName, $NewDescript, 
				      $NewEvalType, $NewEvalText, array() );
      if( $group_id ) {
	$vars = $zen->generateDataGroupInfo( array($group_id) );
	$_SESSION['data_groups'][$group_id] = $vars[$group_id];
        $msg = tr("Group '?' (ID=?) was added successfully. ? to customize this group's details.",
                             array($NewGroupName, $group_id, "--link--" . tr("Click Here") . "</a>", $NewGroupName));
        $msg = str_replace("--link--", "<br><a href='$rootUrl/admin/editGroupDetails.php?group_id=$group_id'>", $msg);
      } else {
      $errs[] = tr("System Error: Could not add ? to the system", array($NewGroupName));
      }
    }
  }

  include("$libDir/nav.php");
  if( $errs ) {
    $zen->printErrors($errs);
    include("$templateDir/groupAdd.php");
  } else {
    include("$templateDir/groupForm.php");
  }

  include("$libDir/footer.php");

}?>
