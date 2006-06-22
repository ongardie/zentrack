<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * Manage user roles and permissions for the system
 */
class ZenRole extends ZenDataType {

  /**
   * @static
   * @return int database column representing primary key for this object
   */
  function getIdField() { return 'role_id'; }
  
  /**
   * @static
   * @return mixed an array of (string)fields or a (string)field name to use for label text
   */
  function getLabelField() { return 'role_name'; }

  /**
   * Used to determine which table a particular object type comes from.
   * All implementations of the ZenPerson object must declare this method.
   *
   * @static
   */
  function getSourceTable() { return 'ZENTRACK_ROLE'; }
  
  /**
   * Determine if a given role permits a user to perform a given task
   *
   * @param ZenAction $action
   * @param int $bin_id the bin where the action will be performed
   * @param int $type_id the type of ticket the action will be performed on
   * @return boolean true if action is allowed
   */
  function checkAccess( &$action, $bin_id, $type_id ) { } //todo
}

class ZenRoleList {
  
  function ZenRoleList( $ids = null ) { }//todo
  
  /**
   * Load all roles meeting the access requirements specified
   *
   * @param mixed $bins array of (int)bin_ids or an (int)bin_id
   * @param int $lvl access level required (see constants at top of this file)
   * @param mixed $types array of (int)type_ids or an (int)type_id
   * @return int number of entries loaded
   */
  function loadByAccess( $bins, $lvl, $types = null ) { } //todo
  
  /**
   * Determine if any role in the list allows the user to perform
   * the requested action.
   */
  function checkAccess( $action, $bin_id, $type_id ) { } //todo
  
  function getDataType() { return 'ZenRole'; }
  
}
?>
