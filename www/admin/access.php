<?{

  /*
  **  ADMIN INDEX PAGE
  **  
  **  Checks access and shows settings menus for qualified users
  **
  */
  
  
  include("./admin_header.php");

  // security
  $userID = ereg_replace("[^0-9]", "", $userID);
  // update database if submitted
  if( $TODO == 'Update' ) {
    unset($bins);
    if( is_array($binLevels) ) {
      foreach($binLevels as $k=>$v) {
        if( strlen($v) && $k ) {
	  if( strlen($bins["$k"]) ) {
	    $errs[] = "Two or more bins were submitted with the same name";
	    break;
	  }
          $bins["$k"] = $v;
        }
      }
    }
    for( $i=0; $i<count($newFields); $i++ ) {
      $k = $newFields[$i];
      if( strlen($newVals[$i]) && $k ) {
	if( strlen($bins["$k"]) ) {
	  $errs[] = "Two or more bins were submitted with the same name";
	  break;
	}
        $bins["$k"] = $newVals[$i];
      }
    }
    if( !$errs ) {
      if( $zen->demo_mode == "on" ) {
	$msg = "Process completed successfully.  No privileges were changed, because this is a demo site.";
	$skip = 1;
      } else if( !is_array($bins) || !count($bins) ) {
	$res = $zen->delete_access($userID);
	if( !$res ) {
	  $errs[] = "System Error: could not update access &#151; this is most "
	    ."likely because no bins were set, and no bins previously "
	    ."existed (i.e. nothing happened)";
	} else {
	  $msg = "All bins were removed from access for user $userID";
	  $skip = 1;
	}
      } else {
	$res = $zen->update_access($userID, $bins);
	if( !$res ) {
	  $errs[] = "System Error: could not update access for user $userID";
	} else {
	  $skip = 1;
	  $msg = "Custom Access priviledges updated for user $userID";
	}
      }
    }
    if( !$skip )
      $TODO = 'LESS';
  }

  // show the page
  $page_tile = "Admin Section";
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( $userID && !$skip ) {
    include("$templateDir/accessForm.php");
  } else {
    include("$templateDir/adminMenu.php");
  }

  include("$libDir/footer.php");

}?>