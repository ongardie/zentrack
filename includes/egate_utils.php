<?{

  /*
  **  EGATE UTILS
  **  
  **  The funtions that process incoming data
  */
  
  // get configuration
  include_once("egate_config.php");

  // initialize log
  $egate_log = array();
  // initialize the templates
  $email_templates = array();

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
        egate_log($text, $lvl);
      return;
    } 
    // get the log text
    global $egate_log;
    // check for this fatal error, which isn't really an error
    if( preg_match("@mailbox is empty@i", $text) ) {
      $text = "Mailbox was empty";
      $egate_log[] = array($text,$lvl);
    }
    else {
      $egate_log[] = array($text,$lvl);
    }
  }

  /**
   * returns a list of messages for use by user
   *
   * @param integer lvl 1-errors, 2-warning, 3-notices
   * @return array of log entries
   */
  function egate_fetch_messages( $lvl = '' ) {
    global $egate_log;
    // save time if there is nothing to fetch
    if( $lvl === 0 || !count($egate_log) ) { return; }
    // get appropriate logs
    $vars = null;
    foreach($egate_log as $l) {
      if( $l[1] <= $lvl ) { $vars[] = $l[0]; }
    }
    return $vars;
  }

  /**
   * stores footer templates that should be
   * included in an email reply
   *
   * @param string $template is the template name to include
   */
  function egate_store_template( $template ) {
    global $email_templates;
    $email_templates[] = $template;
  }

  /**
   * returns the email templates which have been collected
   *
   * @return array of template strings
   */
  function egate_fetch_templates() {
    global $email_templates;
    return $email_templates;
  }
  
  /**
  * writes logs to file
  * 
  * Opens the log file and writes all existing entries
  * can also send an email if informed to do so
  * 
  */
  function egate_log_write() {
    global $egate_log;
    global $libDir;
    global $egate_log_level;
    if( count($egate_log) ) {
      $text = "---".date("Y-m-d H:i")."---\n";
      foreach($egate_log as $l) {
        if( $l[1] <= $egate_log_level ) {
          $text .= $l[0]."\n";
        }
      }    
      $fp = fopen("$libDir/logs/egate_log","a");
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
  // and process them, but don't include
  // the headerInc.php file, just get
  // the setting values
  $file = file($header_file_location);
  foreach($file as $f) {
    if( preg_match("/^ *([$]|set_locale)/", $f)) {
      eval($f);
    }
  }

  // include the zen objects
  include_once("$libDir/zenTrack.class");
  include_once("$libDir/zenTemplate.class");
  $zen = new zenTrack( $configFile );

  // include the mail decoding functions
  include_once('Mail/mimeDecode.php');
  
  // check for PEAR library Mail_Mime
  // make sure we are using the email interface
  if( $zen->settings["email_interface_enabled"] != "on" ) {
    egate_log("ERROR: email ignored, email_interface_enabled = off",1);
    egate_log_write();
    exit;
  }
  
  // determine the egate user's settings and access rights
  $egate_user = $zen->get_user_by_login($egate_account);
  
  // produce an error if the egate user is not in database
  if( !is_array($egate_user) || !count($egate_user) ) {
    egate_log("ERROR: egate user account not found",1);
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
    $body = preg_replace("@\(\*.*?\*\)@s", "", $body);
    
    // parse the contents
    $lines = explode("\n",$body);
    $in = false;
    for($i=0; $i<count($lines); $i++) {
      $l = trim($lines[$i]);
      if( preg_match("/^>*@([a-zA-Z0-9_ -]+):(.*)/", $l, $matches) ) {
	// determine the index
	$n = trim($matches[1]);
	$t = trim($matches[2]);
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
	      $params["$n"] = trim($matches[1]);
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
    $params["details"] = trim($params["details"]);
    return( $params );
  }


  /**
   * Decode the message and return params
   *
   * @param string $input the raw data
   * @return object params
   */
  function decode_contents($input) {
    global $zen;
    // set up params and execute decoding
    $params['include_bodies'] = TRUE;
    $params['decode_bodies']  = TRUE;
    $params['decode_headers'] = TRUE;
    $decoder = new Mail_mimeDecode($input);
    $structure = $decoder->decode($params);
    
    // record what we recieved
    egate_log( "Decoding... \n\tFrom: ".$structure->headers["from"]
	       ."\n\tReply-to: ".$structure->headers["reply-to"]
	       ."\n\tSubject: ".$structure->headers["subject"], 2 );
    
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
      egate_log("ERROR: Subject was blank",2);
    }
    if( !$params->headers["from"] && !$params->headers["reply-to"] ) {
      $valid = false;
      egate_log("ERROR: There is no return address",2);
    }
    return $valid;
  }

  /**
   ** returns a list of valid actions for the ticket and user
   **
   ** @param integer $ticket_id the ticket id
   ** @return array of actions which are valid
   */
  function fetch_valid_actions( $ticket_id ) {
    global $egate_user;
    global $zen;
    $vars = array("remove","help");    
    $vals = $zen->listValidActions($ticket_id,$egate_user["user_id"]);
    foreach($vals as $k=>$v) {
      if( $v["egate"] > 0 ) {
	$vars[] = $k;
      }
    }
    if( in_array("create",$vars) ) {
      $vars[] = "new";
    }
    natsort($vars);
    return $vars;
  }

  /**
   * returns the entries needed to complete the new.template form
   *
   * @param array $vals the template vals so far
   * @return array the $vals from input plus the new.template vals
   */
  function fetch_create_vals( $vals ) {
    global $zen;
    $vals["types"] = $zen->getTypes();
    $vals["systems"] = $zen->getSystems();
    $vals["bins"] = $zen->getUsersBins($user_id,"level_create");
    $vals["priorities"] = $zen->getPriorities();
    $vals["default_start_date"] = $zen->getDefaultValue("default_start_date");
    $vals["default_deadline"] = $zen->getDefaultValue("default_deadline");
    $vals["default_test"] = 
      ($zen->getDefaultValue("default_tested_checked")=="checked")? "x" : "";
    $vals["default_approve"] = 
      ($zen->getDefaultValue("default_aprv_checked")=="checked")? "x" : "";
    return $vals;
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
    $ticket = null;
    // parse the subject
    preg_match("@#([0-9]+): ([a-zA-Z0-9_-]+)@", 
	       $params->headers["subject"], $matches);
    $matches[1] = (count($matches)>2)? 
      preg_replace("@[^0-9]@", "", $matches[1]) : 0;


    print "matches: \n";//debug
    print_r($matches);//debug
    // check for create action
    if( (count($matches) < 3 || $matches[1] <= 0) 
	&& preg_match("@(help|create|new)@i",$params->headers["subject"],$specs) ) {
      $action = $specs[1];
    }
    else if( count($matches) > 1 && $matches[1] > 0 ) {
      // set the action and id
      $action = strtolower(trim($matches[2]));
      $id = trim($matches[1]);
      // make sure we have a valid ticket and action
      $ticket = $zen->get_ticket($id);    
      if( !is_array($ticket) || !count($ticket) ) {
	$errors = true;
	egate_log("Ticket #$id is not a valid ticket",2);
	return;
      }
    } else {
      // no valid action
      $errors = true;
      egate_log("ERROR - no valid action was found for header:"
		.$params->headers["subject"],2);
      return;
    }

    // customize the notify actions
    if( $action == "add" || $action == "drop" ) {
      $action = "notify_$action";
    }
    
    // get a list of valid actions
    $valid_actions = fetch_valid_actions($id);

    // determine which actions might be in the subject
    if( !in_array($action,$valid_actions) ) {
      $errors = true;
      egate_log("The action $action was not valid.",2);
      return;
    }

    // return the results
    if( !$errors ) { return array($action,$ticket); }
    else { return false; }
    
  }

  /**
   * Creates a new ticket entry
   *
   * @param string $name the name of the sender
   * @param string $email the email of the sender
   * @param array $body the indexed array from parse_message_body()
   * @param object $params the object obtained from decode_contents()
   * @return boolean succeeded
   */
  function create_new_ticket($name, $email, $body, $params) {

    //todo: this

  }

  /**
   * Conduct a ticket action
   *
   * @param string $name the name of the sender
   * @param string $email the email of the sender
   * @param string $action the action to perform
   * @param array $ticket properties of the ticket
   * @param array $body the parsed body properties (from parse_body())
   * @param array $params the mail params from parse_contents()
   * @return integer action result
   */
  function perform_ticket_action($name,$email,$action,$ticket,$body,$params) {
    global $zen;
    $success = true;

    // extract the ticket id for convenience
    if( is_array($ticket) ) {
      $id = $ticket["id"];
    }
		
    // take an appropriate ticket action
    switch( $action ) {
    case "approve":
      {
	// todo:
	break;
      }
    case "accept":
      {
	// todo:
	break;
      }
    case "close":
      {
	// todo:
	break;
      }
    case "create":
      {
	// create a new ticket
	create_new_ticket($name,$email,$body,$params);
	break;
      }
    case "email":
      {
	// todo:
	break;
      }
    case "estimate":
      {
	// todo:
	break;
      }
    case "help":
      {
	egate_store_templates("help.template");
	break;
      }
    case "log":
      {
	// todo:
	break;
      }
    case "move":
      {
	// todo:
	break;
      }
    case "new":
      {
	egate_store_templates("new.template");
	break;
      }
    case "notify_add":
      {
	// add user to notify list
	// todo: fix this to allow to add other users
	// todo: make it email the person added
	if( preg_match("/#[0-9]+: *add \[?([a-zA-Z0-9_.@-]+)\]?/", 
		       $params->headers["subject"]) ) {
	  // todo: make this work for user_id, name or email
	}
	else {
	  $em = $zen->checkEmail($email);
	  $en = preg_replace("/['\"<>]/", "", $name);
	}
	$vars = array("email"     => $em,
		      "ticket_id" => $id,
		      "priority"  => 1);
	if( strlen($en) ) {
	  $vars["name"] = $en;
	}
	$res = $zen->add_to_notify_list( $id, $vars );
	if( $res && $res != "duplicate" ) {
	  egate_log("added ".($name?$name."/":'')."$email to notify for #$id",3);
	} else if( $res && $res == "duplicate" ) {
	  egate_log("entry ".($name?$name."/":'')
		    ."$email already on notify for #$id",3);
	  $success = false;
	} else {
	  egate_log("unable to add $name/$email to notify for #$id",2);
	  $success = false;
	} 
	break;
      }
    case "nofity_drop":
      {
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
	      else { egate_log("user_id $v not found in #$id notify list",2); }
	    }
	    else if( str_pos("@",$v) ) {
	      // email address
	      $res = $zen->drop_notify_by_email($v,$id);
	      if( $res ) { $i++; }
	      else { egate_log("email $v not found in #$id notify list",2); }
	    }
	    else {
	      egate_log("$v was not a valid email address or user_id",2);
	    }
	  }
	  if( $i > 0 ) {
	    egate_log("$i recipients dropped from #$id notify list",3);
	  }
	  else {
	    // nobody was found to remove
	    egate_log("No recipients were found to remove from $id notify list",2);
	    $success = false;
	  }	  
	}
	break;
      }
    case "options":
      {
	// return a list of valid options for this ticket
	egate_store_templates("options.template");
	break;
      }
    case "reject":
      {
	// todo:
	break;
      }
    case "remove":
      {
	// remove user from notify list
	$res = $zen->drop_notify_by_email($email,$id);
	if( $res ) {
	  egate_log("dropped $email from ticket $id notify list",3);
	}
	else {
	  egate_log("unable to remove $email from ticket $id notify list",2);
	  $success = false;
	}
	break;
      }
    case "test":
      {
	// todo:
	break;
      }
    default:
      {
	egate_log("Invalid action, could not be processed",1);
	$success = false;
      }
    }
    return $success;
  }

  /**
   * process raw message and take appropriate actions 
   *
   * @param string $input is the raw message data
   * @return boolean succeeded
   */ 
  function process_message($input) {
    // process the input data for an email and return results
    $success = true;     
    global $valid_actions;
    global $zen;
    global $egate_user;
    
    // check for input
    if( $input == "" ) {
      egate_log("input stream was empty",2);
      return;
    }

    // decode the data
    $params = decode_contents($input);

    // validate the data
    if( !validate_params($params) ) { $success = false; }
    
    // find out what action we are taking
    $res = parse_subject($params);
    print "result: \n";
    print_r($res);
    if( is_array($res) ) {
      list($action,$ticket) = $res;
    } 
    else { $success = false; }    

    print("action: $action\n");//debug

    // retrieve the contents from the body
    // of the email
    $body = parse_message_body($params->body);
    
    // quit if we have any errors, before we try to peform
    // the action
    if( $success == false ) { return false; }

    // set up the return email address
    // and the user's name, if it can be found
    $email = $params->headers["reply-to"]? 
      trim($params->headers["reply-to"]) : trim($params->headers["from"]);
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
    $name = preg_replace('/["\'<>]/',"",$name);
    $email = preg_replace('/["\'<>]/',"",$email);

    // don't process tickets with no return address
    if( !$email ) {
      egate_log("No return email address",2);
      $success = false;
    }

    if( $success ) {
      // peform the action
      $success = perform_ticket_action($name,$email,$action,$ticket,$body,$params);

      // todo: send a reply email
      $rec = array(array("name"=>$name,"email"=>$email));
      $rep = send_reply_mail( $rec, $id, $success );
      if( !$rep ) {
	egate_log("reply email failed to $name<$email>",2);
      }
    }

    // write the log entry
    egate_log_write();

    //
    // todo: fix the formatEmail in zenTrack.class to use templates
    // todo: and make sendEmail create some custom options for
    // todo: including special templates for user activities such
    // todo: as sending approve blurb to approval person when
    // todo: ticket is set to pending, etc
    //
    // todo: fix user_id to match person sending, rather than egate for
    //       checking owner of ticket/valid actions
    //
    // todo: format the || entry for user consumption
    //
    // todo: add egate_store_templates()
    //
    // todo: add docs for all of this
    //
    // todo: email_notify config setting
    //
    // todo: update egate and egate_check
    //
    // todo: testing
    //

    // success
    return $success;
  }

  /**
   * make an email reply for the sender
   * 
   * this will send a reply to the person
   * who submitted the entry, compliant
   * with $egate_notify_level
   *
   * @param array $recipients is an indexed array of email addresses and names (names optional)
   * @param boolean $success is whether action was completed successfully
   * @return integer number of emails sent
   */
  function send_reply_mail( $recipients, $id, $success ) {    
    // employ $egate_notify_level (0-3)
    global $egate_notify_level;
    global $libDir;
    global $egate_user;
    global $zen;

    // get the messages
    $messages = egate_fetch_messages($egate_notify_level);
    $templates = egate_fetch_templates();

    // send an email if we have data
    if( (is_array($messages)&&count($messages))
	||(is_array($templates)&&count($templates)) ) {
      $text = "";

      // grab the params
      $valid_actions = fetch_valid_actions($id);      
      $vals = array("success"  =>   $success,
		    "id"       =>   $id,
		    "messages" =>   $messages,
		    "valid_actions" => $valid_actions);

      // create header
      $temp = new zenTemplate("$libDir/templates/email/heading.template");
      $temp->values($vals);
      $txt .= $temp->process();

      // create reply
      $temp = new zenTemplate("$libDir/templates/email/reply.template");
      $temp->values($vals);
      $txt .= $temp->process();

      // include extra footer templates
      if( is_array($templates) ) {
	// get ticket create fields if needed
	if( in_array("new.template",$templates) ) {
	  $vals = fetch_create_vals($vals);
	}
	// run through templates
	foreach( $templates as $t ) {
	  $temp = new zenTemplate("$libDir/templates/email/$t");
	  $temp->values($vals);
	  $txt .= $temp->process();
	}
      }

      // create footer
      $temp = new zenTemplate("$libDir/templates/email/footer.template");
      $temp->values($vals);
      $txt .= $temp->process();

      // send messages
      $i=0;
      $from = $egate_user["email"];
      $subject = "[".$zen->settings["bot_name"]."] Ticket #$id: results";
      foreach($recipients as $r) {
	$to = ($r["name"])? "{$r['name']}<{$r['email']}>" : $r['email'];
	$res = mail($to,$subject,$txt,"From:$from\nReply-to:$from\n");
	if( $res )
	  $i++;
      }
      return $i;
    }
    // if we skipped the results, we sent 0 emails
    return 0;
  }

}?>
