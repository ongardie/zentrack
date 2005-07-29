<?{

  /*
  **  CHANGE LANGUAGE PREFERENCE
  **  
  **  Change the language of preference
  **  logged in user.
  **
  */
  
  include("../header.php");

  $expand_options = 1;
  $skip = 0;
  if( isset($TODO) && $TODO == 'LANG' ) {
    if( isset($newlang) ) {
      $newlang = preg_replace("/[^0-9a-zA-Z_-]/", "", $newlang);
    }
    if( file_exists("$libDir/translations/$newlang.trans") ) {
      $login_language = $newlang;
      $params = array("language"=>$newlang);
      $res = $zen->update_prefs($login_id, array($params), "language");
      if( $res > 0 ) {
	$translator_init = array(
				 'domain' => 'translator',
				 'path' => "$libDir/translations",
				 'locale' => $login_language
				 );
	$translator_init['zen'] =& $zen;
	tr($translator_init);
	$msg[] = tr("Your language has been changed to ?", $newlang);
	$skip = 1;
      }
      else {
	$errs[] = tr("The language could not be changed to ?", $newlang);
      }
    } else {
      $errs[] = tr("The language file chosen was not valid");
    }
  }

  $page_title = tr("Change Language");

  include("$libDir/nav.php");

  if( is_array($errs) ) {
    $zen->printErrors($errs);
  }
  include("$templateDir/optionsMenu.php");

  include("$libDir/footer.php");

}?>
