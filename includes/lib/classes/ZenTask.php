<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenTask class.  Requires ZenDataType.php
 * @package Zen
 */

/** 
 * A task represents a type of action performed on a ticket.  This could be a log entry, labor, or
 * other user defined tasks which a worker might enter into the tracking system.
 * 
 * @package Zen 
 */
class ZenTask extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * Loads a ZenTask object for use
   *
   * @param integer $task_id is the id of the task (optional)
   * @param ZenTaskList $list (optional)loads the task from a ZenTaskList rather than database
   */
  function ZenTask( $task_id = null, $list = null ) { }

}

?>
