<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * Combines user defined info with DbSchema info and produces complete db model
 *
 * @package DB
 */
class ZenMetaDb extends Zen {

  /**
   * CONSTRUCTOR
   *
   * There is no way to reload data in this file.  Instead, simply call
   * {@link ZenMetaDb::clearDbSchemaCache()} and then create a new ZenMetaDb object
   *
   * The options for using the cache and providing an alternate database.xml file are
   * for upgrade functions, and not normally necessary or useful.  All cache flushing
   * can be done with {@link ZenMetaDb::clearCacheInfo()}, and the database schema
   * will not change often.
   *
   * @param boolean $use_cache attempt to load/store data in session
   * @param string $xml the database.xml file to load
   */
  function ZenMetaDb( $use_cache = true, $xml = 'database.xml' ) {
    // call Zen()
    $this->Zen();
    $this->_conn = Zen::getDbConnection();
    $this->_schema = new ZenDbSchema( $xml );
    $this->_tables = false;
    if( !$this->_conn ) {
      Zen::debug($this, 'ZenMetaDb', 'Unable to load meta info, no db connection found', 202, LVL_ERROR);
      return;
    }
    if( $use_cache ) {
      $this->_tables = ZenUtils::unserializeFileToData( ZenUtils::getIni('directories','dir_cache').'/metaDbInfo' );
      if( $this->_tables ) {
        Zen::debug($this, 'ZenMetaDb', 'metaDbInfo loaded from file', 01, LVL_DEBUG);      
      }
    }
    if( !$use_cache || !$this->_tables ) {
      Zen::debug($this, 'ZenMetaDb', 'metaDbInfo loaded from database(cache file not found)', 00, LVL_NOTE);      
      $this->_load();
      if( $use_cache ) {
        ZenUtils::serializeDataToFile( ZenUtils::getIni('directories','dir_cache').'/metaDbInfo', $this->_tables );
      }
    }
  }

  /**
   * Load schema from xml and def tables into memory
   */
  function _load() {
    $this->_schema = new ZenDbSchema( ZenUtils::getIni('directories','dir_config')."/database.xml" );
    $this->_tables = array();
    $tableInfo = Zen::simpleQuery('TABLE_DEFS',null,null);
    $fieldInfo = Zen::simpleQuery('FIELD_DEFS',null,null);
    foreach( $tableInfo as $t ) {
      $table = strtoupper($t['tbl_name']);
      $this->_tables[$table] = $this->_schema->getTableArray($table);
      if( count($this->_tables[$table]['inherits']) > 0 ) {
        $newfields = $this->_schema->getInheritedFields($table);
        $this->_tables[$table]['fields'] = array_merge($this->_tables[$table]['fields'], $newfields);
      }
      foreach( $t as $key=>$val ) {
        if( !is_null($val) ) {
          $this->_tables[$table][$this->mapTableDbToProp($key)] = $val;
        }
      }
    }
    foreach( $fieldInfo as $f ) {
      $field = strtolower($f['col_name']);
      $table = strtoupper($f['table_name']);
      $this->_tables[$table]['fields'][$field] = $this->_tables[$table]['fields'][$field];
      foreach( $f as $key=>$val ) {
        if( $key == 'col_criteria' ) {
          $val = explode('=',$val);
        }
        if( !is_null($val) ) {
          $this->_tables[$table]['fields'][$field][$this->mapFieldDbToProp($key)] = $val;
        }
      }
    }
    Zen::debug($this, '_load', count($this->_tables)." tables were loaded, containing ".count($fieldInfo)." fields", 01, LVL_DEBUG);    
  }

  /**
   * Maps db column to table properties
   *
   * @static
   * @param string $column
   * @return string
   */
  function mapTableDbToProp( $column ) {
    return substr($column, 4);
  }

  /**
   * Maps table properties to db columns
   *
   * @static
   * @param string $property
   * @return string
   */
  function mapTablePropToDb( $property ) {
    return 'tbl_'.$property;
  }

  /**
   * Maps db column to field properties
   *
   * @static
   * @param string $column
   * @return string
   */
  function mapFieldDbToProp( $column ) {
    if( $column == 'table_name' ) { return 'table_name'; }
    return substr($column, 4);
  }

  /**
   * Maps field properties to db columns
   *
   * @static
   * @param string $property
   * @return string
   */
  function mapFieldPropToDb( $property ) {
    if( $property == 'table_name' ) { return 'table_name'; }
    return 'col_'.$property;
  }
  
  /**
   * Returns an array containing the schema for all tables and fields
   */
  function getSchemaArray() { return $this->_tables; }

  /**
   * Return an array representing table schema, including fields
   * mapped as explained in {@link ZenDbSchema::getTableArray()}
   *
   * @param string $table
   * @return array
   */
  function getTableArray( $table ) {
    $table = strtoupper($table);
    return isset($this->_tables[$table])? $this->_tables[$table] : null;
  }

  /**
   * Return an array representing field schema
   * mapped the same as {@link ZenDbSchema::getFieldArray()}
   *
   * @param string $table
   * @param string $field
   * @return array
   */
  function getFieldArray( $table, $field ) { 
    $field = strtolower($field);
    $table = $this->getTableArray($table);
    if( $table && isset($table['fields'][$field]) ) {
      return $table['fields'][$field];
    }
    return null;
  }

  /**
   * Returns a meta table object representing the given table
   *
   * @param string $table
   * @return ZenMetaTable
   */
  function getMetaTable( $table ) {
    return new ZenMetaTable( $this->getTableArray($table) );
  }

  /**
   * Set the values of a db table by returning a ZenMetaTable object
   * with the updated values.
   *
   * Note that the object must be marked as updated or it will be
   * rejected.  This can be done manually using {@link ZenMetaTable::forceChanged()}
   * if the need arises.
   *
   * If you wish to copy a table into an existing one, use the
   * {@link ZenMetaTable::copy()} method.
   *
   * @param ZenMetaTable $updatedMetaTable
   * @return boolean true if table was updated
   */
  function setMetaTable( $updatedMetaTable ) {
    if( !$updatedMetaTable->changed() ) {
      Zen::debug($this, 'setMetaTable', 'ZenMetaTable->updated() is false, ignoring', 161, LVL_NOTE);
      return false;
    }
    $table = $updatedMetaTable->table();
    $this->_tables[$table] = $updatedMetaTable->getTableArray();
    Zen::debug($this, 'setMetaTable', "ZenMetaTable[$table] updated", 00, LVL_DEBUG);
    return true;
  }

  /**
   * Returns a meta field object representing the given field
   *
   * @param string $table
   * @param string $field
   * @return ZenMetaField
   */
  function getMetaField( $table, $field ) {
    return new ZenMetaField( $this->getFieldArray($table,$field) );
  }

  /**
   * Returns a list of tables in the database
   *
   * @return array
   */
  function getTableList() { return array_keys($this->_tables); }

  /**
   * Returns a list of fields in a table
   *
   * @param string $table
   * @return array
   */
  function getFieldList( $table ) { 
    $table = strtoupper($table);
    return array_keys($this->_tables[$table]['fields']); 
  }

  /**
   * Set the values of a db field by providing the ZenMetaField with the updated values
   *
   * Note that the object must be marked as updated or it will be
   * rejected.  This can be done manually using {@link ZenMetaField::forceChanged()}
   * if the need arises.
   *
   * If you wish to copy a field into an existing one, use the
   * {@link ZenMetaField::copy()} method.
   *
   * @param ZenMetaField $updatedMetaField
   * @return boolean true if field was updated
   */
  function updateMetaField( $updatedMetaField ) {
    if( !$updatedMetaField->changed() ) {
      Zen::debug($this, 'updateMetaField', 'ZenMetaField->updated() is false, ignoring', 161, LVL_NOTE);
      return false;
    }
    $table = $updatedMetaField->table();
    $field = $updatedMetaField->name();
    $this->_tables[$table]['fields'][$field] = $updatedMetaField->getFieldArray();
    Zen::debug($this, 'updateMetaField', "ZenMetaField[$table]['fields'][$field] updated", 00, LVL_DEBUG);
    return true;
  }

  /**
   * Clear out the serialized/cached dbSchema and metaDb info.  This is
   * used when database info is changed, or configuration settings are
   * changed.
   *
   * @static
   */
  function clearCacheInfo() {
    $conn =& Zen::getDbConnection(false);
    if( $conn ) { $conn->flushCache(); }
    $dbSchema = ZenUtils::getIni('directories','dir_cache').'/dbSchemaInfo';
    $metaDb = ZenUtils::getIni('directories','dir_cache').'/metaDbInfo';
    if( file_exists($dbSchema) ) { @unlink($dbSchema); }
    if( file_exists($metaDb) ) { @unlink($metaDb); }
    unset($GLOBALS['tcache']['metaDb']);
    unset($GLOBALS['tcache']['dbSchema']);
    Zen::debug($this, 'clearDbSchema', "DB cache emptied", 00, LVL_DEBUG);
  }

  /**
   * Returns a ZenDBForm for a specific table
   *
   * @param string $table
   * @return ZenDBForm
   */
  function getDbForm( $table ) {
    return new ZenDBForm( $this, $table );
  }

  /* VARIABLES */

  /** @var ZenDbSchema $_schema is the base xml schema for the database */
  var $_schema;

  /** @var array $_tables mapped (string)table_name -> (ZenMetaTable)table_object */
  var $_tables;

  /** @var ZenDatabase $_conn database connection */
  var $_conn;

}

?>
