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
   * @param Object $child is a $this reference from the calling object
   * @param integer $id the id to load
   * @param ZenList $zenlist (optional) passing this avoids a database call to load the object
   */
  function ZenDataType( $id, $zenlist = null ) { 
    $this->Zen();
    // set the params
    $this->_id = $id;
    $this->_table = ZenUtils::tableNameFromClass($this);
    $this->_primarykey = ZenUtils::getPrimaryKey( $this->_table );
    // load the data
    if( $id && is_object($zenlist) ) {
      if( ZenUtils::tableNameFromClass($zenlist)!=$this->_table || !$this->_loadFromListData($zenlist,$id) ) {
        $this->debug($this,"ZenDataType","Unable to constuct this object from list type ".class_name($zenlist),102,1);
      }
    }
    else if( $id ) {
      $this->_load($id);
    }
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
   * This sets the $this->_changed flag to true
   * 
   * @param string $field the field to set
   * @param mixed $value the value to set
   * @return boolean validated and set
   */
  function setField( $field, $value ) { 
    if( !isset($this->_fields[$field]) && $this->_id ) {
      $this->_debug($this,"setField","The field $field does not exist",122,1);
      return false;
    }
    $this->_changed = true;
    return $this->_fields[$field] = $value;
  }

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
        $this->_debug($this, "save", "updated ".$this->_table." record ".$this->_id, 00, 1);
        $this->_changed = false; 
      }
      else {
        $this->_debug($this, "save", "failed to update ".$this->_table." row ".$this->_id, 220, 1);
      }
    }
    // or insert
    else {
      $result = $query->insert();
      if( $result ) { 
        $this->_debug($this, "save", "created new ".$this->_table." row with id $result", 00, 3);
        $this->_changed = false; 
      }
      else {
        $this->_debug($this, "save", "failed to create ".$this->_table." entry", 220, 1);
      }        
    }
    return $result;
  }

  /**
   * Fetches all triggers associated with this action
   *
   * @return ZenTriggerList containing all triggers associated with this action
   */
  function getTriggers() { 
    //todo
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
    $vars = $this->simpleQuery( $this->_table, $this->_primaryKey, $id );
    $this->_fields = $vars[0];
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
    $fields = $zenlist->find($id);
    if( is_array($fields) && count($fields) ) {
      $this->_fields = $fields;
      return true;
    }
    return false;
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
