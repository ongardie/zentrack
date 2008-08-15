#!/usr/bin/php -q
<?{
  /*
  **  This script reads emails and does one of two things, based on the subject
  **  of the email. If the email begins with #nn (where nn is a number), then
  **  this script will add a log entry with the contents of the email as the message.
  **
  **  If the subject does not begin with #nn, then a new ticket is created with
  **  the contents of the email as the description of the problem and the subject
  **  as the title.
  **
  **  The default parameters for the ticket are specified in egate_config.php
  **  using the $egate_default_options array.
  **  
  **  All activity is logged to includes/logs/egate_log
  **
  **  Note that if $egate_create_overrrides is set to 1 in egate_config.php, then
  **  users can override any value in the array $egate_create_fields array by putting
  **  "field_name: value" into the email at the beginning of a line
  */
  
  /**
   * @param string $subject
   * @return int ticket id from subject or false if none
   */
  function get_ticket_id($subject) {
    preg_match( '@#([0-9]+)@', $subject, $matches );
    if( count($matches > 1) ) { return $matches[1]; }
    return false;
  }
  
  /**
   * @param int $id
   * @return array containing ticket parms or false if not found
   */
   function get_ticket( $id ) {
     global $zen;
     // make sure we have a valid ticket and action
     $ticket = $zen->get_ticket($id);    
     if( !is_array($ticket) || !count($ticket) ) {
	     egate_log("Ticket #$id is not a valid ticket",2);
	     return false;
     }
     else { return $ticket; }
   }
  
  // include the utils and config
  include("egate_utils.php");
  
  egate_log("running egate_helpdesk script", 3);
  
  // read email from stdin
  $input = join("",file("php://stdin"));  

  // determine if the subject has a ticket id
  $args = decode_contents($input);
  
  // extract the values of interest to us
  $from = empty($args->headers['reply-to'])? $args->headers['from'] : $args->headers['reply-to'];
  $subject = $args->headers['subject'];
  $id = get_ticket_id($subject);
  if( $id ) { $ticket = get_ticket($id); }

  list($name,$email) = get_name_and_email($params);
  $user_id = find_user_id($name,$email);
  $attributes = generate_ticket_attributes($params, $user_id);
  $body = $attributes['details'];
  
  // perform some simple validation
  if( !$from || !$body || !$subject || ($id && !$ticket) ) {
    if( !$from )    { egate_log('missing from address', 1);  }
    if( !$subject ) { egate_log('missing subject', 1);       }
    if( !$body )    { egate_log('missing message body', 1);  }
    if( !$ticket )  { egate_log("ticket #$id not found", 1); }
    if( !$from ) {
      egate_log("unable to send reply message (no return address)");
      exit;
    }
    $email_subject = "Your message couldn't be processed";
    $email_body = $email_subject . " due to the following errors:\n";
    foreach( egate_fetch_messages(1) as $m ) {
      $email_body .= "\t$m\n";
    }
    $email_body .= "\nThe original message is below...\n------------------\n";
    $email_body .= $input;
    mail($from, $email_subject, $email_body, "From:".$egate_user['email']);
    exit;
  }
  
  if( $id ) {
    // we create a log message
    perform_ticket_action($name, $email,'log',$ticket,$attributes,$args);
    egate_log("Created ticket #$id for $user_id/$name/$email",3);
    $email_subject = "#$id: ".$attributes['title']." (new log added)";
    $email_body = "Your message was received and logged.";
    mail($from, $email_subject, $email_body, "From:".$egate_user['email']);    
  }
  else {
    // we create a new ticket
    $id = create_new_ticket($user_id, $name, $email, $attributes);
    egate_log("Created ticket #$id for $user_id/$name/$email",3);
    $email_subject = "#$id: ".$attributes['title'];
    $email_body = "A new ticket was created with id #$id. "
                ."Technicians will begin working on it shortly.\n\n"
                ."If you reply to this email, the body of the message will be added to the ticket's log.";
    mail($from, $email_subject, $email_body, "From:".$egate_user['email']);
  }

  // clean the log file
  egate_log_write();

}?>