<?
  
  // log user out of zentrack if $logoff
  if( $logoff ) {
     session_unset();
     start_session();
  }

  // if there is no login id then include the form
  // or process the form results
  if( !$login_id ) {
    
     // if username and password, then try to 
     // log the user in
     if( $username && isset($password) ) {
	$login_id = $zen->login_user( $username, $password );
	setcookie("zentrackUsername", $username, time()+2592000, "/", ".$HTTP_HOST");	
	if( $login_id ) {
	   $skip = 1;
	   unset($TODO);
	   $login_level = $zen->user["access"];
	   $login_name  = $zen->user["fname"]." ".$zen->user["lname"];
	   $login_inits = $zen->user["initials"];
	   $login_bin   = $zen->user["homebin"];
	} else {
	   $msg = "<p>&nbsp;</p><ul><b>That password didn't work.</b></ul>";
	}
     }
  
     // user isn't logged in, so show the login form
     if( !$skip ) {
	$zentrackUsername = strip_tags($zentrackUsername);
	$page_title = "Please Log On";
	include("$libDir/nav.php");
	include("$templateDir/loginForm");
	include("$libDir/footer.php");
	exit;
     }          
     
  } 
  
?>
