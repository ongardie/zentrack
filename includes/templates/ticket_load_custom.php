<?
if( !ZT_DEFINED ) { die("Illegal Access"); }
  $access_level = $map->getViewProp($view, 'access_level');
  if( $zen->checkAccess($login_id, $bin_id, $access_level) ) {
    // run a whole bunch of error checks before
    // letting the user edit the varfields of ticket
    $TODO = 'EDIT_CUSTOM';
    $description = preg_replace("@<br ?/?>@","\n",$description);
    include("$templateDir/newTicketForm.php");
  }
?>