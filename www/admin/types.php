<?{

  /*
  **  EDIT TYPES
  **  
  **  Edit/create/delete the types
  **
  */  

  include("admin_header.php");

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
			"type_id"      => $newID[$i],
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
      $msg = tr("Process completed successfully.  Types were not updated since this is a demo site.");
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
	    $zen->update_type($newID[$i], $updateParams) :
	    $zen->add_type($updateParams);
	  if( $res )
	    $j++;
	}
      }
      $msg = tr("? types were saved to the database. Updates complete", array($j));
      $skip = 1;
    }
  } else {
    $vars = $zen->getTypes(1,0);
  }

  if( $more > 10 ) {
    $more = 10;
  } else if( $more < 0 ) {
    $more = 0;
  }

  $page_title = ($skip)? tr("Admin Section") : tr("Update Types");
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( !$skip ) {  
    $type = "type";
    $id_type = "type_id";
    include("$templateDir/configForm.php");
  } else {
    include("$templateDir/adminMenu.php");
  }
  
  include("$libDir/footer.php");

}?>









