<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Contains the ZenAction class.  Requires ZenDataType.php
 * @package Actions
 */

/**
 * Contains a user defined action which is used to collect arguments and
 * run a system action.
 *
 * @see ZenSystemAction
 * @see ZenParms 
 * @package Actions
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
  function ZenAction( $action_id, $list = null) { 
    $this->ZenDataType($action_id, $list);
    $query = Zen::getNewQuery();
    $query->table('ACTION_STEPS');
    $query->match('action_id', $action_id);
    $query->sort('action_pri');
    $this->_steps = $query->select(Zen::getCacheTime(), true);
  }

  /**
   * Performs action (also checks all associated triggers)
   *
   * @return boolean true if criteria was met and action ran normally
   */
  function activate() { 
    $debugName = $this->getField('action_name');
    ZenUtils::prep("ZenCriteriaSet");
    // check the action criteria and insure
    // that this action can be run
    $cid = $this->getField('criteria_set_id');
    if( strlen($cid) ) {
      $crit = new ZenCriteriaSet( $cid );
      if( !$crit->evaluate() ) {
        $this->debug($this, "activate", "Criteria not met, action skipped: $debugName",
                     0, LVL_DEBUG);
        return false;
      }      
    }
    
    // make sure we have steps to execute
    if( !is_array($this->_steps) ) {
      $this->debug($this, "activate", "No steps to run, exiting: $debugName", 161, LVL_NOTE);
      return false;
    }
    
    // iterate and run steps, return false on a halt    
    foreach($this->_steps as $s) {
      if( !$this->_step($s) ) {
        $this->debug($this, "activate", "Action halted by step failure: $name", 621, LVL_NOTE);
        return false;
      }
    }
    return true;
  }

  /**
   * Check criteria and execute a step, return whether we should continue or stop here
   *
   * @param array $parms contains the data for this step's execution (from database)
   * @return boolean continue(true) or halt execution(false)
   */
  function _step( $parms ) {
    ZenUtils::prep("ZenCriteriaSet");

    // just for easy reference
    $debugName = $this->getField('action_name')."->{$parms['action_name']}";

    // check the criterie and return if criteria
    // is not met, indicating whether remaining steps
    // should be ran or not
    if( strlen($parms['criteria_set_id']) ) {
      $crit = new ZenCriteriaSet( $parms['criteria_set_id'] );
      if( !$crit->evaluate() ) {
        $this->debug($this, "activate", "Criteria not met for step: $debugName",
                     620, LVL_NOTE);
        return $parms['action_fail']? true : false;
      }
    }
    
    // gather arguments to be passed to system action
    $args = array();
    $parmList = new ZenParmList($parms['parm_set_id']);
    while($parmList->hasNext()) {
      $parm = $parmList->next();
      $args[ $parm->name() ] = $parm->value();
    }

    // print some useful debug info
    $debugTxt = "Running $debugName:";
    foreach($args as $k=>$v) {
      $v = strlen($v) > 10? substring($v,0,7).'...';
      $debugTxt .= " [$k=$v]";
    }
    $this->debug($this, "activate", $txt, 0, LVL_DEBUG);
    
    // run appropriate system action and evaluate results
    switch($parms['action_type']) {
    case "action":
      $result = ZenSystemAction::runAction($args['action_id']);
      break;
    case "add":
      $result = ZenSystemAction::newData($args['table'], $args['args']);
      break;      
    case "delete":
      $result = ZenSystemAction::deleteData($args['table'], $args['rowid']);
      break;
    case "edit":
      if( !isset($args['keyname']) ) { $args['keyname'] = null; }
      $result = ZenSystemAction::editData($args['vals'], $args['table'],
                                          $args['id'], $args['keyname']);
      break;
    case "email":
      if( !isset($args['cc']) ) { $args['cc'] = null; }
      if( !isset($args['bcc']) ) { $args['bcc'] = null; }
      $result = ZenSystemAction::sendEmail($args['to'], $args['subject'],
                                           $args['from'], $args['message'], $args['replyto'],
                                           $args['cc'], $args['bcc']);
      break;
    case "helper":
      $result = ZenSystemAction::runHelper($args['name'], $args);
      break;
    case "notify":
      if( !isset($args['comments']) ) { $args['comments'] = null; }
      $result = ZenSystemAction::sendNotification($args['ticket_id'],
                                                  $args['action_id'],
                                                  $args['user_id'],
                                                  $args['priority'],
                                                  $args['comments']);
      break;
    case "url":
      $result = ZenSystemAction::loadUrl($args['newUrl'], $args['args']);
      break;
    case "user":
      $result = ZenSystemAction::runUserFxn($args['userFxn'], $args);
      break;
    default:
      $this->debug($this, '_step',
                   "Invalid action type ({$parms['action_type']}): $debugName",
                   105, LVL_ERROR);
      $result = false;
    }
    if( !$result ) {
      $this->debug($this, '_step',
                   "System step failed: $debugName",
                   621, LVL_NOTE);
      return $parms['action_fail']? true : false;
    }
    $this->debug($this, '_set',
                 "Action step completed: $debugName",
                 621, LVL_NOTE);
    return true;
  }

  /** @var array $_steps contains the steps to be completed for this action */
  var $_steps;

}

?>
