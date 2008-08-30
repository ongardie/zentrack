#!/usr/bin/php -q
<?{
  /*
  **  EGATE: Email gateway: collects email input from stdin and creates a new ticket
  **  
  **  The subject becomes the title, the body becomes the details.  The rest of the 
  **  fields are set via the default values in egate_congfig.php
  */

  // include the utils and config
  include("egate_utils.php");
  
  // read email from stdin
  $input = join("",file("php://stdin"));  
  
  // parse the email contents... this could be made more effecient with some
  // modifications to egate_utils, since we could cache this info and not have
  // to parse it twice (right now this method is also called inside egate_utils)
  // but this will probably be fast enough, unless the email server is getting a
  // few hundred emails per minute.
  $params = decode_contents($input);
  
  // let's find out what domain our email came from...
  list($name,$email) = get_name_and_email($params);
  $domain = substr($email, strpos($email, '@')+1);
  
  // now lets set the bin based on the domain name
  // !!!! set domain1.com and domain2.com to the appropriate values, obviously !!!!
  if( $domain == 'domain1.com' ) {
    // it's ok to use the bin name or bin id here!
    $egate_create_fields['bin'] = 'Accounting'; 
  }
  else if( $domain == 'domain2.com' ) {
    $egate_create_fields['bin'] = 'Engineering';
  }
  else {
    // catch anything we didn't expect and put it in a special bin for review
    $egate_create_fields['bin'] = 'Unsorted';
  }

  // process the email
  create_ticket_from_message($input);

  // clean the log file
  egate_log_write();

}?>
