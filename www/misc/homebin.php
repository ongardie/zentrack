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

  if( $TODO == 'BIN' ) {
    $homebin = ereg_replace("[^0-9]", "", $homebin);
    if( strlen($homebin) && !$zen->bins["$homebin"] ) {
      $errs[] = "That bin doesn't exist";
    } else {
      if( !$homebin ) {
	$params = array( "homebin"=>"NULL" );
      } else {
	$params = array( "homebin"=>$homebin );
      }
    }
    if( !$errs ) {
      $res = $zen->update_user($login_id, $params);
      if( !$res ) {
	$errs[] = "System Error: Unable to update bin.";
      } else {
	$skip = 1;
	$hb = ( !$homebin )? "-None-" : $zen->bins["$homebin"];
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
  $zen->printErrors($errs);
  if( $skip ) {
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

