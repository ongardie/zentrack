<? 
  
  /*
  **  THIS IS FOR DEBUGGING ONLY, REMOVE FROM ANY RELEASE PACKAGE
  */
  
  include("header.php");
  
  if( $login_level ) {
     phpinfo();     
  } else {
     header("Location: $rootUrl/index.php");
  }
  
?>
