<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Contains the ZenUser class
 * @package Zen
 */

/**
 * ZFMT_LASTFIRST display format for full name: Last_name, First_name
 */
define('ZFMT_LASTFIRST', 0);

/**
 * ZFMT_FIRSTLAST display format for full name: First_name Last_name
 */
define('ZFMT_FIRSTLAST', 1);

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
   * STATIC: Load a ZenUser by their unique login
   *
   * @param string $login the users login name
   * @return ZenUser or null (if login wasn't found)
   */
  function loadFromLogin( $login ) {
    // create search parms based
    // on the user's login (which is unique)
    $parms = new ZenSearchParms();
    $parms->match('login', ZEN_EQ, $login);

    // load the user into a list
    // using the search parms
    $list = new ZenList();
    $list->load_abstract('ZenUser');
    $list->criteria($parms);
    $list->load();

    // return the ZenUser object (there
    // will only be zero or one items in
    // this list, since the login is
    // unique)
    return $list->next();
  }

  /**
   * Checks user access for specified bin and action
   * 
   * The user is considered to have access to the specified
   * bin and action if any of the user's roles are
   * allowed to access that action.
   *
   * @param integer $bin_id the bin to access
   * @param integer $action_id the action to perform
   * @return boolean has access requested
   */
  function checkAccess( $bin_id, $action_id ) { 
    $roles = $this->getRoles();
    $roles->reset();
    while( $roles->hasNext() ) {
      $role = $roles->next();
      if( $role->checkAccess($bin_id, $action_id) ) {
        // if any of the user's roles are allowed
        // to access the requested priviledge, then
        // the result is true
        return true;
      }
    }
    // none of the user's roles can access this priviledge
    return false;
  }

  /**
   * Get roles
   *
   * @return ZenRoleList for this user
   */
  function getRoles() { 
    if( !isset($this->_roles) ) {
      // query the user_roles table to determine
      // which roles this user has
      $query = Zen::getNewQuery();
      $query->table('USER_ROLES');
      $query->match('user_id', $this->id());
      $query->field('role_id');
      $ids = $query->list(Zen::getCacheTime(), false);
      
      // create a role list using the ids we queried
      $this->_roles = new ZenList();
      $this->_roles->loadAbstract('ZenUser');
      $this->_roles->criteriaIdArray($ids);
      $this->_roles->load();
    }
    return $this->_roles;
  }

  /**
   * Return the full name of the user, formatted for display
   *
   * The possible formatting options are:
   * <ul>
   *   <li>ZFMT_LASTFIRST - Last_name, First_name (default)
   *   <li>ZFMT_FIRSTLAST - First_name Last_name
   * </ul>
   *
   * @param integer string $format defaults to "Last, First", see above for details 
   */
  function getFullName( $format = null ) {
    switch($format) {
    case ZFMT_FIRSTLAST:
      return $this->getField('fname')." ".$this->getField('lname');      
    default:
      return $this->getField('lname').", ".$this->getField('fname');
    }
  }
  
  /* VARIABLES */

  /** @var ZenAccess $_access stores user's access priviledges */
  var $_access;

  /** @var ZenRoleList $_roles stores the user's roles (loaded on demand) */
  var $_roles;
}

?>
