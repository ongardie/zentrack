<?
if( !ZT_DEFINED ) { die("Illegal Access"); }


/**
 * Manages session information for ZT
 */
 class ZenSessionManager {
   
   /** 
    * Construct a session manager 
    *
    * @param zenTrack $zen
    */
   function ZenSessionManager() { }
   
   /**
    * Returns general cached information.  This is stored in the session and
    * will survive page loads.
    *
    * This general cache is intended to be used for any values other than associative arrays, 
    * or associative arrays that will only be stored/retrieved (the elements 
    * inside the array are not going to be modified or accessed individually).
    * 
    * This cache is only intended to be used for values which are repeatedly used
    * throughout the system and would be more expensive to look up from the database
    * each page load than to keep in memory.  USE SPARINGLY!
    *
    * For temporary storage of info, use the {@link ZenSessionManager::getDataCache()}
    * and {@link ZenSessionManager::storeDataCache()} methods instead.
    */
    function find( $key ) {
      if( isset($_SESSION) ) {
        if( isset($_SESSION['ztMiscCache']) && array_key_exists("$key", $_SESSION['ztMiscCache']) ) {
          return $_SESSION['ztMiscCache']["$key"];
        }
      }
      return null;
    }
   
   /**
    * Stores general cached information.  This is stored in the session and
    * will survive page loads.
    *
    * This general cache is intended to be used for any values other than associative arrays, 
    * or associative arrays that will only be stored/retrieved (the elements 
    * inside the array are not going to be modified or accessed individually).
    * 
    * This cache is only intended to be used for values which are repeatedly used
    * throughout the system and would be more expensive to look up from the database
    * each page load than to keep in memory.  USE SPARINGLY!
    *
    * For temporary storage of info, use the {@link ZenSessionManager::getDataCache()}
    * and {@link ZenSessionManager::storeDataCache()} methods instead.
    *
    * @param string $key the index used to store values (if key exists it is replaced)
    * @param mixed $value any valid session data
    */
    function store( $key, $value ) {
      if( isset($_SESSION) ) {
        if( !isset($_SESSION['ztMiscCache']) ) {
          $_SESSION['ztMiscCache'] = array();
        }
        $_SESSION['ztMiscCache']["$key"] = $value;
      }
    }
    
   /**
    * Clears information from the general cache.
    *
    * @param string $key if not provided, clears entire cache
    */
    function clear( $key = null ) {
      if( isset($_SESSION) ) {
        if( isset($_SESSION['ztMiscCache']) ) {
          if( $key ) {
            unset($_SESSION['ztMiscCache']["$key"]);
          }
          else {
            $_SESSION['ztMiscCache'] = array();
          }
        }
      }
    }
   
   /**
    * Stores data type info in the cache.  This cache is stored in the session
    * and will survive page loads.
    *
    * This is only intended to be used for data types.  Those are:  Bin, system,
    * priority, status, type, etc.
    *
    * @param string $type
    * @param mixed $vals
    */
   function storeDataType( $type, $vals ) {
    if( isset($_SESSION) ) {
      // store results in session for later use
      if( !isset($_SESSION['ztDataTypes']) ) { $_SESSION['ztDataTypes'] = array(); }
      Zen::addDebug("ZenSessionManager::storeDataType", "$type: stored", 3, false);
      $_SESSION['ztDataTypes'][$type] = $vals;
      return true;
    }    
    return false;
  }
  
  /**
    * Retrieves data type info from the cache.  This cache is stored in the session
    * and will survive page loads.
    *
    * This is only intended to be used for data types.  Those are:  Bin, system,
    * priority, status, type, etc.
    *
   * @param string $type
   * @return mixed array containing data type vals or false if not found
   */
  function getDataType( $type ) {
    if( isset($_SESSION) && isset($_SESSION['ztDataTypes']) ) {
      // check session before bothering with the lookup
      if( isset($_SESSION['ztDataTypes'][$type]) ) {
        Zen::addDebug("ZenSessionManager::getDataType","$type: retrieved "
          .count($_SESSION['ztDataTypes'][$type])." from session",4);
        return $_SESSION['ztDataTypes'][$type];
      }
    }
    return false;
  }
  
  /**
   * Removes a data type from the cache
   *
   * @param string $type
   */
  function clearDataType( $type ) {
    if( isset($_SESSION) ) {
      if( isset($_SESSION['ztDataTypes']) ) {
        Zen::addDebug("ZenSessionManager::clearDataType", "$type: cleared",3);
        unset($_SESSION['ztDataTypes'][$type]);
      }
    }
  }
  
  /**
   * Retrieves a value or set of values from the temporary cache.  This cache is
   * NOT STORED in the session and will not survive page loads.
   *
   * The data may be an array or a value.  Items in arrays can be retrieved by
   * providing the id/key as an optional parameter.
   *
   * This is intended to be used for any temporary data which we want to store
   * only for the life of the page and IS PREFERRED to storing the information
   * in the session, with the exception of data which is repeatedly used in a
   * global context (every screen).
   *
   * @param string $type
   * @param int $id
   * @return mixed the value stored or the value at $id inside the stored array if provided
   */
  function getDataCache( $type, $id = null ) {
    if( isset($GLOBALS) && isset($GLOBALS['ztDataCache']) && isset($GLOBALS['ztDataCache'][$type]) ) {
      if( isset($id) ) {
        Zen::addDebug("ZenSessionManager::getDataCache", "$type-$id: retrieved", 4);
        return isset($GLOBALS['ztDataCache'][$type])
          && isset($GLOBALS['ztDataCache'][$type]["$id"])? $GLOBALS['ztDataCache'][$type]["$id"] : false;
      }
      Zen::addDebug("ZenSessionManager::getDataCache", "$type: retrieved", 4);
      return $GLOBALS['ztDataCache'][$type];
    }
    return false;
  }
  
  /**
   * Place a value or set of values into the temporary cache.  If the value
   * exists it will be overwritten.  This cache is NOT STORED in the session 
   * and will not survive page loads.
   *
   * The data may be an array or a value.  Items may be placed into arrays within
   * the cache by providing the optional $id param to specify the id/key location
   * where we will be modifying the cache.
   *
   * Note that the array need not be constructed before setting a value using
   * $id, since the array will be created on demand.
   *
   * This is intended to be used for any temporary data which we want to store
   * only for the life of the page and IS PREFERRED to storing the information
   * in the session, with the exception of data which is repeatedly used in a
   * global context (every screen).
   *
   * @param string $type
   * @param int $id
   * @param array $vals
   */
  function storeDataCache( $type, $id, $vals ) {
    if( isset($GLOBALS) ) {
      if( !isset($GLOBALS['ztDataCache']) ) { $GLOBALS['ztDataCache'] = array(); }
      if( !isset($GLOBALS['ztDataCache'][$type]) ) { $GLOBALS['ztDataCache'][$type] = array(); }
      if( count($GLOBALS['ztDataCache'][$type]) > $this->_session_cache_limit ) {
        // for performance, we drop several elements rather than just popping the
        // last one... this way we don't have to run this with every operation
        // once the cap is reached
        array_splice($GLOBALS['ztDataCache'][$type], 0, 40);
      }
      Zen::addDebug("ZenSessionManager::storeDataCache", "Storing cache for {$type}->{$id}",3);
      $GLOBALS['ztDataCache'][$type]["$id"] = $vals; 
    }
  }
  
  /**
   * Removes an item from the data cache.  If $id is provided, it removes an
   * element within an array instead of the entire cached element.
   *
   * @param string $type
   * @param int $id
   */
  function clearDataCache( $type, $id = null ) {
    if( isset($GLOBALS) && isset($GLOBALS['ztDataCache']) ) {
      if( $id ) {
        Zen::addDebug("ZenSessionManager::clearDataCache", "Clearing cache for {$type}->{$id}",3);
        unset($GLOBALS['ztDataCache'][$type]["$id"]);
      }
      else {
        Zen::addDebug("ZenSessionManager::clearDataCache", "Clearing cache for {$type}",3);
        unset($GLOBALS['ztDataCache'][$type]);
      }
    }
  }
  
  /** Stores variable field info in the session for the life of the browser */
  function storeCustomFields( $vals ) {
    if( isset($_SESSION) ) {
      Zen::addDebug("ZenSessionManager::storeCustomFields", "Storing ".count($vals)." vals", 3);
      $_SESSION['ztVarfields'] = $vals;
      return true;
    }
    return false;
  }
  
  /** Retrieves variable field info from the session */
  function getCustomFields() {
    if( isset($_SESSION) ) {
      if( isset($_SESSION['ztVarfields']) ) {
        Zen::addDebug("ZenSessionManager::getCustomFields", "Retrieving ".count($_SESSION['ztVarfields'])." vals", 4);
        return $_SESSION['ztVarfields']; 
      }
    }
    return false;
  }
  
  
  /** Clears variable field info out of the session */
  function clearCustomFields() {
    if( isset($_SESSION) ) {
      Zen::addDebug("ZenSessionManager::clearCustomFields", "Clearing cache", 3);
      unset($_SESSION['ztVarfields']);
    }
  }
  
  /** Clears all session information which has been cached */
  function clearAll() {
    $_SESSION = array();
    //$GLOBALS = array();
  }
  
  /**
   * Returns a value from the session array if it exists and the key exists
   * otherwise it returns null
   *
   * @static
   * @param string $key the index of value to retrieve
   * @return mixed value or null
   */
   function getSession($key) {
     if( isset($_SESSION) && array_key_exists($key, $_SESSION) ) {
       return $_SESSION[$key];
     }
     return null;
   }
   
     /**
   * Returns a value from the global array if it exists and the key exists
   * otherwise it returns null
   *
   * @static
   * @param string $key the index of value to retrieve
   * @return mixed value or null
   */
   function getGlobal($key) {
     if( isset($GLOBALS) && array_key_exists($key, $GLOBALS) ) {
       return $GLOBALS[$key];
     }
     return null;
   }
  
  /** @var zenTrack $_zen */
  var $_zen;
  
  /** @var int $_session_cache_limit maximum number of elements to store in the temporary data cache arrays */
  var $_session_cache_limit = 50;

 }

?>