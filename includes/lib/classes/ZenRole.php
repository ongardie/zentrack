<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenRole class.  Requires ZenDataType.php
 * @package Zen
 */

/** 
 * A role represents a system user's function.  This controls the user's access priveledges for each bin,
 * as well as some user related features such as notifications and actions.
 * 
 * @package Zen 
 */
class ZenRole extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * Loads a ZenRole object for use
   *
   * @param integer $role_id is the id of the role (optional)
   * @param ZenRoleList $list (optional)loads the role from a ZenRoleList rather than database
   */
  function ZenRole( $role_id = null, $list = null ) { }

}

?>
