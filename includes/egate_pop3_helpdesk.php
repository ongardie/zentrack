<?
/**
 ** EGATE POP3 HELPDESK - checks a pop3 account for emails, and 
 ** either create a new ticket from the message or, if a valid ticket
 ** id appears in the subject, add a log to the existing ticket.
 **
 ** This script checks a pop3 account using the settings from egate_config.php
 ** and must be in the same directory as egate_utils.php and egate_config.php
 ** to run.
 */

$start_time = time();

// include utils and config
include("egate_utils.php");

$conn = popConnect($smtp_host, $smtp_port, $smtp_user, $smtp_pass);
if ( $conn ) {
  $emails = getMessages($conn);
  if ( !empty($emails) ) {
    foreach( $emails as $email ) {
      if( $email ) {
        // process the email
        do_helpdesk_message($email);
      }
      else {
        egate_log("Unable to fetch message", 1);
      }
    }
    popDisconnect($conn);
  }
}
else {
  egate_log("ABORTED: Unable to connect to host", 1);
}

$exectime = time()-$start_time;
egate_log("Completed in $exectime seconds",3);
egate_log_write();

?>