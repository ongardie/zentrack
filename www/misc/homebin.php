<?{

  /*
  **  CHANGE DEFAULT BIN
  **  
  **  Change the default bin for the 
  **  logged in user.
  **
  */
  
  include("../header.php");

  $page_tile = "Change Default Bin";
  $expand_options = 1;
  if( isset($TODO) && $TODO == 'BIN' ) {
    $params = "";
    $homebin = ereg_replace("[^0-9]", "", $homebin);
    if( !isset($homebin) || !$zen->bins["$homebin"] ) {
      $errs[] = "That bin doesn't exist";
    } else {
      $params = array( "homebin"=>$homebin );
      $res = $zen->update_user($login_id, $params);
      if( !$res ) {
	$errs[] = "System Error: Unable to update bin.";
      } else {
	$skip = 1;
	$hb = ( !$homebin )? "-All-" : $zen->bins["$homebin"];
	$msg = "Your bin has been changed to $hb";
	$login_bin = $homebin;
      }
    }
  }

  include("$libDir/nav.php");
?>
  <table width="600" align="center">
  <tr><td>
<?
  if( is_array($errs) ) {
    $zen->printErrors($errs);
  }
  if( isset($skip) && $skip ) {
    include("$templateDir/optionsMenu.php");
  } else {
    include("$templateDir/homebinForm.php");
  }
?>
  </td></tr>
  </table>
<?
  include("$libDir/footer.php");

}?>

