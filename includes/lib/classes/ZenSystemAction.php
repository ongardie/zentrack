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
    ZenUtils::safeDebug("ZenSystemAction", "init", "There is no need to instantiate this class"
                        160, LVL_WARN);    
  }
  
  /**
   * Load a new page (redirect user) and send parms as url arguments
   *
   * @param string $newUrl is the page to load (this should be relative, $ini['paths']['url_www'] will be added)
   * @param array $args contains key/value pairs that will be suffixed ( url.php?key1=value1&key2=value2... )
   */
  function loadUrl( $newUrl, $args ) { }

  /**
   * STATIC: Create an entry into a standard data type table (ticket, user, log, priority, etc)
   *
   * @static
   * @param string $table the database table to insert to
   * @param array $args the values to be inserted
   */
  function newData( $table, $args ) { }

  /**
   * STATIC: Edit the values of a row of data in the database.
   *
   * @static
   * @param Array $vals mapped (String)field => (mixed)value
   * @param String $table is the tablename without prefix (prefix is defined in zen.ini->db->db_prefix)
   * @param mixed $id is the value of the primary key for this row or the unique field defined by $keyname
   * @param String $keyname defines field used to identify row(must have a unique value), defaults to the primary key for this table
   * @return boolean true if row edited successfully
   */
  function editData( $vals, $table, $id, $keyname = null ) {
    // set the row id
    if( $keyname == null ) {
      $keyname = $this->_dbo->getPrimaryKey($table);      
    }
    // set up query
    $query = Zen::getNewQuery();
    $query->table($table);
    foreach($vals as $key=>$val) {
      $query->field($key, $val);
    }
    $query->match($keyname, $id);

    // run and return
    return $query->update()? true : false;
  }

  /**
   * STATIC: Delete an entry from a standard data type table
   *
   * @static
   * @param string $table the database table to insert to
   * @param int $rowid the primary key for this table
   */
  function deleteData( $table, $rowid ) { }

  /**
   * STATIC: Send a notification for a ticket.  This occurs whenever an event
   * is launched which is deemed appropriate to notify users who are
   * monitoring this ticket.
   *
   * @static
   * @param integer $ticket_id for the ticket modified
   * @param integer $action_id the action which occurred
   * @param integer $user_id the user performing the event
   * @param integer $priority the importance of the notification (see {@link ZenNotifyList})
   * @param integer $comments user comments about the event
   */
  function sendNotification( $ticket_id, $action_id, $user_id, $priority, $comments ) { 

    //todo
    //todo ideally this will create an instance of ZenNotifyList and call the method there to send notifications
    //todo

  }

  /**
   * STATIC: Send an email message   
   *
   * @static
   * @param array $to contains valid email addresses for recipients of email
   * @param string $subject contains the subject of the email
   * @param string $from contains the sender
   * @param string $replyto contains the address replies will be sent to
   * @param array $cc contains valid email addresses for CC recipients
   * @param array $bcc contains valid email addresses for BCC recipients
   * @return boolean true if email sent correctly
   */
  function sendEmail($to, $subject, $from, $replyto, $cc = null, $bcc = null) { 

    //todo: maybe some of these could be combined into an array called $args
    //todo: and we could use them if they exist, perhaps default them, etc...
    //todo: play with the params here as you see fit
    //todo:
    //todo: also, check out ZenEmail, which is what we should use to generate
    //todo: email messages... eventually ZenEmail will use templates to set
    //todo: up and send messages (for maximum flexibility)
  
  }
  
  /**
   * STATIC: Executes a user function from the user_functions.php class
   *
   * Note that the user method is assumed to return a valid value that
   * can be used by the action calling this, and no validation is done
   * by this method.
   *
   * @static
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
   * must be allowed to the user, and this script
   * must be executable by the user.
   *
   * @static
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
   * @static
   * @param integer $action_id id of action to run
   * @param array $args any arguments to pass to the action
   * @param ZenActionList $list if provided, will be used to create action (for db efficiency)
   * @return the return value of the action
   */
  function runAction( $action_id, $args = null, $list = null ) {
    $act = new ZenAction($action_id);
    $act->activate($args);
  }

  /**
   * STATIC: Runs a helper script
   *
   * @static
   * @param string $name name of helper.. it will translate to lib/helpers/action_$name.php
   * @param array $args contains (String)argument values to be passed to helper
   * @return mixed value returned by helper
   */
  function runHelper( $name, $args ) {
    return ZenUtils::runHelper("action_$name", $args);
  }

}

?>
