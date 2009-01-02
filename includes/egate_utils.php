<?{
  define("ZT_DEFINED",true);
  
  /*
  **  EGATE UTILS
  **  
  **  The funtions that process incoming data
  */
  
  // get configuration
  include("egate_config.php");
  
  // just a list of valid template forms I have created
  $form_template_list = array("create","help","log","move");
  
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
      $egate_log[] = array($text,3);
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
  * @param int $id is the ticket id, if available (for creating subject)
  */
  function egate_store_template( $template, $id = 0 ) {
    global $email_templates;
    // create a subject if appropriate
    $sub = egate_get_subject();
    if( !strlen($sub) ) {
      global $form_template_list;
      $tmp = str_replace(".template","",$template);
      $tmp = str_replace("form_","",$tmp);
      // we only want it if it's a real template value
      if( in_array($tmp,$form_template_list) ) {
        $txt = ucwords(str_replace("_"," ",$tmp));
        if( $id )
          $txt = "#$id: $txt";
        egate_store_subject($txt);
      }
    }
    // store our template
    $email_templates[] = $template;
  }
  
  /**
  * stores the subject of template[somthing] emails to be retrieved by mail fxn
  *
  * @param string $subject of the email
  */
  $template_subject = "";
  function egate_store_subject( $subject ) {
    global $template_subject;
    $template_subject = $subject;
  }
  
  /**
  * retrieves the subject for template emails
  *
  * @return string subject of email
  */
  function egate_get_subject() {
    global $template_subject;
    return $template_subject;
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
      $egate_log = array();
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
  
  //initialize zen base object
  include_once("$libDir/zenTrack.class.php");
  $zen = new zenTrack( $configFile );
  
  // include the zen objects
  include_once("$libDir/zenTemplate.class.php");
  include_once("$libDir/translator.class.php");
  
  //Create the initialization array for the translator object
  $translator_init = array(
    'domain' => 'translator',
    'path' => "$libDir/translations",
    'locale' => (empty($login_language)? 'english' : $login_language)
    );
  $translator_init['zen'] =& $zen;
  tr($translator_init);
  
  // include the mail decoding functions
  include_once('Mail/mimeDecode.php');
  
  // make sure we are using the email interface
  if( !$zen->settingOn("email_interface_enabled") ) {
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
    egate_log( "From: ".$structure->headers["from"]
      ."\nReply-to: ".(empty($structure->headers["reply-to"])? '' : $structure->headers['reply-to'])
      ."\nSubject: ".$structure->headers["subject"], 2 );
    
    return $structure;
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
    $vars = array("remove","help","template","options");
    $vals = $zen->listValidActions($ticket_id,$egate_user["user_id"]);
    foreach($vals as $k=>$v) {
      if( $v["egate"] > 0 ) {
        $vars[] = $k;
      }
    }
    natsort($vars);
    return $vars;
  }
  
  /**
  * returns the entries needed to complete the template forms
  *
  * @param array $vals the template vals so far
  * @return array the $vals from input plus the new.template vals
  */
  function fetch_template_vals( $vals ) {
    global $zen;
    global $egate_user;
    $vals["types"] = $zen->getTypes();
    $vals["systems"] = $zen->getSystems();
    $bins = $zen->getUsersBins($egate_user["user_id"],"level_create");
    if( is_array($bins) ) {
      $vals["bins"] = array();
      foreach($bins as $b) {
        $vals["bins"][] = $zen->getBinName($b);
      }
    }
    $vals["priorities"] = $zen->getPriorities();
    $vals["activities"] = $zen->getActivities();
    $vals["default_start_date"] = $zen->getDefaultValue("default_start_date");
    if( strlen($vals["default_start_date"]) )
      $vals["default_start_date"] = $zen->showDate($vals["default_start_date"]);
    $vals["default_deadline"] = $zen->getDefaultValue("default_deadline");
    if( strlen($vals["default_deadline"]) )
      $vals["default_deadline"] = $zen->showDate($vals["default_deadline"]);
    $vals["default_test"] = 
    ($zen->getDefaultValue("default_tested_checked")==" checked ")? "x" : "";
    $vals["default_approve"] = 
    ($zen->getDefaultValue("default_aprv_checked")==" checked ")? "x" : "";    
    return $vals;
  }
  
  /**
   * Parse the fields and format values for db insertion.
   *
   * @param array $ticket the values to be parsed, probably from generate_ticket_attributes()
   * @param int $user_id the user manipulating the ticket
   * @return array containing parsed values
   */
  function process_ticket_fields($ticket, $user_id) {
    global $zen;
     $vals = array("creator_id"=>$user_id,"otime"=>time());
     
    // here we run through all the body elements
    // and prepare the results
    foreach($ticket as $k=>$v) {
      $v = trim($v);
      switch(strtolower($k)) {
      case "parent":
      case "project":
        if( strlen($v) ) {
          $vals["project_id"] = get_ticket_id($v);
	  if( $vals['project_id'] && empty($vals['bin_id']) ) {
	    // set the default bin to the same one as the project
	    // it can still be overwritten by a user parm
	    $project = get_ticket($vals['project_id']);
	    $vals['bin_id'] = $project['bin_id'];
	  }
	}
        break;
      case "title":
        $vals["title"] = $zen->stripPHP($v);
        break;
      case "type":
        $vals["type_id"] = get_type_id("types",$v);
        break;
      case "system":
        $vals["system_id"] = get_type_id("systems",$v);
        break;
      case "owner":
        {
          if( strtolower($v) == "me" || strtolower($v) == "myself" ) {
            $vals["user_id"] = $user_id;
          }
          else if( preg_match("/^[0-9]+$/", $v) ) {
            $user = $zen->get_user($v);
            if( $user ) {
              egate_log("created owner from id '$v': ".($user?$user['user_id']:'<null>'), 3);
              $vals["user_id"] = $user['user_id'];
            }
            else {
              egate_log("could not locate owner by id '$v', skipped",2);
            }
          }
          else if( strpos($v, '@') > 0 ) {
            $user = find_user_id('',$v);
            if( $user ) {
              $vals['user_id'] = $user['user_id'];
              egate_log("created owner from email '$v': ".($vals['user_id']?$vals['user_id']:'<null>'), 3);
            }
            else {
              egate_log("could not create owner from email '$email', skipped",2);
            }
          }
          else if( strlen($v) ) {
            $user = find_user_id('','',$v);
            if( $user ) {
              $vals['user_id'] = $user['user_id'];
              egate_log("created owner by login '$v': ".($vals['user_id']?$vals['user_id']:'<null>'), 3);
            }
            else {
              egate_log("could not create owner from login '$login', skipped", 3);
            }
          }
        }
        break;
      case "bin":
        $vals["bin_id"] = get_type_id("bins",$v);
        break;
      case "priority":
        $vals["priority"] = get_type_id("priorities",$v);
        break;
      case "start":
      case "start_date":
      case "start date":
        if( strlen($v) ) {
          $vals["start_date"] = strtotime($v);
        }
        break;
      case "deadline":
        if( strlen($v) ) {
          $vals["deadline"] = strtotime($v);
        }
        break;
      case "worked":
      case "wkd_hours":
      case "hours worked":
        if( strlen($v) ) {
          $vals['wkd_hours'] = $zen->checkNum($v);
        }
        break;
      case "est_hours":
      case "estimated hours":
      case "estimated":
        if( strlen($v) ) {
          $vals['est_hours'] = $zen->checkNum($v);
        }
      case "testing":
      case "testing required":
      case "testing_required":
        {
          if( $v == 1 )
            $vals["tested"] = 1;
          else
          $vals["tested"] = 0;
        }
        break;
      case "approval required":
      case "approval_required":
      case "approval":
        {
          if( $v == 1 )
            $vals["approved"] = 1;
          else
          $vals["approved"] = 0;
          break;
        }
      case "details":
        $vals["description"] = $zen->stripPHP($v);
        break;
      }      
    }
    
    return $vals;
  }
  
  /**
   * Checks required fields for ticket creation, logs errors, and returns
   * false if a required field is not valid
   * @param array $ticket the attributes to be inserted into ticket
   * @return boolean
   */
  function check_required_ticket_fields($ticket) {
    $success = true;
    $required = array(
      "title",
      "priority",
      "description",
      "bin_id",
      "type_id",
      "system_id",
      "creator_id"
      );
    foreach($required as $r) {
      if( !isset($ticket[$r]) || !$ticket[$r] ) {
        $success = false;
        egate_log( ucfirst(str_replace("_id","",$r))." is required",2);
      }
    }
    return $success;
  }
  
  /**
  * Creates a new ticket entry
  *
  * @param integer $user_id the user id to use for creation 
  * @param string $name the name of the sender
  * @param string $email the email of the sender
  * @param array $ticket the indexed array from generate_ticket_attributes()
  * @param Decode $msg the Decode object obtained from decode_contents()
  * @param array $attachments an array of attachment ids to be linked to the ticket
  * @return integer ticket id or 0 if failed
  */
  function create_new_ticket($user_id, $name, $email, $ticket, $msg) {
    global $zen;
    global $egate_user;

    $vals = process_ticket_fields($ticket, $user_id);
    
    if( check_required_ticket_fields($vals) ) {
      $fullname = ($name)? "\"$name\" <$email>" : $email;
      $notes = ($user_id == $egate_user["user_id"])? "Created by $fullname" : "";
      $id = $zen->add_ticket($vals,$notes);
      if( $id ) {
        egate_log("Ticket created with id #$id",3);
        
        // add user to notify list if they create
        // a ticket through the egate system
        // and default_notify_creator == "on"
        if( $user_id == $egate_user["user_id"] && $zen->settingOn("default_notify_creator") ) {
          $zen->add_to_notify_list( $id, array("name"=>$name,"email"=>$email) );
        }
        
        // add attachments
        processAttachments($id, $user_id, $msg);
        
        return $id;
      }
    }
    egate_log("Ticket create failed",2);
    return false;
  }
  
  /**
  * try to find a user in the system based on their name and email
  *
  * @param string $name is the users name
  * @param string $email is the users email
  * @return integer user_id to use, returns egate_user id if no id found
  */
  function find_user_id($name,$email,$login = '') {
    global $zen;
    global $egate_user;
    // find out what user_id to apply
    // by trying to find this user in
    // the system 
    $users_by_email = '';
    if( $login ) {
      $user_id = $zen->get_user_by_login($login);
      if( $user_id ) {
        egate_log("found user by login  '$login': $user_id",3);
      }
      else if( strpos($login, " ") > 0 ) {
	$vals = explode(" ", $login, 2);
	$parms = array("fname" => $vals[0], "lname" => $vals[1]);
	$users = $zen->search_users($parms);
	if( empty($users) ) {
	  egate_log("no user found with name $login", 2);
	}
	else if( count($users) == 1 ) {
	  $user_id = $users[0]['user_id'];
	}
	else {
	  egate_log("more than one user found with name: $login",2);
	}
      }
      else {
        egate_log("invalid name, doesn't match any login or first/last name: $login",2);
      }
    }
    if( empty($user_id) && $email ) {
      egate_log("locating user by email '$email'", 3);
      $users_by_email = $zen->get_users_by_email($email);
      if( is_array($users_by_email) ) {
        // if we got more than one user for this email address
        // then try looking at the name
        if( count($users_by_email) > 1 && strlen($name) ) {
          $vals = array();
          $users_by_name = $zen->get_users_by_name($name);
          if( is_array($users_by_name) ) {
            // foreach name found, see if this user_id also
            // has the correct email, if so, it's a possible match
            foreach($users_by_name as $u) {
              if( in_array($u,$users_by_email) ) {
                $vals[] = $u;
              }
            }
          }
          // if there are more than one, we can't be sure, so skip
          if( count($vals) == 1 ) {
            $user_id = $vals[0];
          }
          egate_log("multiple users have address '$email', tried to select by name '$name': $user_id",2);
        }
        else if( count($users_by_email) == 1 ) {
          // we only found one, so that must be it
          $user_id = $users_by_email[0];
          egate_log("selected user by email '$email': $user_id",3);
        }
      }
    }
    if( empty($user_id) ) {
      egate_log("selected default user (egate account): {$egate_user['user_id']}",3);
      $user_id = $egate_user["user_id"];
    }
    return $user_id;
  }
  
  /**
  * returns a third param from a ticket subject (or body if found)
  *
  * @param object $params the params from decode_contents()
  * @param string $tag (optional) will search body for this tag and use if found
  * @param string $ticket the body attributes from get_ticket_attributes()
  * @return string value of param or body tag if found
  */
  function get_subject_param( $params, $tag, $ticket ) {
    // search body element for tag
    if( is_array($ticket) && $tag ) {
      if( isset($ticket[$tag]) ) {
        return $ticket[$tag];
      }
    }
    // return tag from subject
    if( $tag == "template" ) {
      preg_match("/template:? ([a-zA-Z0-9_-]+)/", $params->headers["subject"],$matches);
      return trim($matches[1]);
    }
    preg_match("/#[0-9]+:? *[a-zA-Z0-9_-]+ +(.*)/",$params->headers["subject"],$matches);
    if( $matches[1] ) {
      return trim($matches[1]);
    }
    return "";
  }
  
  /**
  * attempts to retrieve a ticket by the title, or by the id
  *
  * @param string $text title or id
  * @return integer id of ticket or 0 if failed
  */
  function get_ticket_id( $text ) {
    global $zen;
    // insure the input is cleaned up
    $text = trim($text);
    // check for #nnnn
    $text = preg_replace("/^#([0-9]+)$/", "\\1", $text);
    if( preg_match("/^[0-9]+$/", $text) && strlen($text) && intval($text) > 0 ) {
      // here we look for an id, if found, we validate it
      $ticket = $zen->get_ticket(intval($text));
      if( is_array($ticket) ) {
        return $ticket["id"];
      }
      else {
        egate_log("Ticket #$text not found",3);
        return 0;
      }
    }
    else {
      if( strlen($text) ) {
        // here we look for a complete title match
        $params = array("title"=>array("title","=",$text));
        $vals = $zen->search_tickets($params);
        if( !is_array($vals) || !count($vals) ) {
          // here we try for a partial title match
          $params["title"][1] = "contains";
          $vals = $zen->search_tickets($params);
        }
      }
      if( is_array($vals) ) {
        if( count($vals) > 1 ) {
          // if we have more than one, we return an error, since
          // we aren't sure what the right one is
          egate_log("More than one ticket found with title $text",2);
          return 0;
        }
        else {
          // otherwise, we have success
          return $vals[0]["id"];
        }
      }
      else {
        egate_log("Title didn't match any active tickets",3);
        return 0;
      }
    }
  }
  
  /**
  * evaluates the users input and determines what id it stands for
  *
  * @param string $type the data type(plural): systems, types, bins, priorities, etc
  * @param string $input the users input
  * @return integer the id to use. returns null on failure
  */
  function get_type_id( $type, $input ) {
    global $zen;
    $id = null;
    $n = "get".ucfirst($type);
    $vals = $zen->$n();
    $input = trim($input);
    if( is_integer($input) && isset($vals["$input"]) ) {
      return $input;
    }
    else if( !is_integer($input) ) {
      foreach($vals as $k=>$v) {
        if( strtolower($v) == strtolower($input) )
          return $k;
      }
    }
    egate_log(($input?$input:"<null>")." was not a valid $type entry",2);    
    return $id;
  }
  
  /**
  * Create a log entry
  *
  * @param string $name the name of the sender
  * @param string $email the email of the sender
  * @param Decode $msg the object returned from decode_contents()
  * @param array $ticket properties of the ticket
  * @param array $body the parsed body properties (from generate_ticket_attributes())
  * @return boolean succeeded
  */
  function egate_log_to_ticket($name,$email,$msg,$ticket,$body) {
    global $zen;
    global $egate_user;
    
    // see if we have a valid system user
    // which we can apply here
    $user_id = find_user_id($name,$email);
    
    $id = $ticket["id"];      
    
    // check and see if this user is on the
    // notify list, otherwise they can't edit
    // anything about this ticket
    $list = $zen->get_notify_recipients($id);
    if( !in_array($email,$list) && find_user_id($name,$email)==$egate_user["user_id"] ) {
      egate_log("Sorry, you aren't on the notify list for this ticket"
        ." and aren't a registered user.",2);
      return false;
    }
    
    // make sure we have a valid string
    if( !isset($body["details"]) ) {
      egate_log("Log entry failed, there was no message to add",2);
      return false;
    }
    
    // format a name entry for logging
    $fullname = !empty($name)? "\"$name\" <$email>" : $email;
    
    $logParams = array(
      "bin_id"    => $ticket["bin_id"],
      "entry"     => $body["details"],
      "user_id"   => $user_id,
      "ticket_id" => $id
      );

    // add any hours assigned to the ticket to the log
    foreach( array('hours', 'worked', 'worked hours', 'wkd_hours', 'hours worked') as $k ) {
      if( isset($body[$k]) ) {
	$logParams['hours'] = $body[$k];
	break;
      }
    }

    $body['hours'] = $zen->checkNum($body["hours"]);
    if( isset($body["activity"]) && in_array(strtoupper($body["activity"]),$zen->getActivities()) ) {
      $logParams["action"] = strtoupper($body["activity"]);
    } else {
      $logParams["action"] = "NOTE";
    }
    $res = $zen->log_ticket($id,$user_id,$logParams["action"],
      $logParams["hours"], $logParams["entry"]);
    
    // log results
    if( $res ) { 
      processAttachments($id, $user_id, $msg, $res);
      egate_log("Log entry added",3); 
    }
    else { 
      egate_log("Log entry failed",2);
      return false;
    }
    
    return true;
  }
  
  /**
   * Fetch an email template, fill it in, and send it off
   */
   function egate_show_template($body,$params) {
     //todo: remove this? keeping it around for now in case we want it
      global $form_template_list;
      $str = strtolower(get_subject_param($params,"template",$body));
      if( in_array($str,$form_template_list) ) {
        egate_store_template("form_$str.template", $id);
        egate_log("returning $str form",3);
      }
      else {
        egate_log("$str is an invalid template",2);
        return false;
      }
      return true;
   }
  
  /**
  * Generate the body text from a multi-part mime message recursively.
  *
  * @param object $msg is the output of decode_contents()
  * @return string containing body
  */
  function getMultipartBody($msg, $try_html = false) {
    $body = '';
    foreach ($msg->parts as $part) {
      // don't read anything that's not text, or attachments, even if they are text
      if( $part->ctype_primary == 'text' && empty($part->disposition) ) {
        // determine what sort of text it is  
        if( $part->ctype_secondary == 'plain' ) {
          $body .= $part->body;
        }
        else if( $try_html && $part->ctype_secondary == 'html' ) {
          $body .= strip_tags($part->body);
        }
      }
      if( !empty($part->parts) ) {
        $body .= getMultipartBody($part, $try_html);
      }
    }
    return $body;
  }
  
  /**
  * Find and parse the body of a message from either plain text or from
  * multi-part mime and attach it to the message object as $msg->body
  *
  * @param object $msg is the output of decode_contents()
  */
  function findMsgBody(&$msg) {
    if( empty($msg->body) ) {
      // try for a text body
      $msg->body = getMultipartBody($msg);
      if( empty($msg->body) ) {
        // if there's no text body, try and read the html body
        $msg->body = getMultipartBody($msg, true);
      }
    }
    
    // trim reply text from email body
    if( strpos($msg->body, '>') !== false ) {
      $msg->body = preg_replace('@^\s*>.*?\n@m', '', $msg->body);
    }
    if( !empty( $egate_originalemail_prefix ) ) {
      $msg->body = preg_replace($egate_originalemail_prefix, "", $msg->body);
    }
    // removes "so-and-so wrote:" lines from the email
    $msg->body = preg_replace("/^[a-zA-Z][a-zA-Z.@_ -]+? wrote: *\r?\n?$/m", "", $msg->body);
    
    // the spacing is very pesky and hard to trim because of \r and . characters. Do this one
    // last time to try and clean it up
    $msg->body = preg_replace("@[\r\n ]+\\.?$@s", "", trim($msg->body));
    
    // replace =20 characters sometimes inserted by M$
    $msg->body = str_replace("=20", "\n", $msg->body);
  }
  
  /**
  * Find and parse attachments connected to the message
  * store them in the attachments dir and db table, attach them to
  * the ticket_id provided.
  *
  * @param int $ticket_id
  * @param int $user_id
  * @param object $msg is the output of decode_contents()
  * @param int $log_id if provided, attachments are added to a specific log
  * @return int number of attachments processed
  */
  function processAttachments($ticket_id, $user_id, $msg, $log_id = '') {
    global $zen;

    if( empty($msg->parts) ) { return 0; }

    // look for new attachments
    $c = 0;
    foreach ($msg->parts as $part) {
      $fileName = '';
      if ($part->ctype_primary == 'image') {
        if( isset($part->ctype_parameters['filename']) ) {
          $fileName = $part->ctype_parameters['filename'];
        } 
        elseif( isset($part->ctype_parameters['name']) ) {
          $fileName = $part->ctype_parameters['name'];
        } 
        else {
          $fileName = "image".$c++.".{$part->ctype_secondary}";
        }
      } 
      elseif( !empty($part->disposition) ) {
        if( isset($part->ctype_parameters['filename']) ) {
          $fileName = $part->ctype_parameters['filename'];
        }
        elseif( isset($part->ctype_parameters['name']) ) {
          $fileName = $part->ctype_parameters['name'];
        } 
        else {
          $fileName = "attachment".$c++.".{$part->ctype_secondary}";
        }
      }
      if( $fileName ) {
        $dir = $zen->attachmentsDir;
        $fileId = $zen->getAttachmentName($ticket_id);
        $fileType = $part->ctype_primary . "/" . $part->ctype_secondary;
        $fileExt = $part->ctype_secondary;
        
        if( $zen->checkAttachmentExt($fileName) ) {
          $fp = fopen("$dir/$fileId", 'w');
          fputs($fp, $part->body);
          fclose($fp);
          egate_log("Adding attachment($dir/$fileId): $fileName", 2);
          if( !$comment ) { $comment = "added via egate"; }
          $parms = array("name" => $fileName, 
                         "filename" => $fileId, 
                         "filetype" => $fileType,
                         "description" => $comment);
          $zen->attach_to_ticket($ticket_id, $user_id, $parms, $log_id);
        }
        else {
          egate_log("Invalid attachment: $fileName(not in allowed types)", 2);
        }
      }
      if( !empty($part->parts) ) { 
        $c += processAttachments($ticket_id, $user_id, $part, $log_id, $comment); 
      }
    }
    return $c;
  }
  
  /**
  * Create an array of parameters that will be passed to the ticket
  * creation process as the attributes for the ticket
  * @param object $msg email properties obtain from decode_contents()
  * @param int $user_id can be null, the id of the user owning from address
  * @return array
  */
  function generate_ticket_attributes($msg, $user_id) {
    global $zen;
    global $egate_default_options;
    global $egate_create_fields;
    global $egate_create_overrides;
    
    // create the body elements
    $body = $egate_default_options;
    $body["title"] = $msg->headers["subject"];
    
    // get the message body and parse it
    findMsgBody($msg);
    $body['details'] = $msg->body;
    
    // add in overrides, if the user has specified any by putting
    // 'field:value' entries at the top of the message body
    if( $egate_create_overrides == 1 && count($egate_create_fields) > 0 ) {
      $i=0;
      $match = '/^ *('.join('|',$egate_create_fields).') *: *(.+)/i';
      while( preg_match( $match, $body['details'], $matches) && $i < 1000 ) {
        $body["{$matches[1]}"] = trim($matches[2]);
        $body['details'] = trim(preg_replace($match, '', $body['details']));
        $i++;
      }
    }
    
    // if there is a user id, he created the ticket
    $body['creator_id'] = $user_id;
    
    return $body;
  }
  
  /**
  * parse out the user's email address and name
  *
  * @param $params is the output from decode_contents()
  * @return array (name,email)
  */
  function get_name_and_email($params) {
    // initialize
    $name = "";
    $email = "";
    
    // set up the return email address
    // and the user's name, if it can be found
    $email = !empty($params->headers["reply-to"])? 
    trim($params->headers["reply-to"]) : trim($params->headers["from"]);
    if( preg_match("/([^<]*)<([a-zA-Z0-9_@.-]+)>/", $email, $matches) ) {
      $name = trim($matches[1]);
      $email = trim($matches[2]);
    }
    if( !$name ) {
      if( preg_match("/([^<]*)<([a-zA-Z0-9_@.-]+)>/", $params->headers["from"], $matches) ) {
        $name = trim($matches[1]);
      }
      else {
        $name = "unknown";
      }
    }
    $name = preg_replace('/["\'<>]/',"",$name);
    $email = preg_replace('/["\'<>]/',"",$email);
    return array($name,$email);
  }
  
  /**
  * make an email reply for the sender
  * 
  * this will send a reply to the person
  * who submitted the entry, compliant
  * with $egate_notify_level
  *
  * @param array $recipients is an indexed array of email addresses and names (names optional)
  * @param integer $id is the tickets id
  * @param boolean $success is whether action was completed successfully
  * @param string $action is the action taken
  * @return integer number of emails sent
  */
  function send_reply_mail( $recipients, $id, $success, $action ) {    
    // employ $egate_notify_level (0-3)
    global $egate_notify_level;
    global $libDir;
    global $egate_user;
    global $zen;
    global $egate_bcc_address;
    
    // get the messages
    $messages = egate_fetch_messages($egate_notify_level);
    $templates = egate_fetch_templates();
    
    // send an email if we have data
    if( !empty($messages) || !empty($templates) ) {
      $text = "";
      
      // grab the params
      $valid_actions = fetch_valid_actions($id);      
      $vals = array("success"  =>   $success,
		    "id"       =>   $id,
		    "messages" =>   $messages,
		    "action"   =>   $action,
		    "valid_actions" => $valid_actions);
      
      // create header
      $temp = new zenTemplate("$libDir/templates/email/heading.template");
      $temp->values($vals);
      $text .= $temp->process();
      
      if( $id ) {
        // create a subject
        $ticket = $zen->get_ticket($id);
        if( $ticket ) {
          $subject = "Re: #$id - {$ticket['title']}";
        }
        else {
          $subject = "Re: #$id ($action)";
        }
        $templates[] = "reply.template";
      }
      else if( $action == "template" ) {
        $subject = egate_get_subject();
        // get ticket fields we may need
        $vals = fetch_template_vals($vals);
      }
      else if( $action ) {
        $subject = "Re: $action (".($success? "successful" : "failed").")";
      } else {
        $subject = "request ".($success? "successfull":"failed");
      }
      
      if( empty($templates) ) {
        $templates = array("messages.template");
      }
      
      // include extra footer templates
      // run through templates
      foreach( $templates as $t ) {
        $temp = new zenTemplate("$libDir/templates/email/$t");
        $temp->values($vals);
        $text .= $temp->process();
      }
      
      if( $action != "help" && $action != "template" ) {
        // create footer	
        $temp = new zenTemplate("$libDir/templates/email/footer.template");
        $temp->values($vals);	
        $text .= $temp->process();
      }
      
      $subject = "[".$zen->getSetting("bot_name")."] ".$subject;
      
      // send messages
      $i=0;
      $from_address = $egate_user["email"];
      $from_fname = $egate_user["fname"];
      $from_lname = $egate_user["lname"];
      $bcc = $egate_bcc_address? "Bcc:$egate_bcc_address\r\n" : "";
      foreach($recipients as $r) {
        if( is_array($r) && count($r) && $r["email"] != $egate_user["email"] ) {
          $res = mail($r['email'],$subject,$text,"From: $from_fname $from_lname <$from_address>\r\nReply-to:$from_address\r\n$bcc");
          if( $res )
            $i++;
        }
      }
      return $i;
    }
    // if we skipped the results, we sent 0 emails
    return 0;
  }
  
  function getMultipartContent($msg) {
    $body = '';
    foreach ($msg->parts as $part) {
      if (($part->ctype_primary == 'text') and ($part->ctype_secondary == 'plain')) {
        $body .= $part->body;
      }
      if (isset ($part->parts) and (is_array($part->parts))) {
        $body .= getMultipartContent($part);
      }
    }
    if ($body == "") {
      return false;
    }
    return $body;
  }
  
  /* function checkForMail - Check for the existence of email on the pop3 server. */
  function checkForMail($conn) {
    fputs($conn, "STAT\r\n");
    $output = fgets($conn, 128);
    $ack = strtok($output, " "); // Bleed off +OK
    $numMessages = strtok(" "); // Get what we wanted
    
    egate_log("Ack: $ack, Num Messages: $numMessages\n$output", 3);
    
    if ($numMessages > 0) {
      egate_log("***New mail***",3);
    } else {
      egate_log("***No mail***", 3);
    }
    return $numMessages;
  }
  
  /* function getEmail - Collect each individual message and return to the getMessages function. */
  function getEmail($conn, $num) {
    $message = "";
    fputs($conn, "RETR $num\r\n");
    $output = fgets($conn, 512);
    
    if (strtok($output, "+OK")) {
      while (!ereg("^\.\r\n", $output)) {
        $output = fgets($conn, 512);
        $message .= $output;
      }
    }
    else {
      egate_log($output, 2);
    }
    
    return $message;
  }
  
  /* function deleteMessage - Delete messages from pop3 server after downloading them. */
  function deleteMessage($conn, $message) {
    fputs($conn, "DELE $message\r\n");
  }
  
  /* function popConnect - Connects to the designated pop3 mail server, using the supplied credentials. */
  function popConnect($host, $port, $user, $pass) {
    $errno = "";
    $errstr = "";
    $conn = fsockopen($host, $port, $errno, $errstr, 90);
    if (!$conn) {
      egate_log("Connect Failed: $errstr($errno)",1);
      return false;
    } else {
      egate_log(fgets($conn, 128), 3);
      fputs($conn, "USER $user\r\n");
      egate_log(fgets($conn, 128), 3);
      fputs($conn, "PASS $pass\r\n");
      egate_log(fgets($conn, 128), 3);
      return $conn;
    }
  }
  
  /* function getMessages - Collects email messages from a pop3 server, and returns them as an array of messages.
  *                        Calls function getEmail to download each individual message. Returns an array of
  *                        of email messages. */
  function getMessages($conn) {
    $numMessages = checkForMail($conn);
    
    if ($numMessages > 0) {
      $mailArray = array ();
      for ($i = 0; $i < $numMessages; $i ++) {
        $mailArray[$i] = getEmail($conn, $i + 1);
        deleteMessage($conn, $i + 1);
      }
      return $mailArray;
    }
  }
  
  /* function popDisconnect - Disconnects the pop3 session. */
  function popDisconnect($conn) {
    fputs($conn, "QUIT\r\n");
    egate_log(fgets($conn, 128), 3);
    fclose($conn);
    $conn = 0;
  }
  
  /**
  * @param string $subject
  * @return int ticket id from subject or false if none
  */
  function get_ticket_id_from_subject($subject) {
    preg_match( '@#([0-9]+)@', $subject, $matches );
    if( count($matches) > 1 ) { return $matches[1]; }
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
  
  /*
  **  This function reads emails and does one of two things, based on the subject
  **  of the email. If the email begins with #nn (where nn is a number), then
  **  this function will add a log entry with the contents of the email as the message.
  **
  **  If the subject does not begin with #nn, then a new ticket is created with
  **  the contents of the email as the descripion of the problem and the subject
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
  **
  ** @param string $input the raw email message
  ** @return boolean false on error or true if ok
  */
  function do_helpdesk_message($input) {
    global $egate_user;
    
    // determine if the subject has a ticket id
    $params = decode_contents($input);
    
    // extract the values of interest to us
    $from = empty($params->headers['reply-to'])? $params->headers['from'] : $params->headers['reply-to'];
    $subject = $params->headers['subject'];
    $id = get_ticket_id_from_subject($subject);
    
    if( $id ) { $ticket = get_ticket($id); }
    else { $ticket = false; }
    
    list($name,$email) = get_name_and_email($params);
    $user_id = find_user_id($name,$email);
    $attributes = generate_ticket_attributes($params, $user_id);
    $body = $attributes['details'];
    
    // perform some simple validation
    if( !$from || !$body || !$subject || ($id && !$ticket) ) {
      if( !$from )    { egate_log('Malformed message, missing FROM address', 1);  }
      if( !$subject ) { egate_log('Malformed message, missing Subject', 1);       }
      if( !$body )    { egate_log('Malformed message, missing message body', 1);  }
      if( !$ticket )  { egate_log("Ticket #$id not found", 1); }
      if( !$from ) {
        egate_log("unable to send reply message (no return address)", 1);
        return false;
      }
      $email_subject = "Your message couldn't be processed";
      $email_body = $email_subject . " due to the following errors:\n";
      $error_text = "Unable to process message:\n";
      foreach( egate_fetch_messages(1) as $m ) {
        $error_text .= " - $m\n";
        $email_body .= "\t$m\n";
      }
      $email_body .= "\nThe original message is below...\n------------------\n";
      $email_body .= $input;
      mail($from, $email_subject, $email_body, "From:".$egate_user['email']);
      egate_log($error_text, 1);
      return false;
    }
    
    if( $id ) {
      // we create a log message
      egate_log_to_ticket($name,$email,$params,$ticket,$attributes);
      egate_log("Updated ticket #$id for $user_id/$name/$email",3);
    }
    else {
      // we create a new ticket
      $id = create_new_ticket($user_id, $name, $email, $attributes, $params);
      if( $id ) {
        egate_log("Created ticket #$id for $user_id/$name/$email",3);
      }
      else {
        egate_log("Failed to create ticket",1);
      }
      $rec = array(array("name"=>$name,"email"=>$email));
      send_reply_mail($rec, $id, $id !== false, "new ticket");
    }
    return true;
  }
  
}?>