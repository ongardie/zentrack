<?{

  /*
  **  EDIT TASKS
  **  
  **  Edit/create/delete the tasks
  **
  */  

  include("./admin_header.php");

  if( $TODO == 'MORE' ) {
    $more = $more+3;
  } else if( $TODO == 'LESS' ) {
    $more = $more-3;
  }

  if( $TODO == 'MORE' || $TODO == 'LESS' ) {
    for( $i=0; $i<count($newName); $i++ ) {
      if( !$newName[$i] && $newID[$i] ) {
	$n = $newID[$i];
	$newName[$i] = $zen->bins["$n"];
      }
      if( $newName[$i] ) {
	$vars[] = array(
			"task_id"      => $newID[$i],
			"name"     => $newName[$i], 
			"priority" => $newPri[$i], 
			"active"   => $newActive[$i]
			);
      }
    }
  } else if( $TODO == 'Save' ) {
    if( !is_array($newName) || !count($newName) ) {
      $errs[] = "There was nothing provided to update";
    } else if( $zen->demo_mode == "on" ) {
      $msg = "Process completed successfully.  Tasks were not updated since this is a demo site.";
      $skip = 1;
    } else {
	$j = 0;
      for( $i=0; $i<count($newName); $i++ ) {
	if( $newName[$i] ) {
	  $updateParams = array( 
				"name"     => $newName[$i],
				"active"   => $newActive[$i],
				"priority" => "$newPri[$i]"
				);
	  $res = ($newID[$i])?
	    $zen->update_task($newID[$i], $updateParams) :
	    $zen->add_task($updateParams);
	  if( $res )
	    $j++;
	}
      }
      $msg = "$j tasks were saved to the database. Updates complete";
      $skip = 1;
    }
  } else {
    $vars = $zen->getTasks(1,0);
  }

  if( $more > 10 ) {
    $more = 10;
  } else if( $more < 0 ) {
    $more = 0;
  }

  $page_title = ($skip)? "Admin Section" : "Update Tasks";
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( !$skip ) {  
    $type = "task";
    $id_type = "task_id";
    include("$templateDir/configForm.php");
  } else {
    include("$templateDir/adminMenu.php");
  }
  
  include("$libDir/footer.php");

}?>









