<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * Contains all schema information for a table and all of its columns
 *
 * @package DB
 */
class ZenMetaTable extends Zen {

  /**
   * CONSTRUCTOR
   *
   * @param array $data is a table schema array obtained from {@link ZenDbSchema::getTableArray()}
   */
  function ZenMetaTable( $data ) {
    // call Zen()
    $this->Zen();
    if( is_array($data) ) {      
      $this->_load($data);
    }
    else {
      Zen::debug('ZenMetaTable','ZenMetaTable','No data provided, initializing empty table',0,LVL_DEBUG);
    }
  }

  /**
   * Copies an existing meta table into this object
   *
   * @param ZenMetaTable $table to be copied
   * @return boolean
   */
  function copy( $table ) {
    if( !is_object($table) || get_class($table) != "ZenMetaTable" ) { 
      Zen::debug($this, 'copy', 'Param was not a valid ZenMetaTable object', 105, LVL_ERROR);
      return false; 
    }
    $this->_data = $table->getTableArray();
    $this->_updated = true;
    $this->_changed = array();
    return true;
  }

  /**
   * Loads data for this table
   *
   * @access private
   */
  function _load( $data ) {
    if( !isset($data['fields']) || !is_array($data['fields']) ) { $data['fields'] = array(); }
    foreach( $this->_props as $p ) {
      $this->_props[$p] = isset($data[$p])? $data[$p] : null;
    }
  }

  /**
   * The name of this table
   * 
   * @return string
   */
  function name() { return $this->getProp('name'); }

  /**
   * Returns a ZenMetaField for a column of this table
   *
   * @param string $field
   * @return ZenMetaField
   */
  function getMetaField( $field ) {
    return new ZenMetaField( $this->_data['fields'][$field] );
  }

  /**
   * Sets properties of a field in this table with the provided ZenMetaField data.
   *
   * @param ZenMetaField $field the updated ZenMetaField data
   * @return boolean
   */
  function setMetaField( $field ) {
    if( !is_object($field) || get_class($field) != "ZenMetaField"
        || !isset($this->_data['fields'][$field->name()]) ) { 
      Zen::debug($this, 'setMetaField', 'Param was not a valid ZenMetaField object', 105, LVL_ERROR);      
      return false; 
    }
    $this->_data['fields'][$field->name()] = $field->getFieldArray();
    $this->_changed[$field->name()] = true;
    return true;
  }
   
  /**
   * Returns an array containing mapped data representing the schema of this table, including field data
   *
   * @return array
   */
  function getTableArray() { return $this->_data; }

  /**
   * Returns a property of this table
   *
   * @param string $property
   * @return mixed $value
   */
  function getProp( $property ) { return $this->_data[$property]; }

  /**
   * Sets a property of this table
   *
   * @param string $property the property to set (cannot be fields)
   * @param mixed $value
   * @return boolean if valid property
   */
  function setProp( $property, $value ) {
    if( $property == 'fields' || !isset($this->_data[$property]) ) {
      Zen::debug($this, 'setProp', 'Attempted to set an invalid property: $property', 105, LVL_ERROR);
      return false;
    }
    $this->_data[$property] = $value;
    return true;
  }

  /**
   * True if this table or one of its fields have been updated since loading (is reset on save() operation)
   *
   * @return boolean
   */
  function updated() {
    return ($this->_updated || count($this->_changed) > 0);
  }

  /**
   * Returns a list of fields which have changed since save/load of this object
   *
   * @return array (does not include properties which may have changed, just fields)
   */
  function getChanged() { return $this->_changed; }

  /**
   * Validates values to be inserted into this table of the database
   *
   * @param array $values mapped (string)field -> (mixed)value
   * @return mixed true if all succeeded or an array mapped (string)field -> (string)error
   */
  function validate( $values ) {
    $errors = array();
    foreach( $values as $k=>$v ) {
      if( isset($this->_data[$k]) ) {
        $f = new ZenMetaField($this->_data[$k]);
        $e = $f->validate( $v );
        if( $e !== true ) { $errors[] = $e; }
      }
      else {
        Zen::debug($this, 'validate', 'Invalid field', 105, LVL_WARN);
        $errors[] = "Field not found: $k";
      }
    }
    if( count($errors) ) { return $errors; }
    return true;
  }

  /**
   * Saves any changes to this table or fields to database
   *
   * @return boolean
   */
  function save() {
    //todo
    //todo
    //todo
    //todo update the tbl_updated field on prop change
    //todo or field change

    // check for updates
    if( !$this->_updated && !count($this->_changed) ) { 
      Zen::debug($this, 'save', 'Attempted to save table, but has not changed', 161, LVL_WARN);
      return false; 
    }
    // save changes to properties
    if( $this->_updated ) {
      $query = Zen::getNewQuery();
      $query->table( 'TABLE_DEFS' );
      foreach( $this->_data as $k=>$v ) {
        if( $k == 'inherits' ) { $v = join(',',$v); }
        else if( $k == 'fields' ) { continue; }
        $query->field( "tbl_$k", $v );
      }
      $query->match( 'tbl_name', ZEN_EQ, $this->name() );
      $res = $query->update();
      Zen::debug($this, 'save', $this->name().": '".$query->getQueryString()."'", 0, LVL_DEBUG);      
    }
    // save changes to fields
    if( $res ) {
      foreach( $this->_changed as $c ) {
        $field = new ZenMetaField( $this->_data['fields'][$c] );
        $field->forceChanged();
        if( !$field->save() ) { $res = false; }
      }
    }
    // return results
    Zen::debug($this, 'save', "Table ".$this->name()." saved to database with result: $res", 0, LVL_NOTE);
    return $res;
  }

  /* VARIABLES */
  

  /** @var array $_data contains the properties and fields for this table */
  var $_data;

  /** @var boolean $_updated true if data has changed since loading */
  var $_updated = false;

  /** @var array $_changed a list of fields which have changed */
  var $_changed = array();


}

?>
