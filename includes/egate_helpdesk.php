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
  
  // include the utils and config
  include("egate_utils.php");
  
  egate_log("running egate_helpdesk script", 3);
  
  // read email from stdin
  $input = join("",file("php://stdin"));  

  // process the message
  do_helpdesk_message($input);

  // clean the log file
  egate_log_write();

}?>
