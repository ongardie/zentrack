#!/usr/bin/php -q
<?

  /*
  **  EGATE UTILS
  **  
  **  The funtions that process incoming data
  */

  // get configuration
  include("./egate_config.php");

  // initialize log
  $log = "";

   // stores log info
   function egate_log( $text ) {
      // if we get an array, handle it gracefully
      if( is_array($text) ) {
         foreach($text as $t)
            egate_log($text);
         return;
      } 
      // get the log text
      global $log;
      // check for this fatal error, which isn't really an error
      if( preg_match("@mailbox is empty@i", $e) ) {
         $text = "Mailbox was empty";
      $log .= $text."\n";
   }

  // writes logs to file
  function egate_log_write() {
    global $log;
    if( strlen($log) ) {
       $fp = fopen("./logs/egate_log");
       fputs($fp,$log);
       fclose($fp);
       $log = "";
    }
  }

  // check for proper setup
  if( !file_exists($header_file_location) ) {
    egate_log("ERROR: \$header_file_location not set correctly... exiting");
    egate_log_write();
    exit;
  }
  
  // get the system settings
  include_once($header_file_location);

  // check for PEAR library Mail_Mime
  if( !file_exists('Mail/mimeDecode.php') ) {
    egate_log("ERROR: Mail/MimeDecode (PEAR Library) not found... exiting");
    egate_log_write();
    exit;
  }

  // include the mail decoding functions
  include_once('Mail/mimeDecode.php');

  // make sure we are using the email interface
  if( !$zen->email_interface_enabled == "on" ) {
    egate_log("ERROR: email ignored, email_interface_enabled = off");
    egate_log_write();
    exit;
  }

  // determine which actions might be in the subject
  $valid_actions = array_keys($zen->getActions());  

   function process_message($input) {
      // process the input data for an email and return results
      $errors = false;     
      global $valid_actions;
      global $zen;
      
      // validate input
      if( $input == "" )
       $logtxt .= "ERROR: no input recieved!\n";

      // set up params and execute decoding
      $params['include_bodies'] = TRUE;
      $params['decode_bodies']  = TRUE;
      $params['decode_headers'] = TRUE;
      $decoder = new Mail_mimeDecode($input);
      $structure = $decoder->decode($params);

      // record what we recieved
      egate_log( $zen->showDateTime() ."||"
           .$params->headers["from"] ."||"
           .$params->headers["subject"] );

      // validate the file parameters
      if( $params->headers["subject"] == "" ) {
         $errors = true;
         egate_log("ERROR: Subject was blank");
      }
      if( $params->headers["from"] == "" ) {
         $errors = true;
         egate_log("ERROR: Subject was blank");
      }

      // find out what action we are taking
      preg_match("@#([0-9]+): ([a-zA-Z0-9_-]+)@", $params->headers["subject"], $matches);
      $matches[1] = (count($matches)>2)? preg_replace("@[^0-9]@", "", $matches[1]) : 0;
      if( count($matches) < 3 || $matches[1] <= 0 || 
         !in_array(strtolower($matches[2]),$valid_actions) ) {
       // the action is create, unless we find a valid action
       $action = "create";
      } else {
         // set the action and id
         $action = strtolower($matches[2]);
         $id = $matches[1];
         // make sure we have a valid ticket and action
         $ticket = $zen->get_ticket($id);    
         if( !is_array($ticket) || !count($ticket) ) {
            $errors = true;
            egate_log("Ticket id $id is not a valid ticket");
         }
      }

      // quit if we have any errors, before we try to peform
      // the action
      if( $errors == true ) {
         egate_log_write();
         return false;
      }

      //todo: add a remove and add to the actions list, these will
      // be used by the notify script, these should have some actionApplicable
      // fields based on the settings for em...._notifylist and em...anonymous

      //todo: determine whether or not to include a function index, and create this
      // in the template/email directory

      //todo: create a footer template that details 
      // the how of add/remove if actionApplicable

      // check actionApplicable 
      // (email_interface_anonymous|email_interface_notifylist)? noaccess=1

      // take an appropriate action
      // create log entry for action taken
      // add sender to notify list if appropriate

      //todo: add docs for all of this

      // close up shop
      egate_log_write();
   }
?>