<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * @package Zen 
 */
class ZenAction extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * Loads a ZenAction object for use
   *
   * @param integer $action_id is the id of the action (optional)
   * @param ZenActionList $list (optional)loads the action from a ZenActionList rather than database
   */
  function ZenAction( $action_id = null, $list = null ) { }

  /**
   * Performs action (also checks all associated triggers)
   *
   * @param array $params specifies the required parameters for the action
   */
  function activate( $params ) { }


}

?>