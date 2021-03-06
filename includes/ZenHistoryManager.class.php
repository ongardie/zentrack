<?
if( !ZT_DEFINED ) { die("Illegal Access"); }


/**
 * Manages history of visited items in ZT
 */
class ZenHistoryManager {
  
  /** 
   * Construct a history manager
   *
   * @param zenTrack $zen
   */
  function ZenHistoryManager(&$zen) {
    $this->_session =& $zen->getSessionManager();
    $this->_max = $zen->getSetting('recently_viewed_max');
    $this->_zen =& $zen;
    $this->_user = $_SESSION['login_id'];
  }
  
  /**
   * Store an item in the history manager
   * @param String $type
   * @param int $id
   * @param String $label
   */
  function storeItem( $type, $id, $label ) {
    $list = $this->getList($type);
    
    // see if our item appears in the array
    $loc = -1;
    $count = 0;
    foreach($list as $k=>$v) {
      if( $k == $id ) { 
        $loc = $count;
        break;
      } 
      $count++;
    }
    
    // if this item is already first in the list
    // there is nothing left to do
    if( $loc == 0 ) {
      $this->_zen->addDebug("ZenHistoryManager->storeItem", "Item already appears first in $type history: $id - $label", 3);
      return; 
    }

    $this->_zen->addDebug("ZenHistoryManager->storeItem", "Adding item to $type history: $id - $label", 3);
    
    // place item in beginning of list
    $newlist = array("$id"=>$label);
    
    // add items from original list until it is full
    $count = 1;
    foreach($list as $k=>$v) {
      // remove item if it already appears in list (it will be at the top now)
      if( $k == $id ) { continue; }
      // limit the size of our list
      if( ++$count > $this->_max ) { break; }
      // place old items into the history
      $newlist["$k"] = $v;
    }
    $list = $newlist;
    
    // store new list
    $this->_session->store("history_$type", $list);
    $this->_zen->update_pref( $this->_user, "history_$type", join(",",array_keys($list)) );
  }
   
  /**
   * Retrieve a list of items from the history manager
   *
   * @param String $type
   * @return Array associative array of (int)id => (String)label
   */
  function getList( $type ) {
    // check the session
    $list = $this->_session->find("history_$type");
    if( empty($list) ) {
      // try to get our list from user prefs
      $pref = $this->_zen->get_prefs($this->_user, "history_$type");
      if( $pref ) {
        // build key/value set from the string of ids
		  $t = $type=="project"? "table_tickets" : "table_{$type}";
        $list = $this->_zen->listTitles($this->_zen->$t, explode(",",$pref));
        $this->_session->store("history_$type", $list);
      }
      else {
        $list = array();
      }
    }
    return $list;
  }
   
  var $_zen;
  var $_max;
  var $_session;
  var $_user;

}

?>