#!/usr/bin/php -q
<?{
  /*
  **  EGATE: Email gateway: collects email input from stdin and modifies tickets
  */

  // include the utils and config
  include("./egate_utils.php");
  
  // read email from stdin
  $input = join("",file("php://stdin"));  
  
  // process the email
  process_email($input);
}?>
