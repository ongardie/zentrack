<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * Holds the database schema parsed from xml data
 *
 * @package DB
 */
class ZenDbSchema extends Zen {

  /**
   * CONSTRUCTOR
   *
   * @param string $xmlfile filename or valid xml data to parse
   * @param boolean $use_cache if true, checks for cached data and loads rather than parsing $xmlfile
   */
  function ZenDbSchema( $xmlfile, $use_cache = true ) {
    // call Zen()
    $this->Zen();

    $this->_tables = false;
    if( $use_cache ) {
      $this->_tables = ZenUtils::unserializeFile( ZenUtils::getIni('directories','dir_cache').'/dbSchemaInfo' );
    }

    if( !$use_cache || !$this->_tables ) {
      // find the xml file
      if( !@file_exists($xmlfile) ) {
        $newfile = Zen::getIni( 'directories', 'dir_config' )."/$xmlfile";
        if( !@file_exists($newfile) ) {
          Zen::debug($this, "ZenDbSchema", "The requested schema ($xmlfile) could not be located", 
                     21, LVL_ERROR);
          return;
        }
        $xmlfile = $newfile;
      }
      // load xml data
      $this->_load($xmlfile, $parse_as_string);
      // cache data for future loads
      if( $use_cache && isset($_SESSION) ) { 
        ZenUtils::serializeFile( ZenUtils::getIni('directories','dir_cache').'/dbSchemaInfo', $this->_tables );
      }
    }
  }

  /**
   * Returns the ZenMetaTable object for the requested table
   *
   * @param string $table
   * @return ZenMetaTable
   */
  function getMetaTable( $table ) { return new ZenMetaTable( $this->getTableArray($table) ); }

  /**
   * Returns a table array containing all schema info for a single table mapped as follows:
   * 
   * <ul>
   *   <li>name [string]
   *   <li>description [string]
   *   <li>inherits [array] all tables inherited by current
   *   <li>is_abstract [boolean]
   *   <li>has_custom_fields [boolean]
   *   <li>fields [array] contains the fields and their values
   * </ul>
   * 
   * The fields array contains:
   * <ul>
   *    <li>name - name of the field
   *    <li>label - the descriptive name displayed on pages
   *    <li>size - the actual field size
   *    <li>data_type - the meta type of this field
   *    <li>form_type - the form field type
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
   * @return array mapped as above
   */
  function getTableArray( $table ) { return $this->_tables[$table]; }

  /**
   * Return a ZenMetaField for a given column
   *
   * @param string $table
   * @param string $column
   * @return ZenMetaField
   */
  function getMetaField( $table, $column ) {
    return new ZenMetaField($this->getFieldArray($table,$column));
  }

  /**
   * Return an array for the table field, mapped as explained in {@link ZenDbSchema::getTableArray()}
   *
   * @param string $table
   * @param string $column
   * @return array
   */
  function getFieldArray( $table, $column ) {
    return $this->_tables[$table][$column];
  }

  /**
   * Load the xml file and parse contents
   *
   * @param string $xmlfile filename or valid xml data to parse
   */
  function _load( $xmlfile ) {
    // load xml data to an array
    $x = new ZenXMLParser();
    $xnode =& $x->parse($xmlfile);
    $xmldata = $xnode->toArray();
    $this->_tables = array();
    // read array 
    foreach( $xmldata['children']['abstractTables'][0]['children']['table'] as $val ) {
      $this->_loadTable( $val, true );
    }
    foreach( $xmldata['children']['tables'][0]['children']['table'] as $val ) {
      $this->_loadTable( $val, false );
    }
  }

  /**
   * Read a table array into the schema
   *
   * @access private
   */
  function _loadTable( $data, $abstract = false ) {
    $n = $data['name'];    
    $c = $data['children'];
    $t = array( 'fields' => array() );
    $t['description'] = isset($c['description'])? $c['description'][0]['data'] : null;
    $t['inherits'] = array();
    if( isset($c['inherit']) ) {
      foreach($c['inherit'] as $i) {
	$t['inherits'][] = $i['data'];
      }
    }
    $t['is_abstract'] = $abstract;
    foreach( $c['columns'] as $field ) {
      $k = $field['name'];
      $t['fields'][$k] = $this->_loadField($field, false);
    }
    $t['has_custom_fields'] = isset($c['customList']);
    if( isset($c['customList']) ) {
      foreach($c['customList'] as $field) {
	$k = $field['name'];
	$t['fields'][$k] = $this->_loadField($field, true);
      }
    }
    $this->_tables[$n] = $t;
  }

  /**
   * Parse a field array and return the array set to use in schema
   *
   * @access private
   */
  function _loadField( $field, $is_custom = false ) {
    $f = $field['props'];
    foreach( $this->_columnTags as $t ) {
      $f[$t] = isset($field['children'][$t])? $field['children'][$t][0]['data'] : null;
      if( $t == 'criteria' ) {
        $f[$t] = array($field['children'][$t]['props']['type'], $f[$t]);
      }
    }
    $f['custom'] = $is_custom;
    return $f;
  }

  /**
   * Add a new table to the schema.  This will override any existing table with the same name.
   *
   * @param string $name
   * @param string $description
   * @param boolean $is_abstract
   * @param boolean $has_custom_fields
   * @param array $inherits
   */
  function addTable( $name, $description, $is_abstract, $has_custom_fields, $inherits ) {
    $this->_tables[$name] = 
      compact( array('name', 'description', 'is_abstract', 'has_custom_fields', 'inherits') );
    $this->_tables[$name]['fields'] = array();
  }
  
  /**
   * Removes a table from the db schema
   *
   * @param string $name
   */
  function dropTable( $name ) {
    unset($this->_tables[$name]);
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
    if( isset($this->_tables[$table][$property]) ) {
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
   * @param string $data_type db data type
   * @param string $form_type form field type
   * @param array $props
   */
  function addColumn( $table, $name, $label, $custom, $data_type, $form_type, $props ) {
    if( !isset($this->_tables[$table]) ) { return false; }
    $this->_tables[$table][$column] = 
      compact( array('name','label','custom','data_type','form_type') );
    foreach( $this->_columnTags as $c ) {
      $this->_tables[$table][$column][$c] = isset($props[$c])? $props[$c] : null;
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
    if( isset($this->_tables[$table][$column]) ) {
      unset($this->_tables[$table][$column]);
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
    if( isset($this->_tables[$table][$column][$property]) ) {
      $this->_tables[$table][$column][$property] = $value;
      return true;
    }
    return false;
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
  
}

?>
