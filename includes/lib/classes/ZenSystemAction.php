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
   */

  //todo

  /**
   * Create data type entry
   */
  
  //todo

  /**
   * Edit data type entry
   */
  
  //todo

  /**
   * Delete data type entry
   */

  //todo

  /**
   * Move ticket
   */

  //todo

  /**
   * Assign ticket
   */

  //todo

  /**
   * Send Notification
   */
  
  //todo

  /**
   * Change ticket status
   */

  //todo

  /**
   * Create log entry
   */

  //todo

  /**
   * Get actions
   */
  
  //todo

  /**
   * Get notify list
   */
  
  //todo
  
  /**
   * Add to notify list
   */
   
  //todo
  
  /**
   * Remove from notify list
   */
   
  //todo

  /**
   * Get triggers
   *
   * @access private
   */
  
  //todo

  /**
   * Edit the values of a row of data in the database.
   *
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

    //todo
    //todo check triggers
    //todo

    // run and return
    return ($query->update() > 0)? true : false;
  }

  /**
   * Send an email message   
   *
   * @param array $to contains valid email addresses for recipients of email
   * @param string $subject contains the subject of the email
   * @param string $from contains the sender
   * @param string $replyto contains the address replies will be sent to
   * @param array $cc contains valid email addresses for CC recipients
   * @param array $bcc contains valid email addresses for BCC recipients
   * @return boolean true if email sent correctly
   */
  function sendEmail($to, $subject, $from, $replyto, $cc = null, $bcc = null) { 

    //todo
    //todo check triggers
    //todo

    
  }
  
  /**
   * Executes a user function from the user_functions.php class
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
   * Executes an external shell script or batch file.  
   *
   * Note that this script runs with permissions of the 
   * web server user.  Any action this script will take 
   * must be allowed to the user, and this script
   * must be executable by the user.
   *
   * @param string $script the script/command to execute
   * @param array $args contains (String)argument values to be passed
   * @return mixed if the script returns a value, this value is returned here too
   */
  function runScript( $script, $args = null ) {
    return ZenUtils::runScript($script, $args);
  }

  /**
   * Executes another user defined action
   *
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
   * Runs a helper script
   *
   * @param string $name name of helper.. it will translate to lib/helpers/action_$name.php
   * @param array $args contains (String)argument values to be passed to helper
   * @return mixed value returned by helper
   */
  function runHelper( $name, $args ) {
    return ZenUtils::runHelper("action_$name", $args);
  }

  /**
   * Returns a value from somewhere in the server scope
   *
   * If no scope is provided, then this method searches the following
   * locations, in order: _SESSION, _GLOBALS
   *
   * @param string $name name of variable to return
   * @param string $key if the variable is an array $key can be an index in that array 
   * @return mixed value of variable or null if not found
   */
  function getScope( $name, $key = null ) {
    return ZenUtils::findGlobal($name, $key);
  }

  /**
   * Returns a value from the environment settings, searching
   * the following locations, in order: _SERVER, _ENV, HTTP_VARS
   *
   * @param string $name name of variable
   * @param string $key if the variable is an array $key can be an index in that array 
   * @return mixed value of variable or null if not found
   */
  function getEnvProperty( $name, $key = null ) {
    return ZenUtils::findEnv($name, $key);
  }

  /**
   * Return an ini file setting from zen.ini file
   *
   * @param string $category
   * @param string $name
   * @return mixed value of ini property
   */
  function getIniProperty( $category, $name ) {
    return ZenUtils::getIni($category, $name);
  }

  /**
   * Return a setting from the database
   *
   * @param string $category
   * @param string $name
   * @return mixed value of setting
   */
  function getDbSetting( $category, $name ) {
    return Zen::getSetting($category, $name);
  }

  /**
   * Returns a value from somewhere in the page request scope.  The following
   * locations are searched, in order:
   *
   * _POST, _GET
   *
   * @param string $name name of variable to return
   * @return value of variable or null if not found
   */
  function getFormValue( $name ) { 
    if( isset($_POST) && isset($_POST[$name]) ) { return $_POST[$name]; }
    if( isset($_GET) && isset($_GET[$name]) ) { return $_GET[$name]; }
    return null;
  }

  /**
   * Returns a date/time value
   *
   * @param string $date any format, even +1 day, -2 weeks, etc (see http://php.net/strtotime for more details)
   * @return integer date format for use in db
   */
  function getTime( $date ) {
    $euroDate = Zen::getSetting('dates','use_euro_date');
    return ZenUtils::parseDate($format);
  }
  
  /**
   * Returns date string formatted for display (according to user preferences and db settings)
   *
   * @param string $date any format, even +1 day, -2 weeks, etc (see http://php.net/strtotime for more details)
   * @return string $date formatted for display
   */
  function getDateString($date) {
    return Zen::showDate(ZenSystemAction::getDateTime($date));
  }

  /**
   * Returns date/time string formatted for display (according to user preferences and db settings)
   *
   * @param string $date any format, even +1 day, -2 weeks, etc (see http://php.net/strtotime for more details)
   * @return string $date formatted for display
   */
  function getDateTimeString($date) {
    return Zen::showDateTime(ZenSystemAction::getDateTime($date));
  }

}

?>
