#!/usr/bin/php -q
<?
  /*
  ** EGATE CHECK - checks a pop3 account for emails, and injects them via the egate utils
  */
   
  $start = time();

  // include utils and config
  include("egate_utils.php");
  
  // connect to mailbox
  $mb = @imap_open($smtp_string, $smtp_user, $smtp_pass);
  // return error if needed
  if( !$mb ) {
    $errs = imap_errors();
    if( is_array($errs) && count($errs) ) {
      egate_log($errs);
    } else {
      egate_log("Mailbox was empty");
    }
    egate_log_write();
    exit;
  }
  
  // get the number of messages in the box
  // and log it
  $number_of_messages = imap_num_msg($mb);
  egate_log(date("Y-m-d-h-m: Mailbox contains $number_of_messages message".($number_of_messages!=1?"s":""));
  
  // collect messages
  for($i=1; $i<=$number_of_messages; $i++) {
    // get the body and header for the message
    $header = imap_fetchheader($mb,$i);
    $body = imap_body($mb,$i);
    // process the message
    process_message($header."\n\r".$body);
    // flag messages for deletion
    imap_delete($mb,$i);
  }
  
  // delete messages from box
  imap_expunge($mb);
  // close the connection
  imap_close($mb);
  
  $errs = image_errors();
  egate_log($errs);
  
  $exectime = time()-$start_time;
  egate_log("Completed in $exectime seconds");
  egate_log_write();
  
?>