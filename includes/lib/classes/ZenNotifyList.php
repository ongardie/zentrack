<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenNotifyList class.  Requires ZenList.php
 * @package Zen
 */

/**
 * ZEN_NOTIFY_LOWEST the least important type of notification
 */
define('ZEN_NOTIFY_LOWEST', 1);

/**
 * ZEN_NOTIFY_NORMAL the least important type of notification
 */
define('ZEN_NOTIFY_NORMAL', 2);

/**
 * ZEN_NOTIFY_HIGHEST the least important type of notification
 */
define('ZEN_NOTIFY_HIGHEST', 3);

/** 
 * Contains a set of ZenNotify data.  (this is a list of users to be notified under
 * specific conditions for a given ticket.
 *
 * @see ZenDataType
 * @see ZenList
 * @package Zen 
 */
class ZenNotifyList extends ZenList {

  /**
   * CONSTRUCTOR: create an instance of ZenNotifyList given a ticket id and
   * load the appropriate users monitoring this list
   *
   * @param int $ticket_id the ticket this notify list corresponds to
   */
  function ZenNotifyList($ticket_id) {
    $this->ZenList();
    $crit = new ZenSearchParms();
    $crit->match('ticket_id', ZEN_EQ, $ticket_id, 'NOTIFY');
    $this->criteria($crit);
    $this->load( $ids, false );
  }

  /**
   * Send a notification for a ticket.  When this method is called, it
   * will generate a list of email addresses from the NOTIFY table for users
   * monitoring this ticket, filtered on the priority of the notification,
   * and then generate emails appropriately.
   *
   * @param integer $ticket_id for the ticket modified
   * @param integer $action_id the action which occurred
   * @param integer $user_id the user performing the event
   * @param integer $priority the importance of the notification (see constants above)
   * @param integer $comments user comments about the event
   */
  function sendNotification( $action_id, $user_id, $priority, $comments ) { }

  /**
   * Returns a list of email addresses which represent the recipients of this notification
   *
   * @param integer $priority the priority filter for users, if null, all users in this list are returned
   */
  function getRecipients( $priority = null ) {
    $vals = array();
    foreach($this->_ids as $id) {
      $row = $this->get($id);
      if( !$priority || $row->getField('field_pri') >= $priority ) {
        $vals[] = $row->getField('email');
      }
    }
    return $vals;
  }

}

?>
