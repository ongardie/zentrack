<?

  /*
  ** Returns variables extracted to the $_SESSION array
  ** this avoids having to have lengthly, and ugly $_SESSION
  ** in every place that we call one of these values
  */

  if( is_array($_SESSION) ) {
    foreach($session_vars as $s) {
      $x = $$s;
      $_SESSION["$s"] = $x;
    }
  }
  else if( is_array($HTTP_SESSION_VARS) ) {
    foreach($session_vars as $s) {
      $x = $$s;
      $HTTP_SESSION_VARS["$s"] = $x;
    }
  }

?>
