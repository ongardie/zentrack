<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * @package Zen 
 *
 * The main ticket control functions
 */
class ZenTicket extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * loads a blank ticket object, or loads a ticket by id
   * 
   * @param integer $ticket_id (optional)id of ticket to load
   * @param ZenTicketList $list (optional)loads the ticket from a ZenTicketList rather than database
   */
  function zenTicket( $ticket_id = 0, $list = null ) { }

  /**
   * copies an existing ticket to this one
   *
   * Note that it is NOT considered the same ticket... running
   * save() will create a new ticket in the db.
   *
   * @param integer $ticket_id to be copied to this object
   * @return boolean copy succeeded
   */
  function copy( $ticket_id = 0 ) { }
   
   /**
   * returns the notify object associated with this ticket
   *
   * @return NotifyObject the NotifyObject associated with this ticket
   */
  function getNotify() { }

  /**
   * returns a list of tickets related to this one
   *
   * @return ZenRelatedList list of tickets related to this one
   */
  function getRelations() { }

  /**
   * returns a list of actions which are available to this ticket
   * 
   * @return ZenActionList list of actions (note that some of these actions may be disabled by ticket status)
   */
  function getActions() { }
  
  /**
   * Perform next action in flowpath
   * 
   * Validates the ticket's status based on flowpath
   * requirements and attempts to execute next action
   */
  function next() { }

  /* VARIABLES */
  
}

?>