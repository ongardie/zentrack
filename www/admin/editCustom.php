<?{

  /*
  **  EDIT CUSTOM FIELDS DEFINITION
  **  
  **  Edit the definition of the custom fields
  **
  */
  

  include("admin_header.php");

  $vars = array();
  if( $TODO == 'Save' ) {
    if( !is_array($newFieldLabel) || !count($newFieldLabel) ) {
      $errs[] = tr("There was nothing provided to update");
    } else if( $zen->demo_mode == "on" ) {
      $msg = tr("Process completed successfully.  Changes were not updated since this is a demo site.");
      $skip = 1;
    } else {
	$j = 0;
      for( $i=0; $i<count($newFieldLabel); $i++ ) {
	if( $newFieldLabel[$i] ) {
          $varfield_check = array(
                            "newFieldName[$i]"      => "alphanum",
                            "newFieldLabel[$i]"     => "alphanum",
			    "newFieldValue[$i]"     => "text",
                            "newSortOrder[$i]"      => "int",
                            "newIsRequired[$i]"     => "int",
                            "newUseForProject[$i]"  => "int",
                            "newUseForTicket[$i]"   => "int",
                            "newShowInSearch[$i]"   => "int",
                            "newShowInList[$i]"     => "int",
                            "newShowInCustom[$i]"   => "int",
                            "newShowInDetail[$i]"   => "int",
			    "newShowInNew[$i]"      => "int"
                             );
          $zen->cleanInput($varfield_check);
	  $updateParams = array( 
                "field_name"		=> $newFieldName[$i],
                "field_label"		=> $newFieldLabel[$i],
		"field_value"           => $newFieldValue[$i],
                "sort_order"		=> $newSortOrder[$i],
                "is_required"		=> (strlen($newIsRequired[$i])?    $newIsRequired[$i]    : 0),
                "use_for_project"	=> (strlen($newUseForProject[$i])? $newUseForProject[$i] : 0),
                "use_for_ticket"	=> (strlen($newUseForTicket[$i])?  $newUseForTicket[$i]  : 0),
                "show_in_search"	=> (strlen($newShowInSearch[$i])?  $newShowInSearch[$i]  : 0),
                "show_in_list"		=> (strlen($newShowInList[$i])?    $newShowInList[$i]    : 0),
                "show_in_custom"	=> (strlen($newShowInCustom[$i])?  $newShowInCustom[$i]  : 0),
                "show_in_detail"	=> (strlen($newShowInDetail[$i])?  $newShowInDetail[$i]  : 0),
                "show_in_new"	        => (strlen($newShowInNew[$i])?     $newShowInNew[$i]     : 0)
				);
	  $res = $zen->update_custom_field_idx($newFieldName[$i], $updateParams); 
	  if( $res ) { $j++; }
	  else {
	    $errs[] = "Failed to update '".$newFieldLabel[$i]."'";
	  }
	}
      }
      $msg = tr("? custom field definitions were saved to the database. Updates complete", array($j));
      $skip = 1;
    }
  } else {
    $vars = $zen->getCustomFields(0);
  }

  if( $more > 10 ) {
    $more = 10;
  } else if( $more < 0 ) {
    $more = 0;
  }

  $page_title = ($skip)? tr("Admin Section") : tr("Update Custom Fields Definition");
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( !$skip ) {    
    include("$templateDir/editCustomsForm.php");
  } else {
    include("$templateDir/adminMenu.php");
  }
  
  include("$libDir/footer.php");

}?>









