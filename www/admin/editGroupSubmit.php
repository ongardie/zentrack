<?{
   
  /*
  **  EDIT GROUP SUBMIT
  **  
  **  Commits zenTrack data group modifications to db
  **
  */
  
  include("admin_header.php");
  $page_tile = tr("Edit Group Submit");

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
      $msg = tr("Process successful.  Group was not updated, because this is a demo site.");
    } else {
      $res = $zen->updateDataGroup($group_id,$NewGroupName,$NewTableName,
				   $NewEvalType,$NewEvalText,
				   ( strlen($NewDescript) )?$NewDescript : "NULL");
      if( $res ) {
	// update session info with changes
	$vars = $zen->generateDataGroupInfo( array($group_id) );
	$_SESSION['data_groups'][$group_id] = $vars[$group_id];

	// print useful messages for user
	$msg = tr("Group '?' was updated successfully. ? to customize group '?'s details.",
		  array($NewGroupName,
			"--link--",
			$NewGroupName));
	$msg = str_replace("--link--","<br><a href='$rootUrl/admin/editGroupDetails.php?group_id=$group_id'>"
			   .tr("Click Here")."</a>",$msg);
      } else {
	$errs[] = tr("System Error: Could not update ?", array($NewGroupName));
      }
    }
  }

  include("$libDir/nav.php");
  if( $errs ) {
    $zen->printErrors($errs);
    $TODO = 'EDIT';
    include("$templateDir/groupAdd.php");
  } else {
    include("$templateDir/groupForm.php");
  }

  include("$libDir/footer.php");

}?>
