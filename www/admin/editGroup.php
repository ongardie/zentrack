<?
  /*
  **  EDIT DATA GROUP
  **  
  **  Modifies an existing data group
  **
  */
  
  
  include("admin_header.php");

  $page_tile = "Edit Data Group";
  include("$libDir/nav.php");

  $group = $zen->get_data_group($group_id);
  
  if( is_array($group) ) {
    $TODO = 'EDIT';
    extract($group);
    include("$templateDir/groupAdd.php");
  } else {
    print "<ul><b>" . tr("That group could not be found") . "</b>";
    print "<br><a href='$rootUrl/admin/groups.php'>" . tr("Click Here to view available groups") . "</a></ul>\n";
  }

  include("$libDir/footer.php");

?>
