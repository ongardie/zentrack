#!/usr/bin/php -q
<?

  /*
  **  EGATE CONFIGURATION
  */
  
  // use the absolute path (not the url)
  // to the www/header.php file
  $header_file_location = "/path/to/zentrack/www/header.php";
  
  /*
  **  IF USING THE PIPE TO EGATE OPTION, you are done
  **
  **  IF CHECKING A POP MAIL BOX, configure the rest of these
  */
  
  // use an ip address, 
  // a fully qualified domain name, or locahost
  $smtp_host = "localhost";
  
  // this probably doesn't need to change
  $smtp_port = "110";
  
  // the username to log in with
  $smtp_user = "yourserver";
  
  // the password to log in with
  $smtp_pass = "yourpass";    

  // this is a basic pop3 config
  // you probably don't need to change this at all
  // there are others for imap, ssl, etc
  // see http://www.php.net/manual/en/function.imap-open.php for more options

  $smtp_string = "{".$smtp_host.":".$port."/pop3}INBOX";  // note that the { and $ separation is critical!

?>