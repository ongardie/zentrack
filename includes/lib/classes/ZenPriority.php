<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenPriority class.  Requires ZenDataType.php
 * @package Zen
 */

/**
 * A priority represents a level of importants for a ticket.  This could be things like Critical, Low, etc.
 * @package Zen 
 */
class ZenPriority extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * Loads a ZenPriority object for use
   *
   * @param integer $priority_id is the id of the priority (optional)
   * @param ZenPriorityList $list (optional)loads the priority from a ZenPriorityList rather than database
   */
  function ZenPriority( $priority_id = null, $list = null ) { }

}

?>
