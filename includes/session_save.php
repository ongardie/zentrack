<?
  /*
  ** Returns variables extracted to the $_SESSION array
  ** this avoids having to have lengthly, and ugly $_SESSION
  ** in every place that we call one of these values
  */
print "<pre>\n";
print_r($_SESSION);
print "</pre>\n";
  if( is_array($_SESSION) && count($_SESSION) ) {
    $keys = array_keys($_SESSION);
    foreach($keys as $k) {
      $_SESSION["$k"] = $$k;
    }
  }
print "<pre>\n";
print_r($_SESSION);
print "</pre>\n";

?>
