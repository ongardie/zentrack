#!/usr/bin/php -q
<?{

  /*
  **  EGATE UTILS
  **  
  **  The funtions that process incoming data
  */
  
  // get configuration
  include("egate_config.php");
  
  // initialize log
  $log = array();

  /**
   * Stores log info
   *
   * @param string/array $text the text to store
   * @param integer $lvl 1-error(system), 2-warning, 3-notice
   */
  function egate_log( $text, $lvl = 3 ) {
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
      $log[] = array($text,$lvl);
    }
  }

  /**
   * returns a list of messages for use by user
   *
   * @param integer lvl 1-errors, 2-warning, 3-notices
   * @return array of log entries
   */
  function egate_fetch_messages( $lvl = '' ) {
    global $log;
    // save time if there is nothing to fetch
    if( $lvl === 0 || !count($log) ) { return; }
    // get appropriate logs
    $vars = null;
    foreach($log as $l) {
      if( $l[1] <= $lvl ) { $vars[] = $l[0]; }
    }
    return $vars;
  }
  
  /**
  * writes logs to file
  * 
  * Opens the log file and writes all existing entries
  * can also send an email if informed to do so
  * 
  */
  function egate_log_write() {
    global $log;
    global $egate_log_level;
    if( count($log) ) {
      $text = "---".date("Y-m-d H:i")."---\n";
      foreach($log as $l) {
        if( $l[1] <= $egate_log_level ) {
          $text .= $l[0]."\n";
        }
      }    
      $fp = fopen("./logs/egate_log");
      fputs($fp,$text);
      fclose($fp);
      $log = array();
    }
  }

  // check for proper setup
  if( !file_exists($header_file_location) ) {
    egate_log("ERROR: \$header_file_location not set correctly... exiting",1);
    egate_log_write();
    exit;
  }
  
  // get the system settings
  include_once($header_file_location);
  
  // check for PEAR library Mail_Mime
  if( !file_exists('Mail/mimeDecode.php') ) {
    egate_log("ERROR: Mail/mimeDecode (PEAR Library) not found... exiting",1);
    egate_log_write();
    exit;
  }
  
  // include the mail decoding functions
  include_once('Mail/mimeDecode.php');
  
  // make sure we are using the email interface
  if( !$zen->email_interface_enabled == "on" ) {
    egate_log("ERROR: email ignored, email_interface_enabled = off",1);
    egate_log_write();
    exit;
  }
  
  // determine the egate user's settings and access rights
  $egate_user = $zen->get_user_by_login("egate");
  
  // produce an error if the egate user is not in database
  if( !is_array($egate_user) || !count($egate_user) ) {
    egate_log("ERROR: egate user account is missing",1);
    egate_log_write();
    exit;    
  }
  
  // get the egate access priviledges
  $egate_user["access"] = $zen->get_access($egate_user["user_id"]);
  

  /**
   * parses out the body of the email, looking for template properties
   *
   * removes comments and reply portions of the message (> ..)
   * and parses out useful information
   *
   * @param string raw message body
   * @return array "details" and any other parameters found in the message
   */ 
  function parse_message_body( $body ) {
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
	if( !$n ) { continue; }
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
	  // if we have some text on this line, add it in
	  if( $t ) { $params["$n"] = $t; } 
	  // otherwise start with an empty value
	  else { $params["$n"] = ""; }
	  
	  // we didn't find a checkbox on the @...: line, so look further
	  while(true) {
	    $i++;
	    // make sure we don't cause an infinite loop
	    if( $i >= count($lines) ) { break; }
		
	    // get the next line
	    $l = trim($lines[$i]);
	    
	    // parse the line
	    // this line is blank, so skip it
	    if( preg_match("@>*@", $l) ) { continue; }
	    // if this line starts with [ ]...
	    // it's unchecked, so keep looking
	    else if( preg_match("@>*\[ *\]", $l) ) { continue; }
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
      // this is some junk text returned by the user hitting the reply
      // button, or an @end comment so skip it
      else if( preg_match("/^(>|@end)/", $l) ) { continue; }
      // all other text becomes part of the details
      else { $params["details"] .= $l."\n"; }      
    }
    return( $params );
  }


  /**
   * Decode the message and return params
   *
   * @param string $input the raw data
   * @return object params
   */
  function decode_contents($input) {
    // set up params and execute decoding
    $params['include_bodies'] = TRUE;
    $params['decode_bodies']  = TRUE;
    $params['decode_headers'] = TRUE;
    $decoder = new Mail_mimeDecode($input);
    $structure = $decoder->decode($params);
    
    // record what we recieved
    egate_log( $zen->showDateTime() ."||"
         .$structure->headers["from"] ."||"
         .$structure->headers["subject"], 2 );
    
    return $structure;
  }

  /**
   * ensures that we have valid contents to work with
   *
   * @param object the decoded object obtained from decode_contents()
   * @return boolean contents are valid
   */
  function validate_params( $params ) {
    $valid = true;
    // validate the file parameters
    if( $params->headers["subject"] == "" ) {
      $errors = false;
      egate_log("ERROR: Subject was blank",3);
    }
    if( !$params->headers["from"] && !$params->headers["reply-to"] ) {
      $errors = false;
      egate_log("ERROR: There is no return address",3);
    }
    return $valid;
  }

  /**
   * returns the action for this ticket
   *
   * parses the subject to obtain this ticket action, and
   * validates that action against the allowed actions
   *
   * @param object email object obtained from decode_contents()
   * @return array containing action and ticket array
   */
  function parse_subject( $params ) {
    global $zen;
    $errors = false;
    // parse the subject
    preg_match("@#([0-9]+): ([a-zA-Z0-9_-]+)@", 
	       $params->headers["subject"], $matches);
    $matches[1] = (count($matches)>2)? 
      preg_replace("@[^0-9]@", "", $matches[1]) : 0;
    
    // check for create action
    if( (count($matches) < 3 || $matches[1] <= 0) 
	&& preg_match("@create@i",$params->headers["subject"]) ) {
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
	return;
      }
    } else {
      // no valid action
      $errors = true;
      egate_log("ERROR - no valid action was found for header:"
		.$params->headers["subject"]);
      return;
    }

    // customize the notify actions
    if( $action == "add" || $action == "drop" ) {
      $action = "notify_$action";
    }
    
    // determine which actions might be in the subject
    $valid_actions = array_keys($zen->listValidActions($id,$egate_user["user_id"]));
    if( !$action == "remove" && !isset($valid_actions["$action"]) ) {
      $errors = true;
      egate_log("The action $action was not valid.");
      return;
    }
    else if( !$action == "remove" && $valid_actions["$action"]["egate"] <= 0 ) {
      $errors = true;
      egate_log("The action $action is not allowed via the email interface.");
      return;
    }    
    // return the results
    if( !$errors ) { return array($action,$ticket); }
    else { return false; }
  }

  /**
   * Conduct a ticket action
   *
   * @param string $action the action to perform
   * @param array $ticket properties of the ticket
   * @param array $body the parsed body properties (from parse_body())
   * @param array $params the mail params from parse_contents()
   * @return integer action result
   */
  function perform_ticket_action($action,$ticket,$body,$params) {
    // take an appropriate ticket action
    // todo: approve,accept,create,close,email,estimate,log,move,reject,test    
  }

  /**
   * process raw message and take appropriate actions 
   *
   * @param string $input is the raw message data
   * @return boolean errors were encountered
   */ 
  function process_message($input) {
    // process the input data for an email and return results
    $errors = false;     
    global $valid_actions;
    global $zen;
    global $egate_user;
    
    // check for input
    if( $input == "" ) {
      egate_log("ERROR: no input recieved",2);
      return;
    }

    // decode the data
    $params = decode_contents($input);

    // validate the data
    $res = validate_contents($params);
    if( !validate_contents($params) ) { $errors = true; }
    
    // find out what action we are taking
    $res = fetch_action($params);
    if( is_array($res) ) {
      list($action,$ticket) == $res;
      // return if we didn't get a valid ticket + action
      if( !$action || ($action != "create" && !is_array($ticket)) ) {
	$errors = true;
      }
    } 
    else { $errors = true; }

    // retrieve the contents from the body
    // of the email
    $body = parse_message_body($params->body);
    
    // quit if we have any errors, before we try to peform
    // the action
    if( $errors == true ) { return false; }

    // set up the return email address
    // and the user's name, if it can be found
    $email = $params->headers["reply-to"]? 
      $params->headers["reply-to"] : $params->headers["from"];
    if( preg_match("/([^<]*)<([a-zA-Z0-9_@.-]+)>/", $email, $matches) ) {
      $name = $matches[1];
      $email = $matches[2];
    }
    if( !$name ) {
      if( preg_match("/([^<]*)<([a-zA-Z0-9_@.-]+)>/", 
		     $params->headers["from"], 
		     $matches) ) {
	$name = $matches[1];
      }
      else {
	$name = "unknown";
      }
    }

    // extract the ticket id for convenience
    $id = $ticket["id"];
		
    if( $action == "create" ) {
      // create a new ticket
      print "creating a ticket<br>\n";//debug
    }    
    else if( $action == "remove" ) {
      // remove user from notify list
      $res = $zen->drop_notify_by_email($email,$id);
    }
    else if( $action == "help" ) {
      // return a help selection
      print "returning help selections to $email<br>\n";//debug
    }
    else if( $action == "options" ) {
      // return a list of valid options for this ticket
      print "selecting valid options for $id<br>\n";//debug
    }
    else if( $action == "notify_add" ) {
      // add user to notify list
      $vars = array("name"      => $name,
		    "email"     => $email,
		    "ticket_id" => $id,
		    "priority"  => 1);
      $res = $zen->add_to_notify( $vars );
    }
    else if( $action == "notify_drop" ) {
      // grap the recipient to remove from the body["details"]
      // and send him bye bye
      $vals = split("[, \n]", $body["details"]);
      if( is_array($vals) && count($vals) ) {
	$i = 0;
	foreach($vals as $v) {
	  // see if it's an email, or a user_id
	  if( is_numeric($v) ) {	    
	    // user id
	    $res = $zen->drop_from_notify($v,$id);
	    if( $res ) { $i++; }
	    else { egate_log("user_id $v not found in #$id notify list",3); }
	  }
	  else if( str_pos("@",$v) ) {
	    // email address
	    $res = $zen->drop_notify_by_email($v,$id);
	    if( $res ) { $i++; }
	    else { egate_log("email $v not found in #$id notify list",3); }
	  }
	  else {
	    egate_log("$v was not a valid email address or user_id",3);
	  }
	}
	egate_log("$i recipients dropped from #$id notify list",3);
      }
      else {
	// nobody was found to remove
	egate_log("No recipients were found to remove from $id notify list",3);
      }
    }
    else {
      perform_ticket_action($action,$ticket,$body,$params);      
    }

    // create log entry for action taken
    // add sender to notify list if appropriate
    
    // make an email reply for sender
    // employ $egate_notify_level (0-3)

    //todo: add docs for all of this
    
  }

}?>
