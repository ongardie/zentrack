<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenSystem class.  Requires ZenDataType.php
 * @package Zen
 */

/**
 * A system represents a component or area of work that a ticket might be relevant to, such as
 * "website", "mail server", or "marketing charts".
 *
 * @package Zen 
 */
class ZenSystem extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * Loads a ZenSystem object for use
   *
   * @param integer $system_id is the id of the system (optional)
   * @param ZenSystemList $list (optional)loads the system from a ZenSystemList rather than database
   */
  function ZenSystem( $system_id = null, $list = null ) { 
    $this->ZenList($system_id, $list);
  }

}

?>
