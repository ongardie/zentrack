<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenSystemAction class.  Requires Zen.php
 * @package Actions
 */

/** 
 * The ZenSystemAction class provides the base API for creating
 * and utilizing all user defined actions.  It comprises the 
 * essential events that define the abilities of the ZenTrack
 * system.
 *
 * When using this class, always use the {@link ZenSystemAction::getInstance()} instead
 * of the default constructor.  There is a significant amount of overhead involved in
 * loading this class, and only one instance is necessary.
 *
 * @package Actions
 */
class ZenSystemAction extends Zen {
  
  /**
   * CONSTRUCTOR: no need to call this (methods are static)
   */
  function ZenSystemAction() {
    ZenUtils::safeDebug("ZenSystemAction", "init", "There is no need to instantiate this class",
                        160, LVL_WARN);    
  }
  
  /**
   * Load a new page (redirect user) and send parms as url arguments
   *
   * @param string $newURL is the page to load (this should be relative, $ini['paths']['url_www'] will be added)
   * @param array $args contains key/value pairs that will be suffixed ( url.php?key1=value1&key2=value2... )
   */
  function loadUrl( $newURL, $args ) {
  	global $ini;
  	//Make URL relative to the root.
  	$newURL = rtrim($ini['paths']['url_www'], '/') . '/' . $newURL;
  	
  	if (is_array($args) && count($args) > 0) {
  		$nameValuePairs = array();
	  	foreach ($args as $name => $value) {
	  		$nameValuePairs = urlencode($name) . '=' . $urlencode($value);
	  	}
	  	$newURL .= '?' . implode('&', $nameValuePairs);
  	}
  	header("Location: $newURL");
  	exit;
  }

  /**
   * STATIC: Create an entry into a standard data type table 
   * (ticket, user, log, priority, etc)
   *
   * This method should check each value of args against the meta data
   * for the given table and ignore arguments which don't correspond
   * to field names (because the action args may include other values too)
   *
   * @param string $table the database table to insert to
   * @param array $args the values to be inserted
   */
  function newData( $table, $args ) {
  	$query = Zen::getNewQuery();
  	$query->table($table);
  	//retrieve the valid field names for this table;
	$zenDbSchema =& Zen::getZenDbSchema();
	$dbTableInfo = $zenDbSchema->getTableArray($table);
	$validFieldNames = array();
	foreach($dbTableInfo['fields'] as $fieldInfo) {
		$validFieldNames[$fieldInfo['name']] = true;
	}
	
	//Loop through the given arguments
  	foreach ($args as $name=>$value) {
  		//check for valid field
  		if ($validFieldNames[$name]) {
			$query->field($name, $value);
  		}
  	}
  	return $query->insert()?true:false;
  }

  /**
   * STATIC: Edit the values of a row of data in the database.
   *
   * This method should check each value of $vals against the
   * meta data for this table and discard any arguments which
   * do not correspond to fields in the table. (extra arguments
   * might exist)
   * 
   * @param Array $vals mapped (String)field => (mixed)value
   * @param String $table is the tablename without prefix (prefix is defined in zen.ini->db->db_prefix)
   * @param mixed $id is the value of the primary key for this row or the unique field defined by $keyname
   * @param String $keyname defines field used to identify row(must have a unique value), defaults to the primary key for this table
   * @return boolean true if row edited successfully
   */
  function editData( $vals, $table, $id, $keyname = null ) {
    //set up valid field names
	$zenDbSchema =& Zen::getZenDbSchema();
	$dbTableInfo = $zenDbSchema->getTableArray($table);
	$validFieldNames = array();
	foreach($dbTableInfo['fields'] as $fieldInfo) {
		$validFieldNames[$fieldInfo['name']] = true;
	}

	// set up query
    $query = Zen::getNewQuery();
    $query->table($table);
    foreach($vals as $key=>$val) {
      //check for valid field
  	  if ($validFieldNames[$key]) {
		$query->field($key, $val);
  	  }
    }
    if (isset($keyname)) {
	  $query->match($keyname, $id);
    } else {
      $query->matchId($id);
    }

    // run and return
    return $query->update()? true : false;
  }

  /**
   * STATIC: Delete an entry from a standard data type table
   *
   * @param string $table the database table to insert to
   * @param int $rowid the primary key for this table
   */
  function deleteData( $table, $rowid ) {
    $query = Zen::getNewQuery();
    $query->table($table);
    $query->matchId($rowid);
  }

  /**
   * STATIC: Send a notification for a ticket.  This occurs whenever an event
   * is launched which is deemed appropriate to notify users who are
   * monitoring this ticket.
   *
   * @param integer $ticket_id for the ticket modified
   * @param integer $action_id the action which occurred
   * @param integer $user_id the user performing the event
   * @param integer $priority the importance of the notification (see {@link ZenNotifyList})
   * @param integer $comments user comments about the event
   */
  function sendNotification( $ticket_id, $action_id, $user_id, $priority, $comments ) { 
  	$zenNotifyList = new ZenNotifyList($ticket_id);
  	$zenNotifyList->sendNotification($action_id, $user_id, $priority, $comments);
  }

  /**
   * STATIC: Send an email message   
   *
   * @param array $to contains valid email addresses for recipients of email
   * @param string $subject contains the subject of the email
   * @param string $from contains the sender
   * @param string $message contains the message to send
   * @param string $replyto contains the address replies will be sent to defaults to the address used for $from
   * @param array $cc contains valid email addresses for CC recipients
   * @param array $bcc contains valid email addresses for BCC recipients
   * @return boolean true if email sent correctly
   */
  function sendEmail($to, $subject, $from, $message, $replyto = null, $cc = null, $bcc = null) {
	$zenEmail = new ZenEmail($from, $subject, $message);
	
	if (isset($replyto) && $replyto != '') {
		$zenEmail->addHeader("Reply-To: $replyto");
	}
	if (isset($cc) && $cc != '') {
		$zenEmail->addHeader("Cc: $cc");
	}
	if (isset($bcc) && $bcc != '') {
		$zenEmail->addHeader("Bcc: $bcc");
	}
	$zenEmail->setRecipients($to);
	return $zenEmail->send();

  }
  
  /**
   * STATIC: Executes a user function from the user_functions.php class
   *
   * Note that the user method is assumed to return a valid value that
   * can be used by the action calling this, and no validation is done
   * by this method.
   *
   * @param string $userFxn the function to run
   * @param array $args contains any arguments to pass to the method
   * @return mixed whatever is returned by the user function
   */
   function runUserFxn( $userFxn, $args ) {
     return ZenUtils::callUserFunction($userFxn, $args); 
   }

  /**
   * STATIC: Executes an external shell script or batch file.  
   *
   * Note that this script runs with permissions of the 
   * web server user.  Any action this script will take 
   * must be allowed to the server process(nobody/apache), 
   * and this script must be executable by the server process.
   *
   * @param string $script the script/command to execute
   * @param array $args contains (String)argument values to be passed
   * @return mixed if the script returns a value, this value is returned here too
   */
  function runScript( $script, $args = null ) {
    return ZenUtils::runScript($script, $args);
  }

  /**
   * STATIC: Executes another user defined action
   *
   * @param integer $action_id id of action to run
   * @param array $args any arguments to pass to the action
   * @param ZenActionList $list if provided, will be used to create action (for db efficiency)
   * @return the return value of the action
   */
  function runAction( $action_id, $args, $list = null ) {
  	if (isset($list)) {
  	  $act = $list->get($action_id);
  	} else {
      $act = new ZenAction($action_id);
  	}
    $act->activate($args);
  }

  /**
   * STATIC: Runs a helper script
   *
   * @param string $name name of helper.. it will translate to lib/helpers/action_$name.php
   * @param array $args contains (String)argument values to be passed to helper
   * @return mixed value returned by helper
   */
  function runHelper( $name, $args ) {
    return ZenUtils::runHelper("action_$name", $args);
  }

}

?>
