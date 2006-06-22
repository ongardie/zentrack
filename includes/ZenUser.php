<?

/**
 * ZenUser manages a single user account from the ZENTRACK_USERS table.
 *
 * It extends the ZenPerson object, which represents a generic person
 * (contact, user, notify recipient, etc)
 *
 * A user can be constructed using an id or it can be constructed without
 * an id and the user information may be loaded manually.
 */
class ZenUser extends ZenPerson {

  /**
   * Load a user by their login
   *
   * @param string $login
   * @return true if login was valid and loaded from db
   */
  function loadByLogin( $login ) {
    $z = $GLOBALS['zen'];
    $parms = new ZenSearchParms();
    $where = $z->simpleWhere( array('login', $z) );
    $query = "SELECT * FROM ZENTRACK_USERS WHERE $where";
    $vals = $z->db_quickIndexed($query);
    if( empty($vals) ) { return false; }
    foreach($vals as $k=>$v) {
      $this->setField($k,$v);
    }
    return true;
  }
  
  /**
   * @abstract
   * @return int database column representing primary key for this object
   */
  function getIdField() { return 'user_id'; }
  
  /**
   * @abstract
   * @return mixed an array of (string)fields or a (string)field name to use for label text
   */
  function getLabelField() { return array('lname','fname'); }
  
  /**
   * Used to determine which table a particular object type comes from.
   * All implementations of the ZenPerson object must declare this method.
   *
   * @abstract
   */
  function getSourceTable() { return 'ZENTRACK_USERS'; }
  
}

/**
 * A list of ZenUser objects.  This list stores the raw data for the users
 * and creates/updates the ZenUser objects on demand, lowering the overhead
 * involved in large lists.
 */
class ZenUserList extends ZenPersonList {
  

  function loadByRole( $role_ids ) { } //todo
  
  function loadByAccess( $bins, $lvl, $types = null ) { } //todo

  function getDataType() { return 'ZenUser'; }

}

?>