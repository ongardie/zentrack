<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package Zen */
class Zen {

  /**
   * CONSTRUCTOR: constructs common vars and objects
   * 
   * This method relies on the global array: $_SESSION['zen']
   * which is created in header.php in the www/ directory.
   *
   * Note that, for the sake of installation utils, many methods also 
   * look for $GLOBALS['zen'] if $_SESSION is not set.
   *
   * This method should be invoked by all child constructors
   * This should set up the following vars, pulled from the
   * zen.ini file:
   * <ul>
   *    <li>libDir: the includes directory
   *    <li>templateDir: the templates directory
   *    <li>logDir: the log directory
   *    <li>cacheDir: the directory for db cacheing
   *    <li>Db_Type
   *    <li>Db_Login
   *    <li>Db_Pass
   *    <li>Db_Host
   *    <li>Db_Instance
   * </ul>
   */
  function Zen() { $this->randomNumber = mt_rand(1,10000)."-".mt_rand(1,10000); }

  /** Used for debugging (to check references) */
  var $randomNumber;
  
  /**********************************
   * STATIC METHODS (prevent multiple objects when possible, rely on static page array $loaded_data) 
   *
   * These static methods should be written in a manner that will allow them to be called via
   * the approach Zen::getSetting($cat,$name) ... etc
   *********************************/

  /**
   * STATIC: returns a system setting from database
   *
   * @param string $cat is the category for the setting (tickets, 
   * @param string $name of the setting
   * @return string value of the setting or null if it isn't found
   */
  function getSetting($cat, $name) { 
    $cat = Zen::loadSettings($cat);
    return isset($cat[$name])? $cat[$name] : null;
  }

  /**
   * STATIC: loads system settings into memory
   *
   * This method should employ a static list from the GLOBAL settings to avoid
   * redundant calls to this
   *
   * @param string $cat is the category
   */
  function loadSettings( $cat ) { 
    // in the case that we are running cli, the $_SESSION will
    // not be available, so we will use the $GLOBALS instead
    // here we put 'common' settings into the session to prevent
    // the need to calculate these on every page load
    if( $cat == "common" && isset($_SESSION) ) {
      // create settings if needed
      if( !isset($_SESSION['cache']['common_settings']) ) {
        $query = Zen::getNewQuery();
        $query->table("SETTING");
        $query->match("set_category", ZEN_EQ, "common");
        $vars = $query->select(0, true);
        $_SESSION['cache']['common_settings'] = ZenUtils::keySet($vars, "set_name", "set_value");
      }
      // return cached values
      return $_SESSION['cache']['common_settings'];
    }
    else {
      // all other categories of settings are only stored for the life of the page
      // since we will assume they are not used as commonly
      // create vals if needed
      if( !isset($GLOBALS['tcache']['settings'][$cat]) ) {
        $GLOBALS['tcache']['settings'][$cat] = ZenUtils::keySet(
                                                                Zen::simpleQuery("SETTING", "set_category", $cat),
                                                                "set_name",
                                                                "set_value" );
      }
      // return cached vals
      return ($GLOBALS['tcache']['settings'][$cat]);
    }

  }

  /**
   * STATIC: returns a db connection / database object
   *
   * This method uses the $_SESSION['zen'] or $GLOBALS['zen'] variable(in that order)
   * which should contain the zen.ini directives
   *
   * @return object databaseObject
   */
  function &getDbConnection() {
    if( !isset($GLOBALS['dbConnection']) || $GLOBALS['dbConnection'] == null ) {
      ZenUtils::safeDebug("Zen", "getDbConnection", "Creating database connection (cache empty)", 0, LVL_NOTE);
      $db = ZenUtils::getIni('db');
      $dir_cache = ZenUtils::getIni('directories','dir_dbcache');
      $prefix = ZenUtils::getIni('db','db_prefix');
      $GLOBALS['dbConnection'] = new ZenDatabase($db['db_type'], 
                                                  $db['db_host'],
                                                  $db['db_user'],
                                                  $db['db_pass'],
                                                  $db['db_instance'],
                                                  $db['db_persistent']);
      $GLOBALS['dbConnection']->setCacheDirectory( $dir_cache );
      $GLOBALS['dbConnection']->setPrefix( $prefix );
    }
    return $GLOBALS['dbConnection'];
  }

  function &getMessageList() {
    return ZenMessageList::getInstance();
  }

  /**
   * STATIC: Returns a ZenQuery object, db connection will be obtained automatically
   *
   * @return ZenQuery the query object, ready for use
   */
  function getNewQuery() {
    $db = &Zen::getDbConnection();
    return $db->newQuery();
  }

  /**
   * STATIC: Returns a ZenQuery result from a simple query set
   *
   * @param string $table the table to query
   * @param string $field the field to match
   * @param string $value the field value to match
   * @param string $sort the field to sort on(if any)
   */
  function simpleQuery($table, $field = null, $value = null, $sort = null) {
    $query = Zen::getNewQuery();
    $query->table($table);
    if( $field ) { $query->match($field,ZEN_EQ,$value); }
    if( $sort ) { $query->sort($sort); }
    return $query->select(Zen::getCacheTime(), true);
  }

  /**
   * STATIC: Returns a single db row from database
   *
   * @param string $table the table to query
   * @param integer $id the row id
   * @return array containing the db row
   */
  function getDataRow($table, $id) {
    $query = Zen::getNewQuery();
    $query->table($table);
    $query->matchId($id);
    return $query->selectRow(Zen::getCacheTime(), true);
  }

  /**
   * STATIC:: Performs a simple delete from table
   *
   * @param string $table
   * @param string $field field to match for deletion
   * @param string $value value to match in $field for deletion
   * @return boolean
   */
  function simpleDelete($table, $field = null, $value = null) {
    $query = Zen::getNewQuery();
    $query->table($table);
    if( $field ) { $query->match($field,ZEN_EQ,$value); }
    return $query->delete();
  }

  /**
   * STATIC: Performs a simple insert into a table.
   *
   * The primary key will be generated automagically if it is not included.
   * If it is, this query will attempt to insert 'as-is'.  It does not check
   * the id for uniqueness.
   *
   * @param string $table is the table to insert into
   * @param array(indexed) $vals is a map of column->value to be inserted
   * @return integer the rowId of the inserted value (or null/false for failure)
   */
  function simpleInsert( $table, $vals ) {
    // establish query object
    $query = Zen::getNewQuery();
    $query->table($table);

    // insert values
    foreach( $vals as $key=>$val ) {
      $query->field($key, $val);
    }

    // create primary key if not already set
    $pk = ZenDatabase::getPrimaryKey($table);
    if( !isset($vals[$pk]) || !strlen($vals[$pk]) ) {
      $query->setPrimaryKey($pk);
    }

    return $query->insert();
  }

  /**
   * Determine time to cache general sql queries
   */
  function getCacheTime() {
    $time = Zen::getSetting("common", "cache_time");
    if( !$time ) {
      $time = 0;
    }
    return $time;
  }

  /**
   * Stores a message in the ZenMessageList
   *
   * If the ZenMessageList doesn't exist, this function simply returns false
   *
   * @param mixed $class the class object ($this) or a string representing the class/script name
   * @param string $method the method/section producing message
   * @param string $message the message to store
   * @param intege $errnum the error number associated with message
   * @param integer $level the level of the message
   * @return boolean true if message was valid and added successfully
   */
  function debug( $class, $method, $message, $errnum = 0, $level = 3 ) { 
    if( is_object($class) ) {
      $class = get_class($class);
    }
    if( !class_exists("ZenMessageList") ) {
      return false;
    }
    $ml = &Zen::getMessageList();
    return $ml->add($class,$method,$message,$errnum,$level);
  }

  /**
   * retrieves a ticket object, these are cached for life of the page
   *
   * @param integer $ticket_id
   * @return ZenTicket object or false
   */
  function getTicket( $ticket_id ) { }

  /**
   * retrieves a user object, these are cached for life of the page
   *
   * @param integer $user_id
   * @return ZenUser object or false
   */
  function getUser( $user_id ) { }

  /**
   * STATIC: Retrieves a template, parses, inserts variables
   *
   * Note that either $_SESSION['zen'] or $GLOBALS['zen'] must contain the parsed ini
   * directives or this function will fail.
   *
   * @param string $template the name of the template (directory path will be added)
   * @param array $vars (optional) the variables to be inserted into the template
   * @param string $path (optional) the path to the template (usually not necessary as long as $_SESSION['zen'] has been created)
   */
  function loadTemplate( $template, $vars = null, $path = '' ) {
    if( !$path ) {
      if( isset($GLOBALS['templateDir']) ) {
        // grab the path if created
        $path = $GLOBALS['templateDir'];
      }
      else {
        // try to create a path
        if( isset($_SESSION) ) {
          $path = $_SESSION['zen']['directories']['dir_templates']."/"
            .$_SESSION['zen']['layout']['template_set'];
        }
        else {
          $path = $GLOBALS['zen']['directories']['dir_templates']."/"
            .$GLOBALS['zen']['layout']['template_set'];
        }
      }
    }
    $file = $path."/".$template;
    $tpl = new ZenTemplate( $file );
    if( is_array($vars) && count($vars) ) {
      $tpl->values( $vars );
    }
    return $tpl->process();
  }

  /*************************
   * DATA CLASS UTILS
   ************************/

  /**
   * STATIC: Returns the meta data for this table
   * in the form of a ZenMetaTable object
   *
   * The data is obtained from the TABLE_DEFS and FIELD_DEFS db tables, which are
   * constructed from the xml during db generation
   *
   * This function caches meta data for the life of the page using $GLOBALS
   *
   * @param mixed $class a $this reference or a string containing the classname
   * @return ZenMetaTable object
   */
  function getMetaData( $class ) {
    $table = ZenUtils::tableNameFromClass( $class );
    $metaDb = Zen::getMetaDb();
    return $metaDb->getMetaTable($table);
  }

  /**
   * Returns a singleton instance of ZenDbSchema.  This call is cached for the life of the page.
   *
   * @return ZenDbSchema (singleton)
   */
  function &getZenDbSchema() {
    // the array may not be initialized if we did not run variables.php, so
    // we will manually create it
    if( !isset($GLOBALS['tcache']) ) { $GLOBALS['tcache'] = array(); }
    // if our metaDb hasn't been cached, then we will create it now
    if( !isset($GLOBALS['tcache']['dbSchema']) ) {
      $xmlfile = ZenUtils::getIni('directories','dir_config')."/database.xml";
      $GLOBALS['tcache']['dbSchema'] = new ZenDbSchema( $xmlfile );
    }
    // get the value from the cache
    return $GLOBALS['tcache']['dbSchema'];
  }

  /**
   * Returns a singleton instance of ZenMetaDB.  This call is cached for life of page.
   *
   * @return ZenMetaDB (singleton)
   */
  function &getMetaDb() {
    // the array may not be initialized if we did not run variables.php, so
    // we will manually create it
    if( !isset($GLOBALS['tcache']) ) { $GLOBALS['tcache'] = array(); }
    // if our metaDb hasn't been cached, then we will create it now
    if( !isset($GLOBALS['tcache']['metaDb']) ) {
      $xmlfile = ZenUtils::getIni('directories','dir_config')."/database.xml";
      $GLOBALS['tcache']['metaDb'] = new ZenMetaDb( $xmlfile );
    }
    // get the value from the cache
    return $GLOBALS['tcache']['metaDb'];
  }

  /*********************************
   * UTILITIES 
   ********************************/

  /**
   * Shows a date properly formatted according to the system settings
   *
   * This function requires a db connection to retrieve the config setting
   * which details how to display the date properly
   *
   * @param integer $utime is a unix timestamp of date to show
   * @return string the formatted date string
   * @see Zen::getDbConnection
   */
  function showDate( $utime = '' ) { 
    $fmt = Zen::getSetting('common','date_format_short');
    if( $fmt == null ) { $fmt = '%Y-%m-%d'; }
    return strftime($fmt, $utime);
  }

  /**
   * Shows a long format date properly formatted according to the system settings
   *
   * @param integer $utime is a unix timestamp of date to show
   * @return string the formatted long date string
   */
  function showLongDate( $utime = '' ) { 
    $fmt = Zen::getSetting('common','date_format_long');
    if( $fmt == null ) { $fmt = '%A %d, %b %Y'; }
    return strftime($fmt, $utime);
  }

  /**
   * Shows a date and time properly formatted according to the system settings
   *
   * @param integer $utime is a unix timestamp of date to show
   * @return string the formatted date and time string
   */
  function showDateTime( $utime = '' ) { 
    return Zen::showDate($utime).' '.Zen::showTime($utime);
  }

  /**
   * Shows a time properly formatted according to the system settings
   *
   * @param integer $utime is a unix timestamp of date to show
   * @return string the formatted time string
   */
  function showTime( $utime = '' ) { 
    $fmt = Zen::getSetting('common','date_format_time');
    if( $fmt == null ) { $fmt = '%H:%M'; }
    return strftime($fmt, $utime);
  }


  /**
   * STATIC: Creates a string in title case
   *
   * This will not capitalize articles or prepositions, and will retain 
   * acronyms and proper nouns as specified by lists/ucwords, lists/lcwords, lists/states
   *
   * This function calls {@link Zen::getIniVal} which assumes the zen.ini 
   * file has been parsed and stored globally
   *
   * @param string $string the string to capitalize
   * @return string the capitalized string
   */
  function titleCase( $string ) { 
    static $ucwords;
    static $lcwords;
    static $states;

    // get word lists
    if( $ucwords == null || $lcwords == null || $states == null ) {
      ZenUtils::safeDebug('Zen', 'titleCase', 'Generating static vars for this method', 0, LEVEL_DEBUG);
      $dir = Zen::getIniVal('directories','dir_lib');
      $ucwords = ZenUtils::parse_datafile( "$dir/lists/ucwords", null );
      $lcwords = ZenUtils::parse_datafile( "$dir/lists/lcwords", null );
    }

    // save this for later
    preg_match('/(&[#a-zA-Z0-9];)/', $string, $entities);

    //todo tokenize the list of words and process
    if( strlen($string) ) {
      // fix lower case words
      foreach($lcwords as $l) {
        $string = preg_replace("/\b".ucfirst($l)."\b/", $l, $string);
      }
      // fix acronyms
      foreach($ucwords as $u) {
        $string = preg_replace("/\b".ucfirst(strtolower($u))."\b/", $u, $string);
      }
      // fix funny first characters
      if( preg_match("/^([^a-zA-Z]*[a-z])/", $string, $matches) ) {
        $string = preg_replace("/^([^a-zA-Z]*[a-z])/", strtoupper($matches[1]), $string);
      }
      // fix words with dashes
      $string = preg_replace("/([a-z])+-([A-Z])/", "'\\1-'.strtolower('\\2')", $string);
      // fix html meta chars
      if( count($entities) ) {
        foreach($entities as $e) {
          $string = preg_replace("/$e/i", $e, $string);
        }
      }
    }

    //todo join the list and return results
    return $string;
  }

  /********************************
   * SYSTEM UTILS
   *******************************/
 
  /**
   * STATIC: Loads a data type set into an array
   *
   * Note that this is only applicable for the standard types: bin, priority, stage, system, task, type
   *
   * @static
   * @param string $type represents the type, as listed in the description above
   * @return array contains the data type list indexed by id and sorted by priority and name
   */
  function loadDataTypeArray( $type ) {
    if( in_array($type, array("bin","priority","stage","system","task","type")) ) {
      $vars = ZenUtils::findGlobal('cache','data_types');
      if( !isset($vars[$type]) ) {
        $vals = array();
        $name = Zen::mapTypeToClass($type)."List";
        $list = new $name();
        $list->sort('field_pri');
        $list->sort('field_name');
        $list->load();
        while( $list->hasNext() ) {
          $val = $list->next();
          $vals[ $val->id() ] = $val->getField('field_name');
        }
        if( isset($_SESSION) ) {
          $_SESSION['cache']['data_types'][$type] = $vals;
        }
        else {
          $GLOBALS['cache']['data_types'][$type] = $vals;
        }
        return $vals;
      }
      return $vars[$type];
    }
    return false;
  }

  /**
   * STATIC: Maps standard data types from their primitive name to a class name
   * 
   * @static
   * @access private
   * @param string $type is one of: bin, priority, stage, system, task, type
   */
  function mapTypeToClass( $type ) {
    return "Zen".ucfirst(strtolower($type));
  }

  /********************************
   * VARIABLES 
   *******************************/

  /** @var array $_settings the system settings */
  var $_settings;

  /** @var array $_errorIndexByMethod contains an index of error objects by method */
  var $_errorIndexByMethod;
  
  /** @var array $_errorIndexByLevel contains an index of error objects by level */
  var $_errorIndexByLevel;
  
  /** @var array $_errors contains the error objects */
  var $_errors;

}

?>
