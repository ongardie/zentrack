<?
  /*
  ** Returns variables extracted to the $_SESSION array
  ** this avoids having to have lengthly, and ugly $_SESSION
  ** in every place that we call one of these values
  */
  if( is_array($_SESSION) ) {
    foreach($session_vars as $s) {
      $_SESSION[$s] = $$s;
    }
  }
?>
