<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Contains the ZenTicketList class.  Requires ZenList.php
 * @package Zen
 */

/** 
 * Contains a set of ZenTicket data.
 * @package Zen 
 */
class ZenTicketList extends ZenList {

  /**
   * CONSTRUCTOR
   *
   * Creates an empty ticket list.
   * 
   * This method should also call the ZenList::ZenList() constructor and pass it a ZenMetaTable
   * object corresponding to this list type
   */
  function ZenTicketList() { }

  /**
   * returns the relationship information for a specific ticket
   *
   * NOTE: the ticket requested must be in this list!
   *
   * @param integer $id ticket in question (returns the id of the current index if none is specified)
   * @return ZenRelatedList for ticket in question
   */
  function getRelations( $id = 0 ) { }
  
}

?>
