<?{

  /*
  **  EDIT PRIORITIES
  **  
  **  Edit/create/delete the priorities
  **
  */  

  include("admin_header.php");

  if( $TODO == 'MORE' ) {
    $more = $more+3;
  } else if( $TODO == 'LESS' ) {
    $more = $more-3;
  }

  $vars = array();
  if( $TODO == 'MORE' || $TODO == 'LESS' ) {
    for( $i=0; $i<count($newName); $i++ ) {
      if( !$newName[$i] && $newID[$i] ) {
	$n = $newID[$i];
	$newName[$i] = $zen->bins["$n"];
      }
      if( $newName[$i] ) {
	$vars[] = array(
			"pid"      => $newID[$i],
			"name"     => $newName[$i], 
			"priority" => $newPri[$i], 
			"active"   => $newActive[$i]
			);
      }
    }
  } else if( $TODO == 'Save' ) {
    if( !is_array($newName) || !count($newName) ) {
      $errs[] = tr("There was nothing provided to update");
    } else if( $zen->demo_mode == "on" ) {
      $msg = tr("Process completed successfully.  Priorities were not updated since this is a demo site.");
      $skip = 1;
    } else {
	$j = 0;
      for( $i=0; $i<count($newName); $i++ ) {
	if( $newName[$i] ) {
	  $updateParams = array( 
				"name"     => $newName[$i],
				"active"   => (strlen($newActive[$i])?$newActive[$i]:0),
				"priority" => (strlen($newPri[$i])?$newPri[$i]:0)
				);
	  $res = ($newID[$i])?
	    $zen->update_priority($newID[$i], $updateParams) :
	    $zen->add_priority($updateParams);
	  if( $res )
	    $j++;
	}
      }
      $msg = tr("? priorities were saved to the database. Updates complete", array($j));
      $skip = 1;
    }
  } else {
    $vars = $zen->getPriorities(1,0);
  }

  if( $more > 10 ) {
    $more = 10;
  } else if( $more < 0 ) {
    $more = 0;
  }

  $page_title = ($skip)? tr("Admin Section") : tr("Update Priorities");
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( !$skip ) {  
    $type = "priority";
    $id_type = "pid";
    include("$templateDir/configForm.php");
  } else {
    include("$templateDir/adminMenu.php");
  }
  
  include("$libDir/footer.php");

}?>









