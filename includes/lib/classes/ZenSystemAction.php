<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * The ZenSystemAction class provides the base API for creating
 * and utilizing all user defined actions.  It comprises the 
 * essential events that define the abilities of the ZenTrack
 * system.
 *
 * @package Zen 
 */
class ZenSystemAction extends Zen {

  /**
   * CONSTRUCTOR
   *
   * Loads a ZenSystemAction object for use
   */
  function ZenSystemAction() {
    $this->Zen();
    $this->_dbo =& Zen::getDbConnection();
  }

  /**
   * Edit the values of a row of data in the database.
   *
   * @param Array $vals mapped (String)field => (mixed)value
   * @param String $table is the tablename without prefix (prefix is defined in zen.ini->db->db_prefix)
   * @param mixed $id is the value of the primary key for this row or the unique field defined by $keyname
   * @param String $keyname defines field used to identify row(must have a unique value), defaults to the primary key for this table
   * @return boolean true if row edited successfully
   */
  function editData( $vals, $table, $id, $keyname = null ) { }

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
  function sendEmail() { }

  //todo: runScript
  //todo: runAction
  //todo: getValue
  //todo: 

  /** 
   * @var array $_fxns contains a map of the functions in this method and parameters used to call them
   */
  var $_fxns;

  /** @var ZenDatabase $_dbo the database connection */
  var $_dbo;
}

?>
