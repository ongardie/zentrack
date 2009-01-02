<?
/** Holds the ZenRecordBase abstract */

/**
 * A common base class for implementations of ZenRecord, providing common
 * methods and utils. In addition to declaring the abstract method getColumnList(),
 * all implementations of this abstract will have to declare the interface methods:
 * <pre>
 * $this->_dataType; (class name for elements of this list)
 * static function getSourceTable(); - (string)table name in db
 * static function getIdCol();    - (string)field name containing primary key
 * static function getLabelCol(); - (string)field name or array of (string)field names for label of this data type
 * static function validFields() - array of (string)field names
 * function fieldProps($fieldName); array((string)type,(int)maxlength,(bool)required)
 * </pre>
 *
 * Most everything else should be covered by this abstract.
 */
class ZenRecordBase {
  
  /**
   * The column list is an array that defines all the properties of fields
   * in this record type, allowing this base class to perform most of the work
   * in a generic way...
   *
   * <p>column_name should exactly match the name of the column in the database.
   *
   * <p>The valid types for columns are:
   * <ul>
   *   <li>date - a valid date object (converted to an integer)
   *   <li>id - a numeric id value
   *   <li>email - a valid email address
   *   <li>alphanumeric - a string suitable for variable/file names
   *   <li>string - anything, format unchecked
   *   <li>int - an integer value
   *   <li>float - a decimal value
   *   <li>url - a valid http address
   *   <li>boolean - true or false (1/0 also accepted)
   * </ul>
   *
   * <p>The required parameter will prevent the field from being set to an empty
   * value. Note that for numbers this means that the value must be non-zero! Do
   * not ever mark the id field as required or it will be impossible to insert records.
   *
   * <p>Declare $this->_dataType before calling this
   *
   * @param int $id the id of this record or null for a new record
   * @param array $data assumed to be valid... if not provided, and $id is set, db is queried (could be expensive!)
   */
  function ZenRecordBase($id = null, $data = null ) {
    $this->_id = $id;
    $this->_columnList = call_user_func(array($this->_dataType, "validFields"));
    $this->_sourceTable = call_user_func(array($this->_dataType, "getSourceTable"));
    $this->_idCol = call_user_func(array($this->_dataType, "getIdCol"));
    $this->_changed = false;
    $this->_validationErrors = array();
    $this->_data = array();
    if( $data ) {
      foreach($data as $k=>$v) { $this->setField($k, $v); }
    }
    else if( $id ) {
      // we need to load our own data
      $this->load($id);
    }
    else {
      // this is a new object, no data to load
      foreach($this->_columnList as $c) { 
        $this->setEmptyValue($c); 
      }
    }
  }
  
  /** @return string representing class name of this instance */
  function getDataType() { return $this->_dataType; }

  /** @return int the id of this record */
  function getId() { return $this->getField($this->_idCol); }
  
  /** @return string a descriptive label, such as a ticket title, user name, or bin name */
  function getLabel() {
    $labelCol = call_user_func(array($this->_dataType, "getLabelCol"));
    if( is_array($labelCol) ) {
      $v = '';
      foreach($labelCol as $key) {
        $val = $this->getField($key);
        if( $v && strlen($val) ) { $v .= ", $val"; }
        else if( strlen($val) ) { $v .= $val; }
      }
      return $v;
    }
    else {
      return $this->getField($labelCol);
    }
  }
  
  /**
   * Set the value of a field. This will only cause the isChanged() method to
   * return true if the value actually changed. Note that the value is only set
   * if a valid value is provided. Otherwise it is ignored.
   *
   * @param string $fieldName must exactly match the database column name
   * @param mixed $fieldValue must be the appropriate value for the column
   * @return true if field set to valid value, false if invalid or field not found
   */
  function setField( $fieldName, $fieldValue ) {
    // test the value
    if( ($err = self::invalidValue($fieldName, $fieldValue, $this->fieldProps($fieldName)))
        !== false) {
      Zen::addDebug("ZenRecordBase::setField", $err, 1);
      return false;
    }
    
    // store the value
    $this->_data[$fieldName] = $this->formatValue($fieldName, $fieldValue);
    
    // set the changed flag
    $this->_isChanged = true;
    
    // clear validation errors on field if they exist
    if( array_key_exists($fieldName, $this->_validationErrors) ) {
      unset($this->_validationErrors[$fieldName]);
    }
  }
  
  /**
   * Formats a value based on the given data type. This does not validate the data
   * only ensures that it _becomes_ valid. You must validate it yourself before
   * using this method.
   *
   * @param string $column_type
   * @param mixed $fieldValue if null passed here, returns a default value
   * @return mixed a value suitable for db insertion
   * @static
   */
  function formatValue($fieldName, $fieldValue=null) {
    //todo: fix this? get rid of it?
    list($type, $maxlen, $required) = $this->fieldProps($fieldName);
    
    // check required fields
    if( $fieldValue !== true && !strlen($fieldValue) ) {
      return self::getEmptyValue($type);
    }
      
    // check the formatting matches the type specified
    switch($type) {
      case "alphanumeric":
        $val = Zen::checkAlphaNum($fieldValue);
        break;
      case "boolean":
        $fieldValue = $fieldValue? true : false;
        break;
      case "date":
        global $zen; //cheating
        $fieldValue = $zen->parseDate($fieldValue);
        break;
      case "email":
        $fieldValue = Zen::checkEmail($fieldValue);
        break;
      case "float":
        $neg = strpos($fieldValue, '-')===0;
        $fieldValue = Zen::checkNum($fieldValue, true);
        if( $neg ) { $fieldValue = 0 - $fieldValue; }
        break;
      case "int":
      case "id":
        $neg = strpos($fieldValue, '-')===0;
        $fieldValue = Zen::checkNum($fieldValue);
        if( $neg ) { $fieldValue = 0 - $fieldValue; }
        break;
      case "url":
        $fieldValue = Zen::checkUrl($fieldValue);
        break;
      case "string":
      default:
        break;
    }
    
    // check maximum length not exceeded
    if( $maxlen > 0 && strlen($fieldValue) > $maxlen ) {
      $fieldValue = substr($fieldValue, 0, $maxlen);
    }
      
    return $fieldValue;
  }
  
  /**
   * Return a suitable empty value for use with this field type
   *
   * @param string $fieldType
   * @static
   * @return mixed
   */
  function getEmptyValue($fieldType) {
    switch($fieldType) {
      case "boolean":
        return false;
        break;
      case "id":
      case "date":
      case "int":
        return 0;
        break;
      case "float":
        return 0.0;
        break;
      default:
        return null;
    }
  }
  
  /**
   * Set the value of a field to the appropriate null value based on field type.
   *
   * <p>Note that this is not intended for general use, since this method is called before the
   * class is fully initialized.
   *
   * <p>This method will set validation errors on any fields which are required, since
   * they are being set to an empty value for now. Thus, they must be set to a valid value
   * before a save can be attempted.
   * 
   * <p>Add a getDefaultValue() if more public applications of this logic are needed.
   *
   * @param string $fieldName is the db col from getColumnList()
   * @param array $type is the field properties from getColumnList()
   */
  function setEmptyValue( $fieldName, $type ) {
    $v = self::getEmptyValue($type);
    $notValid = self::invalidValue($fieldName, $v, $this->fieldProps($fieldName));
    if( $notValid ) { $this->_validationErrors[$fieldName] = $valid; }
    $this->_data[$fieldName] = $v;
  }
  
  /**
   * @param string $fieldName must exactly match the database column name
   * @return mixed a value of the type for the specified column
   * @return null if field doesn't exist
   */
  function getField( $fieldName ) {
    if( !array_key_exists($fieldName, $this->_data) ) {
      Zen::addDebug("ZenRecordBase::getField()", "Invlaid field requested ($fieldName)", 2);
      return null;
    }
    return $this->_data[$fieldName];
  }
  
  /**
   * @return mixed true if all fields in this record contain valid values and it is
   * ready to save to the database. Otherwise, this method returns an array of
   * error messages indicating the validation problems.
   */
  function isValid() {
    if( empty($this->_validationErrors) ) { return true; }
    return $this->_validationErrors;
  }
  
  /**
   * @return true if any values have changed since the record was loaded
   */
  function isChanged() { return $this->_changed; }
  
  /**
   * @return mixed (boolean)true if the record is valid and has been saved 
   * to the database. Returns an array if error(s) occurs (containing an
   * indexed array of fields and description of each error)
   */
  function save() {
    // we're just going to cheat here and call the global $zen object, since
    // we know that it must exist in the global scope for anything to run
    global $zen;
    
    // if nothing has changed, there's nothing to insert
    if( !$this->isChanged() ) { return array(tr("No values have changed, save skipped")); }
    
    // only try to insert valid data
    $valid = $this->isValid();
    if( $valid !== true ) { return $valid; }
    
    $table = $this->_sourceTable;
    $type = $this->_dataType;
    
    if( $this->_id == null ) {
      // this is a new record, insert it and set the id accordingly
      $id = $zen->db_insert($table,$this->_data);
      if( $id ) {
        $zen->addDebug("ZenRecordBase::save()", "New record of type $type created: $id", 3);
        $this->_id = $id; 
        return;
      }
      else {
        $zen->addDebug("ZenRecordBase::save()", "Could not insert a new record of type $type($table)", 1);
        return array(tr("Could not insert a new record of type ?", array($type))); 
      }
    }
    else {
      // this is an existing record, just update the values
      $zen->db_update( $table, $this->_idCol, $this->_id, $this->_data );
      if( $id ) {
        $zen->addDebug("ZenRecordBase::save()", "Updated record: $type($id)", 3);
        $this->_id = $id;
        return;
      }
      else {
        $zen->addDebug("ZenRecordBase::save()", "Could not update record $type($id)", 1);
        return array(tr("Could not update record with id ? of type ?", array($id, $type))); 
      }
    }
  }
  
  /**
   * Load a record from the database, reset the changed flag. Data
   * is assumed to be valid. This does not set the id field, it assumes
   * that is done already (you can use this to copy records)
   *
   * @param int $id must be a valid record id
   * @return boolean true if query succeeded
   * @protected don't call this directly, call the extending class!
   */
  function load($id) {
    $this->_isChanged = false;
    $id = Zen::checkNum($id);
    $query = "SELECT * FROM {$this->_sourceTable} WHERE {$this->_idCol} = $id";
    $vals = $this->db_quickIndexed($query);
    if( !empty($vals) ) { 
      $this->_data = $vals;
      return true;
    }
    else {
      $this->_data = array();
      return false;
    }
  }

  
  /**
   * @param string $fieldName
   * @param mixed $fieldValue
   * @param array $fieldProps pass props for column here, see $columnList in the constructor for format
   * @return false if the value provided is valid and can be saved into the field
   * specified. If not, provides a string with the error message.
   * @static
   */
  function invalidValue($fieldName, $fieldValue, $fieldProps) {
    //todo: fix this? get rid of it?
    list($type, $maxlen, $required) = $fieldProps;

    // check required fields
    if( $required && !strlen($fieldValue) ) { return tr("Required field was empty"); }
    
    // check maximum length not exceeded
    if( $maxlen > 0 && strlen($fieldValue) > $maxlen ) { return tr("Value cannot be longer than ? characters", array($maxlen)); }
      
    // don't bother validating empty values if not required
    if( !strlen($fieldValue) && $fieldValue !== true ) { 
      return $required? tr("Required field, cannot be empty") : false;
    }
      
    // check the formatting matches the type specified
    switch($type) {
    case "alphanumeric":
      $val = Zen::checkAlphaNum($fieldValue);
      if( $val === false || $val !== $fieldValue ) {
        return tr("Value may only contain these characters: 0-9, a-z, A-Z, or \"_\"");
      }
      break;
    case "boolean":
      if( !is_bool($fieldValue) && $field !== 0 && $field !== 1 ) { 
        return tr("Not a valid boolean value"); 
      }
    case "date":
      global $zen; //cheating
      if( preg_match("@^[0-9]+$@", $fieldValue) ) { return false; }
      else if( $zen->parseDate($fieldValue) <= 0 ) { return tr("Not a valid date"); }
    case "email":
      if( Zen::checkEmail($fieldValue)===false ) {
        return tr("Value is not a valid email address");
      }
      break;
    case "float":
      if( !preg_match("@^-?[0-9.]+$@", $fieldValue) ) { return tr("Only digits 0-9, decimal, and "-" allowed"); }
      break;
    case "int":
    case "id":
      if( $required && SfieldValue < 1 ) { return tr("Value is required; must be greater than zero"); }
      if( !preg_match("@^-?[0-9]+$@", $fieldValue) ) { return tr("Only digits 0-9 allowed"); }
      break;
    case "url":
      if( Zen::checkUrl($fieldValue) === false ) {
        return tr("Value is not a proper url");
      }
      break;
    case "string":
      return false;
    default:
      return tr("Invalid data type specified");
    }
    return false;
  }
  
  var $_columnList;
  var $_dataType;
  var $_sourceTable;
  var $_idCol;
  
  /** @var int the id of this record, null for new records (until they are saved) */
  var $_id;
  
  /** 
   * @var array the values for each field, in a keyed array: (string)column_name => (mixed)value
   * Generally, one wouldn't want to modify this directly, since the isChanged()
   * might become out of sync. Generally one would call setField() instead.
   */ 
  var $_data;
  
  /** @var boolean true if any value has changed since the initial load */
  var $_changed;
  
  /** 
   * @var array when empty, this class is in a valid state, when not empty, this is
   * a list of the error conditions. These are set and cleared each time setField()
   * is called, rather than waiting until a save or called to isValid() is requested.
   */
  var $_validationErrors;
  
}

?>
