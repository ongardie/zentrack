<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Contains a set of ZenAccess data.  Requires ZenList.php
 * @package Zen
 */

/** 
 * Stores information for access priviledges based on the user roles, determines which users
 * are allowed to perform a given function in a given bin.
 *
 * Access rights are determined by comparing the role given with the bin_id and action_id to
 * be performed.  The inheritance of access occurs as follows:  
 *
 * If no entry exists for the specific role_id and bin_id in question, access is denied.
 * <br>If an entry exists for the specified role_id, bin_id and action_id, it is used
 * <br>Otherwise, if an entry exists for the role_id and bin_id, with a null for the action_id,
 *   this is defined as the default entry for this bin, and it is used.
 *
 * @package Zen 
 */
class ZenAccessList extends ZenList {

  /**
   * Create an access list based on the role_id in question
   *
   * @param integer $role_id
   */
  function ZenAccessList( $role_id ) {
    // initialize the list
    $this->ZenList();

    // create search parms to match
    // all rows for this role_id
    $parms = new ZenSearchParms();
    $parms->match( 'role_id', ZEN_EQ, $role_id );
    
    // load up the list data    
    $this->criteria($parms);
    $this->load();
  }

  /**
   * Determine if this user role can perform the indicated action for the indicated bin
   *
   * @param integer $bin_id
   * @param integer $action_id if null, checks default priviledges for this bin
   * @return boolean
   */
  function checkAccess($bin_id, $action_id = null) {
    if( !isset($action_id) ) {
      $action_id = 'default';
    }
    $map = $this->getAccessMap();
    
    // if the bin_id isn't defined for this role, deny access
    // otherwise return the specified value
    return isset($map[$bin_id])? $map[$bin_id][$action_id] : false;
  }

  /**
   * Generates a hash map containing the access values for this user (for quick reference), run
   * only on demand
   *
   * @return array mapped (integer)bin_id => array( (integer)access_id => (boolean)yesno )
   */
  function _genAccessMap() {
    if( !isset($this->_accessMap) ) {
      // generate the access map only once
      $this->_accessMap = array();
      foreach($this->list() as $id) {
        // determine the bin, action, and value for each entry
        $x = $this->get($id);
        $b = $x->getField('bin_id');
        $a = $x->getField('action_id');
        $v = ZenUtils::parseBoolean($x->getField('yesorno',false));
        if( !isset($a) ) {
          // null is a default value
          $a = 'default';
        }
        // generate each bin list as needed
        if( !isset($this->_accessMap[$b]) ) { $this->_accessMap[$b] = array(); }
        // populate the bin list with action values
        $this->_accessMap[$b][$a] = $v;
      }
    }
    return $this->_accessMap;
  }

  /** @var array $_accessMap stores access map (populated on demand) */
  var $_accessMap;

}

?>
