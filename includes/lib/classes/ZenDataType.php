<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

/**
 *
 * The purpose of the ZenDataType object is to extract all common functionality between various
 * object types such as ZenTicket, ZenUser, ZenAction, ZenTrigger, etc.
 *
 * All Objects which directly correspond to a single data row in the db should extend this object.
 *
 * @package Zen
 */
class ZenDataType extends Zen {

  /**
   * CONSTRUCTOR - initialize Zen class and load data if appropriate
   *
   * @param integer $id the id to load
   * @param ZenList $zenlist (optional) passing this avoids a database call to load the object
   */
  function ZenDataType( $id, $zenlist = null ) { 
    $this->Zen();
    // set the params
    $this->_id = $id;
    $this->_table = ZenUtils::tableNameFromClass($this);
    $this->_primarykey = ZenUtils::getPrimaryKey( $this );
    // load the data
    if( $id && is_object($zenlist) ) {
      if( ZenUtils::tableNameFromClass($zenlist)!=$this->_table || !$this->_loadFromListData($zenlist,$id) ) {
        $this->debug($this,"ZenDataType","Unable to constuct this object from list type "
                     .class_name($zenlist),102,LVL_ERROR);
      }
      $this->debug($this, "ZenDataType", "Constructed object with id {$this->_id} from list data", 0, LVL_DEBUG);
    }
    else if( $id ) {
      $this->_load($id);
      $this->debug($this, "ZenDataType", "Constructed object with id {$this->_id} from database", 0, LVL_DEBUG);
    }
    $this->_id = $id;
    $this->_changed = false;
  }

  /**
   * Returns a ZenMetaTable object for this data type
   *
   * @return ZenMetaTable object containing meta info for this data type
   */  
  function getMetaInfo() { $this->getMetaData($this); }
  

  /*****************************
   * COMMON METHODS
   ****************************/

  /**
   * Get the id of this data type row
   *
   * @return integer
   */
  function id() { return $this->_id; }
  
  /**
   * tells whether a valid database entry is loaded in this object
   *
   * note that new objects return false(invalid) until save() has been called
   *
   * @return boolean contain a system ID
   */
  function loaded() { return ($this->_id > 0 && count($this->_fields)); }
  
  /**
   * Fetches a field in this object
   *
   * @param string $field the field name to fetch
   * @return mixed value of the field or false if the field is not valid
   */
  function getField( $field ) { return $this->_fields[$field]; }

  /**
   * Sets the value of a field
   *
   * This sets the $this->_changed flag to true if updated.
   *
   * The best method to check the return value for this would be as follows:
   * <code>
   * $returnValue = $zenDataTypeObject->setField($fieldName, $newValue);
   * if( is_boolean($returnValue) ) {
   *    print $returnValue === true? "Updated" : "Unchanged";
   * }
   * else {
   *    print "Error detected: $returnValue";
   * }
   * </code>
   * 
   * @param string $field the field to set
   * @param mixed $value the value to set
   * @return boolean true if updated, false if unchanged, or String containing validation error
   */
  function setField( $field, $value ) { 
    if( !isset($this->_fields[$field]) && $this->_id ) {
      $this->_debug($this,"setField","The field $field does not exist",122,LVL_ERROR);
      return "Field $field does not exist, unable to set";
    }
    
    // see if the value has changed
    if( isset($this->_fields[$field]) ) {
      if( $value == $this->_fields[$field] ) {
        return false;
      }
    }

    // validate the return value
    $mt = Zen::getMetaData($this->_table);
    $valid = $mt->validate($field, $value);
    if( $valid === true ) {
      // set the new value
      $this->_changed = true;
      $this->_fields[$field] = $value;
      return true;
    }
    else {
      // return the error
      return $valid;
    }
  }

  /**
   * Returns true if data has been modified since loading this data object
   */
  function isChanged() { return $this->_changed; }

  /**
   * Saves changes to database
   *
   * This should check all associated fields for obvious
   * validation issues and return false and set a message
   * if there is an integrity issue
   *
   * The data for the fields can be obtains from the getMetaData() method
   *
   * Most likely this will be overridden by several methods
   * This sets the $this->_changed flag to false upon completion
   *
   * @return boolean succeeded
   */
  function save() { 
    if( !$this->_changed ) {
      return false;
    }
    // create a query
    $query = $this->getNewQuery();
    // add the table
    $query->table( $this->_table );

    // add fields/values
    foreach($this->_fields as $k=>$v) {
      $query->field($k, $v);
    }
    // update if we have an id
    if( $this->_id ) {
      if( $query->update() ) {
        $this->_debug($this, "save", "updated ".$this->_table." record ".$this->_id, 00, LVL_NOTE);
        $this->_changed = false; 
      }
      else {
        $this->_debug($this, "save", "failed to update ".$this->_table." row ".$this->_id, 220, LVL_ERROR);
      }
    }
    // or insert
    else {
      $result = $query->insert();
      if( $result ) { 
        $this->_debug($this, "save", "created new ".$this->_table." row with id $result", 00, LVL_NOTE);
        $this->_changed = false; 
      }
      else {
        $this->_debug($this, "save", "failed to create ".$this->_table." entry", 220, LVL_ERROR);
      }        
    }
    return $result;
  }

  /**
   * Loads the Object from its corresponding db entry
   *
   * Only works if $this->_id has been set
   *
   * @param integer $id is the id to be loaded (stored in $this->_id on success)
   * @return boolean load succeeded, id was valid (actually returns $this->loaded())
   */
  function _load( $id ) {
    $vals = Zen::getDataRow( $this->_table, $this->_primaryKey, $id );
    if( !is_array($vals) || !count($vals) ) {
      ZenUtils::safeDebug($this, '_load', "Invalid id: $id", LVL_WARN);
      return false;
    }
    $this->_fields = $vals;
    return true;
  }

  /**
   * Static method to create a data type object from a data set provided by a ZenList class type
   *
   * This creates a data type from a ZenList data structure without requiring an additional
   * database call to load the object
   *
   * @param ZenList $zenlist is the ZenList (or subclass of) to abstract the data from
   * @param integer $id is the id to load (stored in $this->_id if successful)
   * @return boolean validated and loaded (true if the item is found in the list)
   */
  function _loadFromListData( $zenlist, $id ) { 
    $fields = $zenlist->findData($id);
    if( !is_array($fields) || !count($fields) ) {
      $class = get_class($zenlist);
      ZenUtils::safeDebug($this, '_load', "ID ($id) not in List ($class)", LVL_WARN);
      return false;
    }
    $this->_fields = $fields;
    return true;
  }

  /****************
   * VARIABLES
   ***************/

  /** @var integer $_id the id associated with this object (used by loaded() */
  var $_id = 0;

  /** @var string $_table the db table for this data type */
  var $_table;

  /** @var mixed $_fields are the fields of the current object */
  var $_fields = array();  

  /** @var ZenTriggerList $_triggers all triggers associated with this object */
  var $_triggers;

  /** @var boolean $_changed tells whether properties have been changed since last save */
  var $_changed;

  /** @var string $_primarykey the column used for a primary key by this data type */
  var $_primarykey;

}

?>
