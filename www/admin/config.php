<?{

  /*
  **  ADMIN SETTINGS PAGE
  **  
  **  Change zenTrack system settings
  **
  */
  
  
  include("./admin_header.php");
  $page_title = "Configuration Settings";

  $settings = $zen->getSettings(1);
  if( $TODO == 'Save' ) {
    unset($newparams);
    if( !is_array($newSettings) ) {
      $errs[] = "No settings were recieved";
    } else {
      foreach($settings as $s) {
	// don't error check, or change things ending in _xx
	if( preg_match("@_xx$@", $s["name"]) )
	  continue;
	$k = $s["setting_id"];
	$newSettings["$k"] = $zen->stripPHP($newSettings["$k"]);
	if( strlen($newSettings["$k"]) < 1 ) {
	  $errs[] = "$k must have a value, use zero instead of a blank";
	} else if( ($s["value"] == "on" || $s["value"] == "off") 
		   &&
		   ($newSettings["$k"] != "on" && $newSettings["$k"] != "off") 
		 ) {
	  $errs[] = "$k must be set to 'on' or 'off'"; 
	} else if( preg_match("#^url_#", $s["name"]) ) {
	  $newSettings["$k"] = preg_replace("#^$rootUrl/?#i", "", $newSettings["$k"]);
	  $v = preg_replace("#^$rootUrl/?#i", "", $s["value"]);
	  if( $v != $newSettings["$k"] ) {
	    $newparams["$k"] = $newSettings["$k"];
	  }
	} else if( $newSettings["$k"] != $s["value"] ) {
	  $newparams["$k"] = $newSettings["$k"];
	}
      }
      if( !is_array($newparams) ) {
	$errs[] = "There were no changes made to the settings.  Procedure skipped.";
      }

      if( !$errs ) {
	$j = 0;
	if( $zen->demo_mode == "on" ) {
	  $msg = "Process completed successfully.  No changes were made, because this is a demo site.";
	  $skip = 1;
	} else {
	  foreach($newparams as $k=>$v) {
	    if( strlen($v) ) {
	      $res = $zen->update_setting($k, array("value"=>$v));
	      if( $res )
		$j++;
	    }
	  }
	  if( $j )
	    $zen->settings = $zen->getSettings();
	  $msg = "$j of ".count($newparams)." settings changed were successfully updated";
	  $skip = 1;
	}
      }
    }
  }

  if( !$skip ) {
    $page_tile = $zen->settings["system_name"]." Settings";
    include("$libDir/nav.php");
    $zen->printErrors($errs);
    include("$templateDir/configSettingsForm.php");
  } else {
    $page_title = "Admin Menu";
    include("$libDir/nav.php");
    include("$templateDir/adminMenu.php");
  }

  include("$libDir/footer.php");

}?>










