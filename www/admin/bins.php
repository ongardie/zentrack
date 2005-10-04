<?{

  /*
  **  EDIT BINS
  **  
  **  Edit/create/delete the bins
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
    for( $i=0; $i<count($newBin); $i++ ) {
      if( !$newBin[$i] && $newID[$i] ) {
	$n = $newID[$i];
	$newBin[$i] = $zen->bins["$n"];
      }
      if( $newBin[$i] ) {
	$vars[] = array(
			"bid"      => $newID[$i],
			"name"     => $newBin[$i], 
			"priority" => $newPri[$i], 
			"active"   => $newActive[$i]
			);
      }
    }
  } else if( $TODO == 'Save' ) {
    if( !is_array($newBin) || !count($newBin) ) {
      $errs[] = tr("There was nothing provided to update");
    } else if( $zen->demo_mode == "on" ) {
      $msg = tr("Process completed successfully.  Bins were not updated since this is a demo site.");
      $skip = 1;
    } else {
	$j = 0;
      for( $i=0; $i<count($newBin); $i++ ) {
	if( $newBin[$i] ) {
	  $updateParams = array( 
		"name"     => $newBin[$i],
		"active"   => (strlen($newActive[$i])? $newActive[$i]:0),
		"priority" => (strlen($newPri[$i])? $newPri[$i]:0)
				);
	  $res = ($newID[$i])?
	    $zen->update_bin($newID[$i], $updateParams) :
	    $zen->add_bin($updateParams);
	  if( $res )
	    $j++;
	}
      }
      $msg = tr("? bins were saved to the database. Updates complete", array($j));
      $skip = 1;
    }
  } else {
    $vars = $zen->getBins(1,0);
  }

  if( $more > 10 ) {
    $more = 10;
  } else if( $more < 0 ) {
    $more = 0;
  }

  $page_title = ($skip)? tr("Admin Section") : tr("Update Bins");
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( !$skip ) {    
    $type = "bin";
    $id_type = $zen->getTableId('bins');
    include("$templateDir/configForm.php");
  } else {
    include("$templateDir/adminMenu.php");
  }
  
  include("$libDir/footer.php");

}?>









