<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package Zen */
class ZenAccess extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * Loads a ZenAccess object for use
   *
   * @param Object $group_user_or_list is one of the following:
   *   A ZenUserGroup object, a ZenUserGroupList, a ZenUser object, a ZenUserList, or a ZenAccessList.  This will be the basis for making determinations.
   */
  function ZenAccess( $group_user_or_list ) { 
    // call ZenDataType()

    // create access from group list

    // create access from user list

    // create access from access list

    // creaet access from user

  }

  /**
   * Checks a specific action and bin to see if this group/user qualifies
   *
   * @param integer $bin_id the bin in question
   * @param integer $action_id the action to check
   * @param integer $level the required access level
   * @return boolean is allowed
   */
  function check( $bin_id, $action_id, $level ) { }

  /**
   * Retrieves the access level for the bin and action in question
   *
   * @param integer $bin_id the bin in question
   * @param integer $action_id the action to check
   * @return integer or null if no entry
   */
  function getLevel( $bin_id, $action_id ) { }

  /**
   * Retrieves the access level for the bin and action in question
   *
   * If more than one group has an access priviledge, then the highest
   * ranking priviledge is applied
   *
   * If the user has a priviledge specified, then it overrides all group
   * rankings
   *
   * @param integer $bin_id the bin set
   * @param integer $action_id the action to set
   * @param integer $level the new level
   * @return boolean validated and set
   */
  function setLevel( $bin_id, $action_id, $level ) { }


  /* VARIABLES */

  /** @var array $_permissions the permissions for the user, indexed by bin_id and action_id */
  var $_permissions;

  /** @var array $_groups the permissions for the groups, indexed by group_id, bin_id and action_id */
  var $_groups;

  /** @var integer $_userid the user in question */
  var $_userid;

}

?>
