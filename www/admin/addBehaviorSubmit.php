<?{
   
  /*
  **  ADD BEHAVIOR SUBMIT
  **  
  **  Commits new zenTrack behavior to db
  **
  */
  
  include("admin_header.php");
  $page_tile = tr("Add Behavior Submit");

  if( !$active )
    $active = 0;

  $behavior_fields = array(
                             "NewBehaviorName"       => "string",
                             "NewGroupId"            => "int",
                             "NewIsEnabled"          => "int",
                             "NewSortOrder"          => "int",
                             "NewFieldName"          => "alphanum",
                             "NewMatchAll"           => "int",
                             "NewFieldEnabled"       => "int"
                             );

  $behavior_required = array("NewBehaviorName",
                             "NewGroupId",
                             "NewIsEnabled",
                             "NewSortOrder",
                             "NewFieldName",
                             "NewFieldEnabled",
                             "NewMatchAll");

  $zen->cleanInput($behavior_fields);
  foreach($behavior_required as $d) {
    if( !strlen($$d) ) {
      $errs[] = tr("All the fields are required");
    }
  }


  if( !$errs ) {
    if( $zen->demo_mode == "on" ) {
      $msg = tr("Process successful.  Behavior was not added, because this is a demo site.");
    } else {
      $updflds = array(
                  "behavior_name" => $NewBehaviorName,
                  "group_id"      => $NewGroupId,
                  "is_enabled"    => $NewIsEnabled,
                  "sort_order"    => $NewSortOrder,
                  "field_name"    => $NewFieldName,
                  "field_enabled" => $NewFieldEnabled,
                  "match_all"     => $NewMatchAll
                       );
      $res = $zen->addBehavior($updflds,array());
      if( $res ) {
	$msg = tr("Behavior ? was added successfully. ? to customize behavior ?'s details.",
		  array($NewBehaviorName,
			"--link--",
			$NewBehaviorName));
	$msg = str_replace("--link--","<br><a href='$rootUrl/admin/editBehaviorDetails.php?behavior_id=$res'>"
			   .tr("Click Here")."</a>",$msg);
      } else {
	$errs[] = tr("System Error: Could not add ?", array($NewBehaviorName));
      }
    }
  }

  include("$libDir/nav.php");
  if( $errs ) {
    $zen->printErrors($errs);
    include("$templateDir/behaviorAdd.php");
  } else {
    include("$templateDir/behaviorMenu.php");
  }

  include("$libDir/footer.php");

}?>
