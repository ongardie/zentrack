#!/usr/bin/php -q
<?{

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
  
  // determine the egate user's settings and access rights
  $egate_user = $zen->get_user_by_login("egate");

  // produce an error if the egate user is not in database
  if( !is_array($egate_user) || !count($egate_user) ) {
    egate_log("ERROR: egate user account is missing");
    egate_log_write();
    exit;    
  }

  // get the egate access priviledges
  $egate_user["access"] = $zen->get_access($egate_user["user_id"]);

  function parse_message_body( $body ) {
    // parses out the body of the email, looking for template properties
    // removing comments and reply portions of the message
    // returns an indexed array containing ["details"], and any other
    // parameters found in the message

    // get the zen object
    global $zen;

    // initialize the return array
    $params = array("details"=>"");

    // remove comments
    $body = preg_replace("@\{\*.*?\*\}@s", "", $body);

    // parse the contents
    $lines = explode("\n",$body);
    $in = false;
    for($i=0; $i<count($lines); $i++) {
      $l = trim($lines[$i]);
      if( preg_match("/^>*@([a-zA-Z0-9_ -]+):(.*)/", $l, $matches) ) {
	// determine the index
	$n = trim($matches[1]);
	$t = $matches[2];
	// if we didn't get a proper index, then skip it
	if( !$n )
	  continue;
	if( preg_match("@^\[ *[xX] *\]@", $t) ) {
	  // it's a checkbox on this line, so return a 1
	  $params["$n"] = 1;
	  continue;
	} else if( preg_match("@^\[ *\]@", $t) ) {
	  // it's an empty checkbox, so return 0
	  $params["$n"] = 0;
	  continue;
	} 
	else {
	  if( $t ) {
	    // if we have some text on this line, add it in
	    $params["$n"] = $t;
	  } 
	  else {
	    // otherwise start with an empty value
	    $params["$n"] = "";
	  }
	  // we didn't find a checkbox on the @...: line, so look further
	  while(true) {
	    $i++;
	    // make sure we don't cause an infinite loop
	    if( $i >= count($lines) ) {
	      break;
	    }
	    
	    // get the next line
	    $l = trim($lines[$i]);
	    
	    // parse the line
	    if( preg_match("@>*@", $l) ) {
	      // this line is blank, so skip it
	      continue;
	    }
	    else if( preg_match("@>*\[ *\]", $l) ) {	      
	      // if this line starts with [ ]...
	      // it's unchecked, so keep looking
	      continue;
	    }
	    else if( preg_match("@>*[ *[xX] *] *([0-9]+)-@", $l, $matches) ) {
	      // this line starts with [x] nn-wordswords, 
	      // then nn is our value
	      $params["$n"] = $matches[1];
	      break;
	    }
	    else if( preg_match("/>*(@end|@[a-zA-Z0-9_ -]+:)/", $l) ) {
	      // if we come to the next parameter, or an @end, we are done
	      $i--;
	      break;
	    } else {
	      // we don't have a [ ] or a [x], so this must be
	      // a text entry, concat it together and return it
	      $params["$n"] .= preg_replace("@>*@", "", $l)."\n";
	    }
	  }
	}
      }
      else if( preg_match("/^(>|@end)/", $l) ) {
	// this is some junk text returned by the user hitting the reply
	// button, or an @end comment so skip it
	continue;
      }
      else {
	// all other text becomes part of the details
	$params["details"] .= $l."\n";
      }      
    }
    return( $params );
  }

  function process_message($input) {
    // process the input data for an email and return results
    $errors = false;     
    global $valid_actions;
    global $zen;
    global $egate_user;
    
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
    
    if( (count($matches) < 3 || $matches[1] <= 0) 
	&& preg_match("@create@i",$params->headers["subject"]) ) {
      // the action is create, unless we find a valid action
      $action = "create";
    } 
    else if( count($matches) > 1 && $matches[1] > 0 ) {
      // set the action and id
      $action = strtolower($matches[2]);
      $id = $matches[1];
      // make sure we have a valid ticket and action
      $ticket = $zen->get_ticket($id);    
      if( !is_array($ticket) || !count($ticket) ) {
	$errors = true;
	egate_log("Ticket id $id is not a valid ticket");
      }
    } else {
      $errors = true;
      egate_log("ERROR - no valid action was found for header:".$params->headers["subject"]);
    }

    // customize the notify actions
    if( $action == "add" || $action == "drop" ) {
      $action = "notify_$action";
    }

    // determine which actions might be in the subject
    $valid_actions = array_keys($zen->listValidActions($id,$egate_user["user_id"]));

    if( !isset($valid_actions["$action"]) ) {
      $errors = true;
      egate_log("The action $action was not valid.");
    }
    
    // quit if we have any errors, before we try to peform
    // the action
    if( $errors == true ) {
      egate_log_write();
      return false;
    }
    
    //todo: figure out how to restrict actions we don't want
    //todo: the email interface to use

    //todo: change create_ticket to add bin_manager, bin_tester, and creator to notify list
    //todo: maybe create some entries for these in the settings

    //todo: make an email notify to return error messages
    //todo: and to inform system administrator
    //todo: employ $egate_notify_level (0-3)

    //todo: add docs for all of this
    
    // parse message body
    // check for "remove" in the action
    // check for "create" in the action
    // check for "help" in the action      
    // check for "options" in the action
    // check for "notify_add" and "notify_drop" in the action
    // check actionApplicable (vs valid_actions)
    // take an appropriate action
    // create log entry for action taken
    // add sender to notify list if appropriate
    
    // close up shop
    egate_log_write();
  }

}?>
