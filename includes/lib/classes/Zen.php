<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package Zen */
class Zen {

  /**
   * CONSTRUCTOR: constructs common vars and objects
   * 
   * This method relies on the global array: $_SESSION['zen']
   * which is created in header.php in the www/ directory.
   *
   * Note that, for the sake of installation utils, this class also 
   * checks $GLOBALS['zen'] if $_SESSION is not set.
   *
   * This method should be invoked by all child constructors
   * This should set up the following vars, pulled from the
   * config.ini file:
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
  function Zen() { }

  /**********************************
   * STATIC METHODS (prevent multiple objects when possible, rely on static page array $loaded_data) 
   *
   * These static methods should be written in a manner that will allow them to be called via
   * the approach Zen::getSetting($cat,$name) ... etc
   *********************************/

  /**
   * returns a system setting
   *
   * this method will return a system setting... some sort of static/global setup
   * would be best to invoke here, to avoid redundant calls
   *
   * @param string $cat is the category for the setting (tickets, 
   * @param string $name of the setting
   * @return string value of the setting or null if it isn't found
   */
  function getSetting($cat, $name) { 
    $cat = $this->_loadSettings($cat);
    return isset($cat[$name])? $cat[$name] : null;
  }

  /**
   * loads system settings into memory
   *
   * This method should employ a static list from the GLOBAL settings to avoid
   * redundant calls to this
   *
   * @param string $cat is the category
   */
  function _loadSettings( $cat ) { 
    if( $cat == "common" ) {
      if( !isset($_SESSION['cache']['common_settings']) ) {
        $query = getNewQuery();
        $query->table("SETTING");
        $query->match("set_category", "common", ZEN_EQ);
        $vars = $query->select(0, true);
        $_SESSION['cache']['common_settings'] = $this->keySet($vars, "set_name", "set_value");
      }
      return $_SESSION['cache']['common_settings'];
    }
    else {
      if( !isset($GLOBALS['tcache']['settings'][$cat]) ) {
        $GLOBALS['tcache']['settings'][$cat] = $this->keySet($this->simpleQuery("SETTING", "set_category", $cat),
                                                             "set_name",
                                                             "set_value");
      }
      return ($GLOBALS['tcache']['settings'][$cat];
    }

  }

  /**
   * STATIC: returns a db connection / database object
   *
   * @return object databaseObject
   */
  function &getDbConnection() {
    if( !isset($GLOBALS['dbConnection']) || $GLOBALS['dbConnection'] == null ) {
      Zen::debug("Zen", "getDbConnection", "Creating database connection (cache empty)", 0, 3);
      if( isset($_SESSION['zen']) ) {
        $db = $_SESSION['zen']['db'];
        $dir_cache = $_SESSION['zen']['directories']['dir_dbcache'];
        $prefix = $_SESSION['zen']['db']['table_prefix'];
      }
      else {
        $db = $GLOBALS['zen']['db'];
        $dir_cache = $GLOBALS['zen']['directories']['dir_dbcache'];
        $prefix = $GLOBALS['zen']['db']['table_prefix'];
      }
      $GLOBALS['dbConnection'] = new ZenDatabase($db['db_type'], 
                                                  $db['db_host'],
                                                  $db['db_user'],
                                                  $db['db_pass'],
                                                  $db['db_instance']);
      
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
  function simpleQuery($table, $field, $value, $sort = null) {
    $query = $this->getNewQuery();
    $query->table($table);
    $query->match($field,$value);
    if( $sort ) { $query->sort($sort); }
    return $query->select($this->getCacheTime(), true);
  }

  /**
   * Determine time to cache general sql queries
   */
  function getCacheTime() {
    $time = $this->getSetting("common", "cache_time");
    if( !$time ) {
      $time = 0;
    }
    return $time;
  }

  /**
   * returns a ZenMessageList of system messages matching criteria
   *
   * this method should use a GLOBAL array to maintain a single list
   * for all of the results
   *
   * @param string $class returns only errors from this class
   * @param string $method return only errors from this method
   * @return ZenMessageList object containing valid system messages
   * @see ZenMessageList
   */
  function getDebug( $class = '', $method = '' ) { }

  /**
   * stores a message in the ZenMessageList
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
   * Takes a data type and returns the primary key of that table field
   *
   * This method will validate the class type using is_a to see if it is a valid ZenList
   * or ZenBase child (extends one of these)
   *
   * @param mixed $class is class object ($this reference) or string containing classname
   * @return string the name of the primary key column
   */
  function getPrimaryKey( $class ) {
    return Zen::tableNameFromClass($class)."_id";
  }

  /**
   * STATIC: Returns the meta data for this table
   * in the form of a ZenMetaTable object
   *
   * The data is obtained from the TABLE_DEFS and FIELD_DEFS db tables, which are
   * constructed from the xml during db generation
   *
   * @param mixed $class a $this reference or a string containing the classname
   * @return ZenMetaTable object
   */
  function getMetaData( $class ) {
    $cname = Zen::tableNameFromClass( $class );
    if( !isset($GLOBALS['tcache']) ) { $GLOBALS['tcache'] = array(); }
    if( !isset($GLOBALS['tcache']['metaTables']) ) { $GLOBALS['tcache']['metaTables'] = array(); }
    if( !isset($GLOBALS['tcache']['metaTables'][$cname]) ) {
      $GLOBALS['tcache']['metaTables'][$cname] = new ZenMetaTable($cname);
    }
    return $GLOBALS['tcache']['metaTables'][$cname];
  }

  /**
   * STATIC: Returns the name of the db table corresponding to this class object
   *
   * @param mixed $class is a $this object reference or a string containing class name
   * @param string name of table or false if none
   */
  function tableNameFromClass( $class ) { 
    $cname = strtolower(is_object($class)? class_name($class) : $class);
    // remove Zen from beginning of name
    if( strpos( $cname, "Zen" ) === 0 ) {
      $cname = substr($cname, 3);    
    }
    // remove .class from end if necessary
    if( strpos( $cname, ".class" ) ) {
      $cname = substr($cname, 0, -4);
    }
    // remove List from end if necessary
    if( strpos( $cname, 'list' ) == strlen($cname)-4 ) {
      $cname = substr($cname, 0, -4);
    }
    return $cname;
  }

  /**
   * STATIC: Returns the name of a class corresponding to a db table
   *
   * @param string $table name of the db table
   * @return string full class name corresponding to table or false if none
   */
  function classNameFromTable( $table ) { 
    // return with proper case and Zen prefix
    return "Zen".ucfirst(strtolower($table));
  }


  /*********************************
   * UTILITIES 
   ********************************/

  /**
   * Takes a simple array and returns an associative array in the form key=>value
   *
   * @param array $vals the simple array to get data from
   * @param string|int $key is the field to use for the key
   * @param string|int $val is the field to use for val, if this is omitted, then whole array goes in val spot
   */
  function keySet( $vals, $key, $val = null ) {
    $newvals = array();
    for($i=0; $i<count($vals); $i++) {
      if( isset($vals[$i]) && is_array($vals[$i]) ) {
        if( isset($vals[$i][$key]) && strlen($vals[$i][$key]) ) {
          $k = $vals[$i][$key];
          $v = ($val)? $vals[$i][$val] : $vals[$i];
          $newvals[$k] = $v;
        }
      }
    }
    return $newvals;
  }

  /**
   * STATIC: Flatten an multi-dimensional associative array to depth of 1
   *
   * Note that any variables in sub-arrays will overwrite the base values
   *
   * @param array $vals is a multi-dimensional associative array
   * @return array a single dimension associative array
   */
  function flatten_array( $vals ) {
    $newvals = array();
    foreach($vals as $key=>$val) {
      if( is_array($val) ) {
        $newvals = array_merge($newvals, Zen::flatten_array($val));
      }
      else {
        $newvals[$key] = $val;
      }
    }
    return $newvals;
  }

  /**
   * STATIC: Prints an array out as formatted text
   *
   * @param array $vals can be key/value, multi-level, etc
   */
  function printArray( $vals ) {
    print "<pre>\n";
    print_r($vals);
    print "</pre>\n";
  }

  /**
   * Formats a value for display in forms
   *
   * @param String $text
   * @return String containing formatted text for use in <input..> and <textarea> fields
   */
  function ffv( $text ) { }

  /**
   * Cleans a block of pre-formatted text entered by user
   *
   * Specifically for use with the ticket details and logs
   * This will create links out of proper url entries, and
   * preserve spacing, etc.  All html tags will be printed
   * as source.
   * 
   * May also be useful for emails
   *
   * @param String $text is the text to display
   * @return String containing formatted text for display in &lt;pre&gt; tags or emails
   */
  function fixPreformattedBlock( $text ) { }

  /**
   * Creates a string in title case
   *
   * This will not capitalize articles or prepositions, and will retain acronyms and proper nouns
   * as specified by lists/ucwords and lists/lcwords
   *
   * @param string $string the string to capitalize
   * @return string the capitalized string
   */
  function titleCase( $string ) { }

  /**
   * Shows a date properly formatted according to the system settings
   *
   * @param integer $utime is a unix timestamp of date to show
   * @return string the formatted date string
   */
  function showDate( $utime = '' ) { }

  /**
   * Shows a long format date properly formatted according to the system settings
   *
   * @param integer $utime is a unix timestamp of date to show
   * @return string the formatted long date string
   */
  function showLongDate( $utime = '' ) { }

  /**
   * Shows a date and time properly formatted according to the system settings
   *
   * @param integer $utime is a unix timestamp of date to show
   * @return string the formatted date and time string
   */
  function showDateTime( $utime = '' ) { }

  /**
   * Shows a time properly formatted according to the system settings
   *
   * @param integer $utime is a unix timestamp of date to show
   * @return string the formatted time string
   */
  function showTime( $utime = '' ) { }

  /**
   * Parses a date into a unix timestamp (necessary since strtotime() is beginning to fall short here)
   *
   * @param string $date is the date to parse
   * @return integer unix timestamp representative of date
   */
  function parseDate( $date ) { return strtotime($date); }

  /**
   * Determines if a date lies on the interval of a date range
   *
   * @param integer $utime the unix timestamp to compare
   * @param integer $step the increment of our interval (every $step periods)
   * @param string $period is the period traversed (days,hours,weeks,months,years)
   * @param integer $base is any unix timestamp occuring on the desired interval
   * @return boolean is on the interval of the range given
   */
  function dateFallsOn( $utime, $step, $period, $base ) { }


  /********************************
   * SYSTEM UTILS
   *******************************/
 
  /**
   * Loads a data type set into an array
   *
   * Note that this is only applicable for standard types: bin, priority, stage, system, task, type
   *
   * @return array contains the data type list indexed by id and sorted by priority and name
   */
  function loadDataTypeArray( $type ) {}

  /**
   * STATIC: Reads a .ini file, replaces occurences of %variable_name% with another value already declared
   *
   * Note that variables to be used as replacements MUST ALREADY BE CALLED
   * Additionally, all properties in the ini file must appear under a section heading
   * or this will fail miserably.
   *
   * @param string $ini_file is the absolute path to the file
   * @return array parsed ini file contents
   */
  function read_ini( $ini_file ) {
    $data = parse_ini_file( $ini_file, TRUE );
    $bulk = array();
    foreach($data as $section=>$vals) {
      foreach($vals as $key=>$val) {
        while( preg_match("/\%([a-zA-Z0-9_]+)\%/", $val, $matches) ) {
          $v = $matches[1];
          $val = preg_replace("/\%$v\%/", $bulk[$v], $val);
        }
        $data[$section][$key] = $val;
        $bulk[$key] = $data[$section][$key];
      }
    }
    return $data;
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

  /** @var array $_lcwords is a list of words that should be lower case in title structure */
  var $_lcwords;
 
  /** @var array $_ucwords is a list of words that should be upper case in title structure */
  var $_ucwords;

}

?>
