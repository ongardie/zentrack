<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * Store properties for a field in the database
 *
 * @package DB
 */
class ZenMetaField extends Zen {

  /**
   * CONSTRUCTOR
   *
   * @param array $data is the schema array obtained from {@link ZenDbSchema::getColumnArray()} 
   *   or null (for empty object)
   */
  function ZenMetaField( $data = null ) {
    // call Zen()
    $this->Zen();
    if( is_array($data) ) {
      $this->_load( $data );
    }
    else {
      Zen::debug('ZenMetaField','ZenMetaField','No data provided, initializing empty field',
                 0,LVL_DEBUG);      
    }
  }

  /**
   * Copy another field.  This field will not be marked as updated.
   *
   * @param ZenMetaField $field the field to copy
   * @return boolean valid ZenMetaField provided
   */
  function copy( $field ) {
    if( !is_object($field) || get_class($field) != "ZenMetaField" ) { 
      Zen::debug($this,'copy','Param was not a valid ZenMetaField object', 105, LVL_ERROR);      
      return false; 
    }
    $this->_data = $field->getFieldArray();
    $this->_updated = true;
    return true;
  }  

  /**
   * Load data into schema
   *
   * @param array $data
   * @access private
   */
  function _load( $data ) {
    foreach($this->listProperties() as $d) {
      $this->_data[$d] = isset($data[$d])? $data[$d] : null;
    }
  }

  /**
   * Returns a property of this field
   *
   * @param string $property
   * @return mixed
   */
  function getProp( $property ) {
    if( !$this->isProperty($property) ) {
      ZenUtils::safeDebug($this, "getProp", "Requested invalid property: $property", 105, LVL_WARN);
      return null;
    }
    return $this->_data[$property];
  }

  /**
   * Sets a property of this field
   *
   * @param string $property
   * @param mixed $value
   * @return boolean
   */
  function setProp( $property, $value ) {
    if( !$this->isProperty($property) ) {
      Zen::debug($this,'setProp','Not a property: $property', 105, LVL_WARN);      
      return false;
    }
    if( $this->immutable($property) ) {
      ZenUtils::safeDebug($this, 'setProp', "Property $property cannot be edited", 105, LVL_WARN);
      return false;
    }
    $this->_updated = true;
    $this->_data[$property] = $value;
    return true;
  }

  /**
   * Returns an array containing all properties for this field
   *
   * @return array
   */
  function getFieldArray() { return $this->_data; }

  /**
   * Returns the name of this field
   *
   * @return string
   */
  function name() { return $this->getProp('name'); }

  /**
   * Returns the table of this field
   *
   * @return string
   */
  function table() { return $this->getProp('table'); }

  /**
   * Returns the data type of this field
   *
   * @return string
   */
  function dataType() { return $this->getProp('type'); }

  /**
   * Returns the form type of this field
   *
   * @return string
   */
  function formType() { return $this->getProp('ftype'); }

  /**
   * Tells if this is a custom(user defined) field
   *
   * @return boolean
   */
  function isCustom() { return $this->getProp('custom'); }

  /**
   * Tells if this field is required
   *
   * @return boolean
   */
  function isRequired() { 
    return $this->getProp('required') || 
      ($this->getProp('notnull') && !strlen($this->getProp('default'))); 
  }

  /**
   * Tells if this field has been updated since loading
   *
   * @return boolean
   */
  function updated() { return $this->_updated; }

  /**
   * Sets the status to updated although this field hasn't been changed since loading
   *
   * This is useful when the data has changed before the object was constructed
   */
  function forceChanged() { $this->_updated = true; }

  /**
   * Saves any changes to this field to database
   *
   * @return integer rows affected
   */
  function save() {
    if( !$this->_updated ) { 
      Zen::debug($this, 'save', 'Attempted to save field, but has not changed', 161, LVL_WARN);
      return false; 
    }
    $query = Zen::getNewQuery();
    $query->table( 'FIELD_DEFS' );
    foreach( $this->_data as $k=>$v ) {
      if( $k == 'criteria' ) {
        $v = is_array($v)? join("=",$v) : null;
      }
      if( !$this->immutable($k) ) {
        $query->field( ZenMetaDb::mapFieldPropToDb($k), $v );
      }
    }
    $query->match( 'col_table', ZEN_EQ, $this->table() );
    $query->match( 'col_name', ZEN_EQ, $this->name() );
    $res = $query->update();
    if( $res ) { $this->_updated = false; }
    Zen::debug($this, 'save', $this->name().": [$res] '".$query->getQueryString()."'", 0, LVL_DEBUG);
    return $res? true : false;
  }

  /**
   * Determine if value provided is valid for db insertion.
   *
   * It is important to note the possible return values when checking the return code
   * from this function.
   *
   * @param mixed $value
   * @return mixed true if ok or a string containing the error
   */
  function validate( $value ) {
    // check empty vals
    if( $this->isRequired() && !strlen($value) ) {
      return "Field required";
    }
    else if( !strlen($value) ) {
      return true;
    }
    
    // check for unique constraints
    if( $this->getProp('unique') && strlen($value) ) {
      $query = Zen::getNewQuery();
      $query->table( $this->table() );
      $query->match( $this->name(), ZEN_EQ, $value );
      if( $query->count() > 0 ) {
        return "Is not unique";
      }
    }

    // check data type
    // no need to check strings
    switch( $this->dataType() ) {
    case "shortint":
    case "integer":
    case "long":
    case "primarykey":
    case "byte":
      if( !is_numeric($value) || !preg_match("/^[0-9-]+$/", $value) ) { return "Not an integer"; }
      break;
    case "decimal":
      if( !is_numeric($value) || !preg_match("/^[0-9.-]+$/", $value) ) { return "Not a decimal number"; }
      break;
    case "email":
      if( !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z][0-9a-z.-]*[0-9a-z]\.)+[a-z]{2,3}$/i", $value) )
        return "Not an email address";
      break;
    }
    return true;
  }

  /**
   * Determine if a particular field property is immutable (cannot be edited)
   *
   * @param string $property
   * @return boolean
   */
  function immutable( $property ) {
    switch( $property ) {
    case 'ftype':
    case 'criteria':
    case 'reference':
    case 'showfield':
    case 'required':
    case 'unique':
      return $this->isCustom()? false : true;
    case 'order':
    case 'label':
    case 'default':
    case 'description':
      return false;
    default:
      return true;
    }
  }

  /**
   * List the available field properties
   *
   * @static
   */
  function listProperties() { 
    return array('name','label','size','type','ftype','notnull',
                 'required','criteria','reference','default','description',
                 'custom','order','table','unique','showfield');
  }

  /**
   * Determine if the given property is a valid ZenMetaField property
   *
   * @static
   * @param string $property
   * @return boolean
   */
  function isProperty( $property ) {
    return in_array( $property, ZenMetaField::listProperties() );
  }

  /* VARIABLES */

  /** @var array $_data The data contained in this field */
  var $_data;
  
  /** @var boolean $_updated true if this field has changed since loading */
  var $_updated = false;

}

?>
