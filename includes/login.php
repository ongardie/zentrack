<?
  
  // log user out of zentrack if $logoff
  if( isset($logoff) && $logoff > 0 ) {
     session_unset();
     unset($_SESSION);
     unset($login_id);
     unset($login_name);
     unset($login_level);
     session_start();
  }

  // if there is no login id then include the form
  // or process the form results
  if( $login_level == 'first_login' && !ereg("pwc\.php",$SCRIPT_NAME) ) {
   include("$libDir/nav.php");
   include("$templateDir/pwcForm.php");
   include("$libDir/footer.php");
   exit;    
  }
  if( !$login_id ) {
     if( isset($username) && $username && isset($passphrase) ) {
   $login_id = $zen->login_user( $username, $passphrase );
   if( $login_id && $zen->demo_mode != "on" 
       && $zen->user["initials"] != "GUEST" 
       && $zen->encval($zen->user["lname"]) == $zen->encval($passphrase) ) {
      // this will redirect the user
      // to a login screen where they can
      // change their passphrase, since it is 
      // set to the default
      $login_level = 'first_login';
      $login_name  = $zen->user["fname"]." ".$zen->user["lname"];
      setcookie("zentrackUsername", $username, time()+2592000);
      $login_inits = $zen->user["initials"];
      $login_bin   = $zen->user["homebin"];
      include("$libDir/nav.php");
      include("$templateDir/pwcForm.php");
      include("$libDir/footer.php");
      exit;    
      $skip = 1;
   } else if( $login_id ) {
      // this will log the user in successfully
      // and generate session variables, as well
      // as a cookie to save time logging in
      // in the future
      $login_level = $zen->user["access_level"];
      $login_name  = $zen->user["fname"]." ".$zen->user["lname"];
      $login_inits = $zen->user["initials"];
      $login_bin   = $zen->user["homebin"];
      setcookie("zentrackUsername", $username, time()+2592000);
      $skip = 1;
      unset($TODO);
      $zen->addDebug("login.php:userLogin",
        "User logged in: $login_id,$login_name,$login_level",2);
   } else {
      // generate an error message and let them try again
      $msg = "<p>&nbsp;</p><ul><b>That passphrase didn't work.</b></ul>";
   }
     } else {
      $zen->addDebug("login.php:userLogin",
     "User not logged in, username and passphrase not detected, so creating login form",3);
     }
  
     // user isn't logged in, so show the login form
     if( !isset($skip) || !$skip ) {
   // no login has been recieved, but it's required
   // so generate a login prompt and form
   if( isset($zentrackUsername) )
      $zentrackUsername = strip_tags($zentrackUsername);
   else
      $zentrackUsername = "";
   $page_title = "Please Log On";
   include("$libDir/nav.php");
   include("$templateDir/loginForm");
   include("$libDir/footer.php");
   exit;
     }          
  } 
  
?>
