<?
  $b = dirname(__FILE__);
  include("$b/help_header.php");

  if( array_key_exists('reportButton', $_POST) ) {
    $debug_output = urldecode($debug_output);
    $url = $_SERVER['HTTP_REFERER'];
  }
  
  if( array_key_exists('submit', $_POST) ) {
    // post the form data
    $fields = array(
                'name'         => 'string',
                'email'        => 'email',
                'url'          => 'text',
                'message'      => 'text',
                'user_info'    => 'text',
                'debug_output' => 'text'
              );
     $zen->cleanInput($fields);
     
     $fullMessage = 'BUG REPORT RECIEVED: '.$zen->showDateTime()."\n\n";
     foreach( $fields as $k=>$v ) {
        $fullMessage .= $k.': '.stripslashes($$k)."\n\n";
     }
     $fullMessage .= "\n\n\n\n---\n"
        .$_SERVER['REMOTE_ADDR']."\n"
        .$_SERVER['HTTP_USER_AGENT']."\n"
        .$_SERVER['HTTP_REFERER']."\n";
     $headers = "From: bot@zentrack.net\nReply-To: ".stripslashes($email)."\n";
     
     $res = mail('feedback@zentrack.net', "Bug report from ".stripslashes($name),
                 $fullMessage, $headers);
     if( $res ) {
       $msg = "Your message was delivered: <pre>$fullMessage</pre>";
       $skip = 1;
     }
     else {
       $msg = "Your message could not be delivered.";
     }
  }
  
  include("$libDir/nav.php");
  if( !$skip ) {
    include("$templateDir/bugForm.php");
  }
  include("$libDir/footer.php"); 

?>