<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * The ZenTrigger class is a base class for triggers
 * 
 * There should be several properties associated with triggers:
 * <ul>
 *   <li>Catalyst Type
 *   <ul>
 *     <li>Time Based (when a time span is entered/exited)
 *     <li>Value Based (when a value changes)
 *     <li>Action Based (when an action is performed)
 *   </ul>
 *   <li>Fields - the time field, action or value field to reference
 *   <li>Values - the value to check against
 *   <li>Operator - how to check (>, <, >=, <=, =, !=, etc)
 *   <li>Exceptions - times to ignore this trigger
 * </ul>
 *
 * Triggers can be attached to:
 * <ul>
 *   <li>Ticket types
 *   <li>Actions
 *   <li>Triggers
 *   <li>Specific Tickets
 *   <li>User Groups
 *   <li>Users
 * </ul>
 *
 * The sub-classes to derive from this one
 * <ul>
 *    <li>ZenTimeTrigger
 *    <li>ZenActionTrigger
 *    <li>ZenFieldTrigger
 * </ul>
 * 
 * @package Zen 
 */
class ZenTrigger extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * Either creates a blank trigger or loads an existing trigger
   *
   * @param integer $trigger_id the trigger to load (optional)
   * @param ZenTriggerList $list (optional)loads the trigger from a ZenTriggerList rather than database
   */
  function ZenTrigger( $trigger_id = null, $list = null ) { 
    $this->ZenDataType( $trigger_id, $list);
  }

  /**
   * Checks to see if this trigger's conditions have been met, if so, calls activate()
   *
   * @return boolean activated
   */
  function check() { }

  /**
   * Adds a new time based condition to the trigger
   *
   * @param string $field a ticket field (or a special term) to place the trigger on
   * @param integer $base 
   * @param integer $span
   * @return integer condition_id or false
   */
  function addTimeCondition( $field, $base, $span ) { }

  /**
   * Adds a new action based condition
   *
   * @param integer $action_id the id of the action to be used
   * @return integer condition_id or false
   */
  function addActionCondition( $action_id ) { }

  /**
   * Adds a new value based action
   *
   * @param string $field a ticket field to place the trigger on
   * @param string $value a value to check for
   * @param string $comparison (use the ZEN_* constants)
   * @return integer condition_id or false
   */
  function addValueCondition( $field, $value, $comparison ) { }

  /**
   * Adds a condition to the trigger
   *
   * @param array $values associative array of db_field=>value to be used
   * @return integer condition_id or false
   */
  function _addCondition( $params ) { }

}

?>
