<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenStage class.  Requires ZenDataType.php
 * @package Zen
 */

/** 
 * A stage represents a step in the ticket life cycle, such as New, Open, Pending, 
 * Ready for Testing, Closed, etc.
 * 
 * @package Zen 
 */
class ZenStage extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * Loads a ZenStage object for use
   *
   * @param integer $stage_id is the id of the stage (optional)
   * @param ZenStageList $list (optional)loads the stage from a ZenStageList rather than database
   */
  function ZenStage( $stage_id = null, $list = null ) { }

}

?>
