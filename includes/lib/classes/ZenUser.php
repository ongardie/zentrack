<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * User functions, this does not include access({@link ZenAccess}) or authentication({@link ZenAuthenticate})
 *
 * @package Zen 
 */
class ZenUser extends ZenDataType {
  
  /**
   * CONSTRUCTOR
   *
   * Prepares a ZenUser object for use
   *
   * @param integer $user_id is the id of the user to be loaded (optional)
   * @param ZenUserList $list (optional)loads the user from a ZenUserList rather than database
   */
  function ZenUser( $user_id = null, $list = null ) {
    $this->ZenDataType( $user_id, $list );
  }

  /**
   * Load a ZenUser by their unique login
   *
   * @param string $login the users login name
   * @return boolean login found, record loaded
   */
  function loadFromLogin( $login ) { }

  /**
   * Checks user access for specified bin and action
   * 
   * this is done by using getting a ZenAccess object
   * (on demand) based on a user group and user_id
   * then checking this object for the appropriate access
   *
   * @param integer $bin_id the bin to access
   * @param integer $action_id the action to perform
   * @return boolean has access requested
   */
  function checkAccess( $bin_id, $action_id ) { }

  /**
   * Get roles
   *
   * @return ZenRoleList for this user
   */
  function getRoles() { }

  /* VARIABLES */

  /** @var ZenAccess $_access stores user's access priviledges */
  var $_access;

}

?>
