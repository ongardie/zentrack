<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * Manages information concerning a database connection. Currently this class wraps the ADODB 
 * library.
 *
 * @package DB
 * @author Mike Lively <mike@digitalsandwich.com>
 * @version 1.0
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
   */
  function ZenDatabase( $dbtype, $dbhost, $dbuser, $dbpass, $dbinst, $persistent = false ) {
    $this->_dbtype = $dbtype;
    $this->_dbhost = $dbhost;
    $this->_dbinst = $dbinst;
    $this->_dbuser = $dbuser;
    $this->_dbpass = $dbpass;
    $this->_persist = $persistent;
    $this->debug( "ZenDatabase", "ZenDatabase", 
                  "Initializing db: [host]".$dbhost.", [inst]".$dbinst
                  .", [user]".$dbuser.", [pass hidden]", 0, 3);
    $this->randomNumber = mt_rand(1,1000)."-".mt_rand(1,1000);
    ZenDatabase::_getDbConnection();
  }
  var $randomNumber;
  
  /**
   * Sets the Cache directory.
   *
   * @access public
   * @since 1.0
   * @param string $directory The directory where cache files will be stored.
   */
  function setCacheDirectory($directory) {
    $GLOBALS['ADODB_CACHE_DIR'] = $directory;
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
   * Returns the preferred case for table names used by this db
   *
   * This should be expanded to use the DbTypeInfo object
   */
  function getPreferredCase() {
    //todo: make this use the DbTypeInfo object
    return "upper";
  }  
  
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
   * @param mixed $cacheTime The amount of time in seconds to cache the query. Set to 0 to override cache(reset). Set to boolean false if you want to ignore caching altogether.
   * @return resource
   */
  function execute( $query, $cacheTime = 0, $limit = 0, $offset = 0 ) {
    $this->debug($this, "execute", "[cachetime:$cacheTime]$query", 0, 3);
    if ($cacheTime === false || !isset($GLOBALS['ADODB_CACHE_DIR'] || !strlen($GLOBALS['ADODB_CACHE_DIR'])) {
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
    if (!$result) {
      $this->debug($this, 'execute', "There was an error in the query ($query): " 
                   . $this->_adodb->ErrorMsg(), 200, 1);
      return false;
    }
    return $result;
  }

  /**
   * Sets whether an associative or numericaly indexed array is returned.
   *
   * @access public
   * @since 1.0
   * @param boolean $indexed whether results are returned in an associative (true) or plain array (false)
   */
  function setFetchMode( $indexed = false ) {
    if ($indexed) {
      $this->_adodb->SetFetchMode(ADODB_FETCH_ASSOC);
    }
    else {
      $this->_adodb->SetFetchMode(ADODB_FETCH_NUM);
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
  function executeGetOne( $query, $cacheTime = 0) {
    $result = $this->_adodb->cacheGetOne($cacheTime, $query);
    if (!$result) {
      $this->debug($this, 'executeGetOne', "There was an error in the query ($query): " 
                   . $this->_adodb->ErrorMsg(), 200, 1);
      return;
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
   * @param array $fieldArray associative array of data (you must quote strings yourself).
   * @param mixed $keyCol the primary key field name or if compound key, array of field names
   * @return int
   */
  function replace($table, $arrFields, $keyCols) {
    $result = $this->_adodb->Replace($table, $arrFields, $keyCols, true);
    if (!$result) {
      $this->debug($this, 'replace', $this->_adodb->ErrorMsg(), 200, 1);
    }
    return $result;
  }

  /**
   * Quotes a string for insertion into db, escaping needed characters. The quoted string is returned.
   *
   * This method wraps the quoting method derived by the adodb library.
   *
   * @access public
   * @since 1.0
   * @param mixed $text the text to quote, arrays converted to ('...','...',etc.)
   * @return string
   */
  function quote( $text ) {    
    $this->debug($this, "quote", "Quoting string: "+$text, 0, 3);
    if (is_array($text)) {
      $quotedText = array();
      foreach ($text as $name => $value) {
        $quotedText[$name] = $this->_adodb->qstr($value);
      }
      return $quotedText;
    }
    else {
      $res = $this->_adodb->qstr($text);
      $this->debug($this, "quote", "Quoted string: "+$res, 0, 3);
      return $res;
    }
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
   * Generates an ID to use in inserting the next record into a specified table. Returns the 
   * generated ID.
   *
   * @access public
   * @since 1.0
   * @param string $table The table to generate the ID for.
   * @return int
   */
  function generateID($table) {
    return $this->_adodb->GenID($table);
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
      $this->debug($this, "connect", $this->_adodb->ErrorMsg(), 202, 1);
      $this->_connected = false;
      return false;
    }
    $this->_connected = true;
    return true;
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
   * @return object ADOConnection
   */
  function _getDbConnection() {
    static $dbConnection;
    if (!isset($dbConnection)) {
      $dbConnection = &ADONewConnection($this->_dbtype);
    }
    $this->_adodb = $dbConnection;
    $this->_connect();
    return ($dbConnection);
  }

  /**
   * Returns the database type in use
   *
   * @return string database type
   */
  function getDbType() { return $this->_dbtype; }


  /* VARIABLES */

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
