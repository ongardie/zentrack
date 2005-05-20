<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenDatabase class.  Requires Zen.php, ZenQuery.php, and the adodb.inc.php libs
 * @package DB
 */

/** 
 * Manages information concerning a database connection. Currently this class wraps the ADODB 
 * library.
 *
 * @package DB
 * @author Mike Lively <mike@digitalsandwich.com>
 */
class ZenDatabase extends Zen {

  /**
   * Creates a new ZenDatabase object.
   *
   * Sets up adodb, and database params. Also connects to the database
   *
   * @access public
   * @since 1.0
   * @param string $dbtype database type
   * @param string $dbhost database host (might be blank or localhost)
   * @param string $dbuser database username
   * @param string $dbpass database password
   * @param string $dbinst database instance to connect to
   * @param boolean $connect if false, no connection is made
   */
  function ZenDatabase( $dbtype, $dbhost, $dbuser, $dbpass, 
                        $dbinst, $persistent = false, $connect = true ) {
    $this->Zen();
    ZenUtils::mark("ZenDatabase[".$this->randomNumber."] init/connect");
    ZenUtils::prep("ZenDbTypeInfo");
    $this->_dbtype = $dbtype;
    $this->_dbhost = $dbhost;
    $this->_dbinst = $dbinst;
    $this->_dbuser = $dbuser;
    $this->_dbpass = $dbpass;
    $this->_persist = $persistent;
    ZenUtils::safeDebug("ZenDatabase", "ZenDatabase", 
                        "$dbtype({$this->randomNumber}):"
                        ." $dbuser@$dbhost:$dbinst"
                        ." [persist:".($persistent?"true":"false")."]"
                        .(strlen($dbpass)? '':'(no password)'), 
                        0, LVL_NOTE);
    ZenDatabase::_getDbConnection($connect);
    ZenUtils::unmark("ZenDatabase[".$this->randomNumber."] init/connect");
  }

  /**
   * Sets the Cache directory.
   *
   * @access public
   * @since 1.0
   * @param string $directory The directory where cache files will be stored.
   */
  function setCacheDirectory($directory) {
    if( @is_dir($directory) && @is_writable($directory) ) {
      $GLOBALS['ADODB_CACHE_DIR'] = $directory;
      return true;
    }
    else {
      $this->_genDebug("setCacheDirectory", 
                       "$directory is not writable", 
                       40, LVL_ERROR);
      return false;
    }
  }

  /**
   * Sets the prefix used to create table names
   *
   * @param string $pre is the prefix placed in front of all table names
   */
  function setPrefix( $pre ) {
    $this->_prefix = $pre;
  }

  /**
   * Returns the value of the table name prefix
   *
   * @return string
   */
  function getPrefix() { return $this->_prefix; }

  /**
   * Create a correct table name, adding prefix and setting correct case
   *
   * @param string $name is the name of the table
   * @param string $field if provided, it is the name of a field and will be appended as such: table_name.field_name
   */
  function makeTableName( $tableName, $field = null ) {
    $prefix = $this->getPrefix();
    $case = $this->getPreferredCase();    
    if( $case == "upper" )
      return strtoupper($prefix.$tableName).($field? ".$field" : "");
    else if( $case == "lower" )
      return strtolower($prefix.$tableName).($field? ".$field" : "");
    else
      return $prefix.$tableName.($field? ".$field" : "");
  }

  /**
   * Returns the preferred case for table names used by this db
   *
   * This should be expanded to use the ZenDbTypeInfo object
   */
  function getPreferredCase() {
    $dbi = $this->getDbTypeInfo();
    return $dbi->getDbInfo('preferredCase');
  }  

  /**
   * Returns the ZenDbTypeInfo associated with this database
   * @return ZenDbTypeInfo
   */
  function getDbTypeInfo() {
    if( !$this->_dbTypeInfo ) {
      $this->_dbTypeInfo = new ZenDbTypeInfo( $this );
    }
    return $this->_dbTypeInfo;
  }

  var $_dbTypeInfo;
  
  /**
   * Returns a new query object that the user can manipulate and execute. 
   *
   * This function automatically binds the current database to the query.
   *
   * @access public
   * @since 1.0
   * @return ZenQuery
   */
  function newQuery() {
    $query = new ZenQuery($this);
    return $query;
  }

  /**
   * Executes a query.
   *
   * Returns the query result.
   *
   * @access public
   * @since 1.0
   * @param string $query the query object to be executed
   * @param mixed $cacheTime The amount of time in seconds to cache the query. Set to 0 to override cache(reset). 
   *              Set to boolean false if you want to ignore caching altogether.
   * @return resource (possibly false)
   */
  function execute( $query, $cacheTime = null, $limit = 0, $offset = 0 ) {
    $this->_errmsg = null;
    $this->_errnum = null;
    $this->_genDebug( "execute", "[cachetime:$cacheTime]$query", 
                        0, LVL_NOTE);
    if (!strlen($cacheTime) || !isset($GLOBALS['ADODB_CACHE_DIR']) 
        || !strlen($GLOBALS['ADODB_CACHE_DIR'])) {
      if( $limit )
        $result = &$this->_adodb->SelectLimit($query, $limit, $offset);
      else
        $result = &$this->_adodb->Execute($query);
    }
    else {
      if( $limit )
        $result = &$this->_adodb->CacheSelectLimit($cacheTime, $query, $limit, $offset);
      else
        $result = &$this->_adodb->cacheExecute($cacheTime, $query);
    }
    if ($result === false && $this->_adodb->errorMsg()) {
      // we aren't worried about deleting things which don't exist, so
      // suppress some of the messages about this
      $l = preg_match('/^(DROP|DELETE)/i', $query)? LVL_NOTE : LVL_WARN;
      $this->_genDbError( 'execute', "SQL Error", 220, $l );
    }
    return $result;
  }

  /**
   * Sets whether an associative or numericaly indexed array is returned.
   *
   * @access public
   * @since 1.0
   * @param boolean $indexed whether results are returned in an associative (true) or plain array (false)
   * @return the old value of fetchMode
   */
  function setFetchMode( $indexed = false ) {
    $this->_genDebug( "setFetchMode", "Fetch mode is ".($indexed? 'true':'false'), 0, LVL_DEBUG);
    if ($indexed) {
      return $this->_adodb->SetFetchMode(ADODB_FETCH_ASSOC);
    }
    else {
      return $this->_adodb->SetFetchMode(ADODB_FETCH_NUM);
    }
  }

  /**
   * Executes a query and returns a the first column from the first row.
   *
   * @access public
   * @since 1.0
   * @param string $query the query object to be executed
   * @param int $cacheTime The amount of time in seconds to cache the query. Set to 0 to clear cache(reset).
   * @return string
   */
  function executeGetOne( $query, $cacheTime = null) {
    $this->_genDebug( "executeGetOne", "[cachetime:$cacheTime]$query", 
                        0, LVL_NOTE);
    if (!strlen($cacheTime) || !isset($GLOBALS['ADODB_CACHE_DIR']) 
        || !strlen($GLOBALS['ADODB_CACHE_DIR'])) {
      $result = $this->_adodb->getOne($query);
    }
    else {
      $result = $this->_adodb->cacheGetOne($cacheTime, $query);
    }
    if ($result === false && $this->_adodb->errorMsg() ) {
      $this->_genDbError('executeGetOne', "SQL Error", 200, LVL_ERROR);
    }
    return $result;
  }

  /**
   * Insert or replace a single record. 
   *
   * Returns an integer. This value is set to 0 when the query fails, 1 when an update is performed, 
   * and 2 when an insert is performed.
   *
   * @access public
   * @since 1.0
   * @param string $table table name
   * @param array $fieldArray associative array of data (you must quote strings yourself)
   * @param mixed $keyCol the primary key field name or if compound key, array of field names
   * @return int
   */
  function replace($table, $arrFields, $keyCols) {
    $result = $this->_adodb->Replace($table, $arrFields, $keyCols, true);
    if (!$result) {
      $this->_genDbError('replace', "SQL Error", 220, LVL_ERROR);
    }
    return $result;
  }

  /**
   * Quotes a string for insertion into db, escaping needed characters. The quoted string is returned.
   *
   * This method wraps the quoting method derived by the adodb library.  Note that ZenQuery should
   * quote strings automatigically, and it should not be necessary to call this manually.
   *
   * @access public
   * @since 1.0
   * @param mixed $text the text to quote, arrays converted to ('...','...',etc.)
   * @param string $type is the field type, important for proper quoting
   * @return string
   */
  function quote( $text, $type = '' ) {
    
    if( !$type ) {
      // attempt to guess the type
      if( preg_match('/^[0-9]+$/', $text) ) {
        $type == 'integer';
      }
    }
    
    switch( strtolower($type) ) {
    case "integer":
    case "shortint":
    case "byte":
    case "long":
    case "primarykey":
      $text = preg_replace('/[^0-9-]/', '', $text);
      if( !strlen($text) ) {
        $text = 0;
      }
      break;
    case "date":
      if( $text == 'NOW' || $text == 'CURRENT_TIMESTAMP' || $text == 'NOW()' ) {
        $text = time();
      }
      $text = preg_replace('/[^0-9-]/', '', $text);
      if( !strlen($text) ) {
        $text = 0;
      }
      break;
    default:
      {
        if (is_array($text)) {
          $quotedText = array();
          $t = "";
          foreach ($text as $name => $value) {
            $quotedText[$name] = $this->_adodb->quote($value);
            $t .= "[$name]".$quotedText[$name];
          }
          return $quotedText;
        }
        else {
          $text = $this->_adodb->quote($text);
        }
      }
    }
    $this->_genDebug( "quote", "Quoted text: {$text}", 0, LVL_DEBUG);
    return $text;
  }

  /**
   * Flush the database cache.  To do this correctly, you should call
   * {@link ZenMetaDb::clearCacheInfo()} rather than this method.
   */
  function flushCache() {
    return $this->_adodb->cacheFlush();
  }

  /**
   * Returns the number of affected rows
   *
   * @access public
   * @since 1.0
   * @return int
   */
  function affectedRows() {
    return $this->_adodb->Affected_Rows();
  }

  /**
   * Returns any error message recieved by last query
   *
   * @return string
   */
  function getErrorMessage() {
    if( !$this->_errmsg ) { return null; }
    return '['.$this->_errnum.']'.$this->_errmsg;
  }

  /**
   * Generates an ID to use in inserting the next record into a specified table. Returns the 
   * generated ID.
   *
   * @access public
   * @since 1.0
   * @param string $table The table to generate the ID for.
   * @return int
   */
  function generateID($table) {
    //todo
    //todo make an alternate way to deal with this if transactions are not enabled
    //todo add an option to enable/disable transactions
    //todo extract transaction code 
    //todo
    // generate the update query (which will create a unique id) and the sql query 
    // (which will retrieve the id)
    $update = "UPDATE ".$this->makeTableName('table_ids')
      ." SET current_id = current_id + 1 where name_of_table = '$table'";
    $query = "SELECT current_id FROM ".$this->makeTableName('table_ids')." where name_of_table = '$table'";
    $this->setFetchMode(false);
    // do this in a transaction to insure a unique value
    // note that the update must come first to guarantee proper transaction locking in oracle
    $this->_adodb->StartTrans();
    $this->_adodb->Execute($update);
    $id = $this->_adodb->GetOne($query);
    // show error if we didn't get one
    if( !$this->_adodb->CompleteTrans() ) {
      $this->_genDbError("generateID", 
                         "Failed to generate ID for table $table ({$update}::{$query})", 
                         220, LVL_ERROR);
    }
    else {
      $this->_genDebug( "generateID", "Generated id $id for $table", 0, LVL_NOTE);
    }
    // return the result if we got one
    if( $id ) { return $id; }
    else { return null; }
  }
  
  /**
   * STATIC: Generate the primary key for a table from the table name
   * (do not pass table with database prefix before name)
   *
   * @param string $table
   * @return string
   */
  function getPrimaryKey( $table ) {
    return strtolower($table."_id");
  }

  /* UTILITIES */

  /**
   * Connects to a database.
   *
   * Returns true if the connection was successful, false otherwise.
   *
   * @access private
   * @since 1.0
   * @return boolean
   */
  function _connect() {
    if( $this->_persist ) {
      $bool = $this->_adodb->PConnect($this->_dbhost, $this->_dbuser, $this->_dbpass, $this->_dbinst);
    }
    else {
      $bool = $this->_adodb->Connect($this->_dbhost, $this->_dbuser, $this->_dbpass, $this->_dbinst);
    }
    if ( !$bool ) {
      $this->_genDbError("connect", "Connection error", 202, LVL_ERROR);
      $this->_connected = false;
      return false;
    }
    $this->_connected = true;
    return true;
  }

  /**
   * Manually connect (only necessary if did not connect in the constructor)
   */
  function connect() {
    if( !$this->isConnected() ) { $this->_connect(); }
  }

  /**
   * Reports whether connected to a database or not
   * @return boolean connection is open
   */
  function isConnected() { return $this->_connected; }

  /**
   * Returns a db connection / database object
   *
   * THIS SHOULD BE STATIC, only one db connection is necessary. The only way
   * this function should be called is as follows:
   * Zen::getDbConnection();
   *
   * @access private
   * @since 1.0
   * @param boolean $connect if false, the adodb object is returned, but not connected
   * @return object ADOConnection
   */
  function _getDbConnection( $connect = true ) {
    static $dbConnection;
    if (!isset($dbConnection)) {
      $dbConnection = &ADONewConnection($this->_dbtype);
    }
    $this->_adodb = $dbConnection;
    if( $connect ) {
      $this->_connect();
    }
    return ($dbConnection);
  }

  /**
   * Returns the database type in use
   *
   * @return string database type
   */
  function getDbType() { return $this->_dbtype; }

  /**
   * Generates a debug message and stores error
   *
   * @access private
   * @return true if debug message was stored
   * @param string $method the method which produced the error
   * @param string $message the message to print [optional]
   * @param int $errnum the error number
   * @param int $level the error level
   */
  function _genDbError( $method, $message = 'Database error', $errnum = 200, $level = 1 ) {
    $this->_errmsg = $this->_adodb->ErrorMsg();
    $this->_errnum = $this->_adodb->ErrorNo();
    if( $this->_errmsg || $this->_errnum ) 
      { $message = $message." [{$this->_errnum}]{$this->_errmsg}"; }
    return $this->_genDebug( $method, $message, $errnum, $level);   
  }

  /**
   * Generates a debug message without an error
   *
   * @access private
   * @return true if debug message was stored
   * @param string $method the method which produced the error
   * @param string $message the message to print [optional]
   * @param int $errnum the error number
   * @param int $level the error level
   */
  function _genDebug( $method, $message, $errnum = 0, $level = 3 ) {
    return ZenUtils::safeDebug( $this, $method, $message, $errnum, $level);      
  }


  /* VARIABLES */

  /**
   * @var integer Stores the database error number
   * @access private
   */
  var $_errno;

  /**
   * @var string Stores the database error messgae
   * @access private
   */
  var $_errmsg;

  /**
   * The type of database to use.
   *
   * @var string
   * @access private
   * @since 1.0
   */
  var $_dbtype;

  /**
   * The hostname of the database to use.
   *
   * @var string
   * @access private
   * @since 1.0
   */
  var $_dbhost;

  /**
   * The name of the database to use.
   *
   * @var string
   * @access private
   * @since 1.0
   */
  var $_dbinst;

  /**
   * The username to use in authenticating with the database.
   *
   * @var string
   * @access private
   * @since 1.0
   */
  var $_dbuser;

  /**
   * The password to use in authenticating with the database.
   *
   * @var string
   * @access private
   * @since 1.0
   */
  var $_dbpass;

  /**
   * The ADODB object that is managing the database.
   *
   * @var object ADOConnection
   * @access private
   * @since 1.0
   */
  var $_adodb;

  /**
   * Whether to use persistent connections or not
   *
   * @var boolean
   * @access private
   * @since 1.0
   */
  var $_persist;

  /** 
   * The prefix in front of table names 
   * @var string 
   * @access private
   * @since 1.3 
   */
  var $_prefix = "";

  /**
   * Tells whether we are connected
   * @var string
   * @access private
   */
  var $_connected = false;

}

?>
