<?php
/** Holds the ZenListBase abstract */
  
/**
 * Provides common methods for ZenList implementations. Extending classes
 * are required to implement the following:
 * <ul>
 *   <li><b>getSourceTable()</b> - the db table used by this list type
 *   <li><b>getIdCol()</b> - the primary key column in the table
 *   <li><b>$this->_dataType</b> - the type of object stored in list, such as ZenTicket
 *   <li><b>listFields()</b> - returns a list of valid db columns for this data type
 *   <li><b>columnType()</b> - returns the db column type for the field specified
 * </ul>
 *
 * Extending classes may choose to override any other public method in this class
 * as needed, though mostly it will just work with the above in place.
 *
 * @abstract
 */
class ZenListBase {

  /**
   * Initialize the list, declare $this->_dataType before calling this
   */
  function ZenListBase() {
    $this->_rawData = array();
    $this->_cachedRecords = array();
    $this->_changedRecords = array();
    $this->_sourceTable = call_user_func(array($this->_dataType, "getSourceTable"));
    $this->_idCol = call_user_func(array($this->_dataType, "getIdCol"));
    $this->reset();
  }
  
  /**
   * Given a set of values to search on, loads data into the list
   *
   * @param array $search_parms see description above
   * @param array $limit specify how many results should be loaded into the list (findRecord() may not work with this)
   * @param array $offset if using $limit, this tells us where to start retrieving
   * @return int number of records loaded
   */
  function load($search_parms, $limit=0, $offset=0) {
     $this->_isChanged = false;
     
     //todo
     //todo
     //todo
     //todo
     die("not ready");
  }
  
  /** @return ZenRecord the next element in this list or false if there are no more elemnts */
  function next() {
    if( !$this->hasNext() ) { return false; }
    ++$this->_idx;
    return $this->_loadRecord($this->_idx);
  }
  
  /** @return true if calling getNext() would return a valid element. */
  function hasNext() { return count($this->_rawData) > $this->_idx+1; }
  
  /** @return int number of elemetns in the list */
  function size() { return count($this->_rawData); }
  
  /** 
   * Sets the internal pointer before the first element, so that calling getNext()
   * will return the first item in the list.
   */
  function reset() { $this->_idx = -1; }
  
  function columnType($columnName) { 
    $props = call_user_func($this->_dataType, "fieldProps");
    return $props['type'];
  }
  
  /**
   * Retrieve a record using its id. This operation is much faster once the list has
   * been iterated. It often requires iterating the entire list at least once to
   * prepare the records, but should provide fairly fast lookups once the list
   * has been loaded.
   *
   * If an id is not in the list, this will provide a very slow lookup. So this shouldn't
   * ever be used to test for the existence of a record.
   *
   * @param int $id
   * @return ZenRecord the record of type returned by getDataType() or null if it isn't in this list
   */
  function findRecord( $id ) {
    // first, look in the cached records and see if it is already loaded.
    if( array_key_exists("$id", $this->_cachedRecords) ) { return $this->_cachedRecords["$id"]; }
    
    // if the cache contains all records in raw data, there's nothing else to
    // look through
    if( count($this->_cachedRecords) == count($this->_rawData) ) { return null; }
    
    // if the pointer has been advanced, those records have already been cached,
    // so don't bother loading them. Just try and load ones that aren't already
    // in the cache
    for($i=$this->_idx+1; $i < count($this->_rawData); $i++) {
      $rec = $this->_loadRecord($i);
      if( $rec->id() == $id ) { return $rec; }
    }
  }
    
  /**
   * Load a record, assuming it's not already cached, and return it
   * @param int $idx the index in rawData, not the id of the record
   * @return ZenRecord the newly loaded record or null if it isn't valid
   */
  function _loadRecord( $idx ) {
    if( count($this->_rawData) <= $idx ) { return null; }
    $rec = $this->_rawData[$idx];
    $id = $rec[$this->_idCol];
    if( !array_key_exists("$id", $this->_cachedRecords) ) {
      $type = $this->_dataType;
      $this->_cachedRecords["$id"] = new $type($id, $rec);
    }
    return $this->_cachedRecords["$id"];
  }

  /** @return true if any records have changed */
  function hasChanges() { 
    return count($this->_changedRecords) > 0;
  }
  
  /** @return false if all records could be saved successfully or an array, indexed by id, with a list of error messages for each record with errors */
  function save() { 
     //todo
     //todo
     //todo
     //todo
     //todo
    die("not ready"); 
  }
  
  var $_idCol;
  var $_dataType;
  var $_sourceTable;
  var $_rawData;
  var $_cachedRecords;
  var $_changedRecords;
  var $_idx;

}

?>
