<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * Holds the database schema parsed from the xml configuration file.
 *
 * This is a map of the database structure.  This contains only the basic db stucture.
 * All of the user configured portions are controlled by the {@link ZenMetaDb} class.
 *
 * @package DB
 */
class ZenDbSchema extends Zen {

  /**
   * CONSTRUCTOR
   *
   * @param string $xmlfile filename or valid xml data to parse
   * @param boolean $use_cache if true, check for cached data rather than parsing $xmlfile (this is essential for install ops)
   * @param boolean $devmode are we in develop mode? (will search for this if not provided)
   */
  function ZenDbSchema( $xmlfile, $use_cache = true, $devmode = null ) {
    // call Zen()
    $this->Zen();

    // develop mode?
    $this->_devmode = $devmode? $devmode : ZenUtils::getIni('debug','develop_mode');

    $cacheFile = ZenUtils::getIni('directories','dir_cache').'/dbSchemaInfo';
    $this->_tables = false;
    if( $use_cache ) {
      $this->_tables = ZenUtils::unserializeFileToData( $cacheFile );
    }

    if( !$use_cache || !$this->_tables ) {
      // find the xml file
      if( !@file_exists($xmlfile) ) {
        $newfile = ZenUtils::getIni( 'directories', 'dir_config' )."/$xmlfile";
        if( !@file_exists($newfile) ) {
          ZenUtils::safeDebug($this, "ZenDbSchema", "The requested schema ($xmlfile) could not be located", 
                     21, LVL_ERROR);
          return;
        }
        $xmlfile = $newfile;
      }
      // load xml data
      $this->_load($xmlfile);
      // cache data for future loads
      if( $use_cache && isset($_SESSION) ) { 
        ZenUtils::serializeDataToFile( $cacheFile, $this->_tables );
      }
    }
  }

  /**
   * Returns the ZenMetaTable object for the requested table
   *
   * @param string $table
   * @return ZenMetaTable
   */
  function getMetaTable( $table ) { 
    $table = $this->getTableArray($table);
    return $table? (new ZenMetaTable($table)) : false; 
  }

  /**
   * Returns a table array containing all schema info for a single table mapped as follows:
   * 
   * <ul>
   *   <li>name [string]
   *   <li>description [string]
   *   <li>inherits [array] all tables inherited by current
   *   <li>is_abstract [boolean]
   *   <li>has_transactions [boolean]
   *   <li>has_custom_fields [boolean]
   *   <li>fields [array] contains the fields and their values
   * </ul>
   * 
   * The fields array contains:
   * <ul>
   *    <li>name - name of the field
   *    <li>label - the descriptive name displayed on pages
   *    <li>size - the actual field size
   *    <li>type - the meta type of this field
   *    <li>ftype - the form field type
   *    <li>notnull - if set, this field cannot be null
   *    <li>required - if set, is required on form entries
   *    <li>criteria - used to create pulldowns or defaults
   *    <li>reference - the foriegn key for field (if any)
   *    <li>default - default value
   *    <li>description - a detailed description of this field and its use
   *    <li>custom - tells if this is a custom field
   *    <li>order - the display order for this field
   *    <li>unique - if the field must be unique
   * </ul>
   *
   *
   * @param string $table name of table to retrieve
   * @return array mapped as above or false
   */
  function getTableArray( $table ) { 
    return isset($this->_tables[$table])? $this->_tables[$table] : false;
  }

  /**
   * Returns a table as with {@link getTableArray()}, include all inherited fields
   *
   * @param string $table
   * @return array see getTableArray()
   */
  function getMergedTableArray( $table ) {
    if( !isset($this->_tables[$table]) ) { return false; }
    $table = $this->_tables[$table];
    foreach( $this->getInheritedFields($table) as $key=>$val ) {
      if( !isset($table['fields'][$key]) ) {
        $table['fields'][$key] = $val;
      }
    }
    return $table;
  }

  /**
   * Return a ZenMetaField for a given column
   *
   * @param string $table
   * @param string $column
   * @return ZenMetaField or false
   */
  function getMetaField( $table, $column ) {
    $field = $this->getFieldArray($table,$column);
    return $field? (new ZenMetaField($field)) : false;
  }

  /**
   * Return an array for the table field, mapped as explained in {@link ZenDbSchema::getTableArray()}
   *
   * @param string $table
   * @param string $column
   * @return array or false
   */
  function getFieldArray( $table, $column ) {
    return isset($this->_tables[$table]['fields'][$column])? 
      $this->_tables[$table]['fields'][$column] : false;
  }

  /**
   * Load the xml file and parse contents
   *
   * @param string $xmlfile filename or valid xml data to parse
   */
  function _load( $xmlfile ) {
    ZenUtils::safeDebug($this, '_load', "Loading xml data from $xmlfile", 0, LVL_DEBUG);
    // load xml data to an array
    $x = new ZenXMLParser();
    $xnode =& $x->parse($xmlfile);
    $xmldata = $xnode->toArray(true);
    $this->_tables = array();
    $this->_updateQueries = array();

    // if there is only one entry then it was probably compressed, so
    // lets uncompress it before we try to iterate through it and break
    // everything
    $atables = $xmldata['children']['abstractTables']['children']['table'];
    if( count($atables) && !isset($atables[0]) ) { $atables = array($atables); }
    $tables =  $xmldata['children']['tables']['children']['table'];
    if( count($tables) && !isset($tables[0]) ) { $tables = array($tables); }
    $updates = isset($xmldata['children']['upgradeQueries'])? 
      $xmldata['children']['upgradeQueries']['children']['query'] : array();
    if( count($updates) && !isset($updates[0]) ) {
      $updates = array($updates);
    }
    
    // read array 
    foreach( $atables as $val ) {
      $this->_loadTable( $val, true );
    } 
    foreach( $tables as $val ) {
      $this->_loadTable( $val, false );
    } 
    foreach( $updates as $val ) {
      $this->_loadUpdateQuery($val);
    }
  }

  /**
   * Read a table array into the schema
   *
   * @access private
   */
  function _loadTable( $data, $abstract = false ) {
    $n = $data['properties']['name'];    
    $c = $data['children'];
    $t = array( 'name' => $n, 'fields' => array() );
    $t['description'] = isset($c['description'])? $c['description']['data'] : null;
    $t['inherits'] = array();
    if( isset($c['inherit']) ) {
      // need to compress if only one
      if( !isset($c['inherit'][0]) ) { $c['inherit'] = array($c['inherit']); }
      foreach($c['inherit'] as $i) {
	$t['inherits'][] = $i['data'];
       }
    }
    // check for devmode param, skip
    // if this is a test table
    if( !$this->_devmode && in_array('ABSTRACT_TEST',$t['inherits']) ) {
      ZenUtils::safeDebug($this, '_load', "Not in develop mode, skipping test table: $n", 0, LVL_DEBUG);
      return;
    }

    // see if table is abstract
    $t['is_abstract'] = $abstract;

    // see if table supports transactions
    if( isset($data['children']['transactions'])
        && $data['children']['transactions'] == 'true' ) {
      $t['has_transactions'] = true;
    }
    else {
      $t['has_transactions'] = false;
    }

    // the table may not have any columns (could simply inherit, or be an abstract with no columns)
    if( count($c['columns']['children']) ) {
      // if there is only one column, it was compressed, so
      // lets fix this before we try to iterate through it
      $columns = $c['columns']['children']['column'];
      if( !isset($columns[0]) ) { $columns = array($columns); }
      
      // iterate through columns
      foreach( $columns as $field ) {
        $k = $field['properties']['name'];
        $t['fields'][$k] = $this->_loadField($field, false);
      }
    }

    // iterate through custom columns
    if( isset($c['customList']['children']) ) {
      $t['has_custom_fields'] = true;
      // if there is only one column, it was compressed, so
      // lets fix this before we try to iterate through it
      $customs = $c['customList']['children']['column'];
      if( !isset($customs[0]) ) { $customs = array($customs); }
      foreach($customs as $field) {
	$k = $field['properties']['name'];
	$t['fields'][$k] = $this->_loadField($field, true);
      }
    }
    else { $t['has_custom_fields'] = false; }
    $this->_tables[$n] = $t;

    // iterate through all indexes associated with this table
    // and create appropriately
    $indices = array();
    if( isset($c['indexList']['children']) ) {
      if( !isset($c['indexList']['children']['index'][0]) ) {
        $c['indexList']['children']['index'] = array($c['indexList']['children']['index']);
      }
      foreach( $c['indexList']['children']['index'] as $index ) {
        $key = $index['properties']['name'];
        $indices[$key] = explode(',', $index['data']);
      }
    }
    $this->_indices[$n] = $indices;
  }

  /**
   * Parse a field array and return the array set to use in schema
   *
   * @access private
   */
  function _loadField( $field, $is_custom = false ) {
    $f = $field['properties'];
    $c = $field['children'];
    foreach( $this->_columnTags as $t ) {
      $f[$t] = isset($c[$t])? $c[$t]['data'] : null;
      if( $t == 'criteria' && isset($c[$t]) ) {
        $f[$t] = array($c[$t]['properties']['type'], $f[$t]);
      }
      else if( $t == 'required' ) {
        if( isset($c[$t]) && $c[$t] != "false" ) {
          // in the case where we have a required param, we will
          // use this
          $f[$t] = 1;
        }
        else if( !isset($c[$t]) && isset($c['notnull']) && $c['notnull'] != "false" 
                 && !isset($c['default']) ) {
          // in the case that there is not a required param, the field is not null,
          // and we do not have a default, then user input is required
          $f[$t] = 1;
        }
        else {
          // all other cases (since it isn't specified, or we have a default) can
          // be assumed to be ok
          $f[$t] = 0;
        }
      }
    }
    $f['custom'] = $is_custom;
    // relaxed 'requirement' status for label (should be required)
    if( !isset($f['label']) ) { $f['label'] = ""; }
    return $f;
  }

  /**
   * Loads update queries used to upgrade from previous database versions
   *
   * @param array $query
   */
  function _loadUpdateQuery($query) {
    $this->_updateQueries[] = array($query['children']['description'], $query['children']['sql']);
  }

  /**
   * Add a new table to the schema.  This will override any existing table with the same name.
   *
   * @param string $name
   * @param string $description
   * @param boolean $is_abstract
   * @param boolean $has_custom_fields
   * @param array $inherits
   * @return boolean
   */
  function addTable( $name, $description, $is_abstract, $has_custom_fields, 
                     $inherits, $has_transactions ) {
    $this->_tables[$name] = 
      compact( array('name', 'description', 'is_abstract', 'has_custom_fields', 
                     'inherits', 'has_transactions') );
    $this->_tables[$name]['fields'] = array();
    return isset($this->_tables[$name]);
  }
  
  /**
   * Removes a table from the db schema
   *
   * @param string $name
   * @return boolean
   */
  function dropTable( $name ) {
    if( !isset($this->_tables[$name]) ) { return false; }
    unset($this->_tables[$name]);
    return true;
  }

  /**
   * Set a property for an existing table
   *
   * @param string $table
   * @param string $property
   * @param mixed $value
   * @return boolean property was set
   */
  function setTableProperty( $table, $property, $value ) {
    if( isset($this->_tables[$table]) && ZenMetaTable::isProperty($property) ) {
      $this->_tables[$table][$property] = $value;
      return true;
    }
    return false;
  }

  /**
   * Add a column to a table.  If column exists, it will be replaced.
   *
   * @param string $table
   * @param string $name name of column in db
   * @param string $label user text to display for column
   * @param boolean $custom is this a custom field
   * @param string $type db data type
   * @param string $ftype form field type
   * @param array $props
   * @return boolean
   */
  function addColumn( $table, $name, $label, $custom, $type, $ftype, $props ) {
    if( !isset($this->_tables[$table]) ) { return false; }
    $this->_tables[$table]['fields'][$name] = 
      compact( array('name','label','custom','type','ftype') );
    foreach( $this->_columnTags as $c ) {
      $this->_tables[$table]['fields'][$name][$c] = isset($props[$c])? $props[$c] : null;
    }
    return true;
  }

  /**
   * Drop a column from a table
   *
   * @param string $table
   * @param string $column
   */
  function dropColumn( $table, $column ) {
    if( isset($this->_tables[$table]) && isset($this->_tables[$table]['fields'][$column]) ) {
      unset($this->_tables[$table]['fields'][$column]);
      return true;
    }
    return false;
  }

  /**
   * Set a property of a column
   *
   * @param string $table
   * @param string $column
   * @param string $property
   * @param mixed $value
   */
  function setColumnProperty( $table, $column, $property, $value ) {
    if( isset($this->_tables[$table]['fields'][$column]) && ZenMetaField::isProperty($property) ) {
      $this->_tables[$table]['fields'][$column][$property] = $value;
      return true;
    }
    return false;
  }

  /**
   * Return a list of tables in the database
   *
   * @return contains list of table names
   */
  function listTables() { return array_keys($this->_tables); }

  /**
   * Return all tables in a list as in {@link getTableArray()}
   *
   * @return array
   */
  function getAllTables() { return $this->_tables; }

  /**
   * Return a list of columns inherited from
   * other tables
   *
   * @param string $table
   * @return array of columns
   */
  function getInheritedFields( $table ) {
    $table = $this->getTableArray($table);
    return $this->_inheritRecursiveFields($table['inherits']);
  }

  /**
   * Return indexes associated with a table
   *
   * @param string $table name of table to retrieve
   * @return array mapped (string)index_name -> (array)index (always returns an array)
   */
  function getIndices( $table ) {
    return isset($this->_indices[$table])? $this->_indices[$table] : array();
  }

  /**
   * Return indexes associated with this table and all tables it inherits
   *
   * @param string $tableName
   * @return array mapped (string)index_name -> (array)index (always returns an array)
   */
  function getMergedIndices( $tableName ) {
    // get table info
    $table = $this->getTableArray($tableName);
    // initialize and validate
    $vals = $this->getIndices($tableName);
    if( !$table ) { return $vals; }
    // find inherited indices
    foreach( $table['inherits'] as $i ) {
      $vals = array_merge($vals, $this->getMergedIndices($i));
    }
    // return results
    return $vals;
  }

  /**
   * Returns all indexes for all tables
   *
   * @return array mapped (string)table_name -> array( (string)index_name -> (array)index_info )
   */
  function getAllIndices() { return $this->_indices; }

  /**
   * Returns the update queries associated with this db schema
   */
  function getUpgradeQueries() {
    return $this->_updateQueries;
  }

  /**
   * Retrieve inherited fields recursively
   *
   * @param mixed $tables is null, string, or array of table names
   * @access private
   * @return array
   */
  function _inheritRecursiveFields( $tables ) {
    $vals = array();
    // skip blank entries
    if( $tables == null ) { return $vals; }
    // make it an array for simplicity
    else if( !is_array($tables) ) { $tables = array($tables); }
    // loop through tables and get results
    foreach( $tables as $t ) {
      $table = $this->getTableArray($t);
      // also process any tables inherited by this table(recursive)
      $vals = array_merge($vals, $this->_inheritRecursiveFields($table['inherits']));
      // get values from this table
      $vals = array_merge($vals, $table['fields']);
    }
    return $vals;
  }
  

  /* VARIABLES */

  /**
   * A list of possible column subnodes
   */
  var $_columnTags = array('size','unique','notnull',
			   'required','default','description',
			   'version','order','criteria','reference');

  /** 
   * @var array $_tables is a mapped array of (string)table_name -> (array)table_info
   * @see ZenDbSchema::getTableArray()
   */
  var $_tables;

  /**
   * @var array $_indices is a mapped array of (string)table_name -> (array)related_indices
   */
  var $_indices;

  /**
   * @var array $_updateQueries array( (string)description, (string)sql statement ) for use with upgrading dbs
   */
  var $_updateQueries;

  /**
   * @var boolean $_devmode are we in develop mode? if not, we skip test tables
   */
  var $_devmode;
  
}

?>
