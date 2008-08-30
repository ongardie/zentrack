<?php
/** Holds the ZenListBase abstract */
  
/**
 * Provides common methods for ZenList implementations. Classes extending this
 * one are responsible to build the $rawData list when constructed.
 */
abstract class ZenListBase implements ZenList {

  /**
   * @param string dataType value of self::getDataType() (can't call static inherited method from here)
   */
  function __construct($dataType) {
    $this->rawData = array();
    $this->cachedRecords = array();
    $this->dataType = $dataType;
    $this->sourceTable = call_user_func(array($dataType, "getSourceTable"));
    $this->idCol = call_user_func(array($dataType, "getIdCol"));
    $this->reset();
  }
  
  /** @return ZenRecord the next element in this list or false if there are no more elemnts */
  function next() {
    if( count($this->rawData) <= ++$this->idx ) { return false; }
    return $this->loadRecord($this->idx);
  }
  
  /** @return true if calling getNext() would return a valid element. */
  function hasNext() { return $this->idx < count($this->rawData)-1; }
  
  /** @return int number of elemetns in the list */
  function size() { return count($this->rawData); }
  
  /** 
   * Sets the internal pointer before the first element, so that calling getNext()
   * will return the first item in the list.
   */
  function reset() { $this->idx = -1; }
  
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
    if( array_key_exists("$id", $this->cachedRecords) ) { return $this->cachedRecords["$id"]; }
    
    // if the cache contains all records in raw data, there's nothing else to
    // look through
    if( count($this->cachedRecords) == count($this->rawData) ) { return null; }
    
    // if the pointer has been advanced, those records have already been cached,
    // so don't bother loading them. Just try and load ones that aren't already
    // in the cache
    for($i=$this->idx+1; $i < count($this->rawData); $i++) {
      $rec = $this->loadRecord($i);
      if( $rec->id() == $id ) { return $rec; }
    }
  }
    
  /**
   * Load a record, assuming it's not already cached, and return it
   * @param int $idx the index in rawData, not the id of the record
   * @return ZenRecord the newly loaded record or null if it isn't valid
   */
  private function loadRecord( $idx ) {
    if( count($this->rawData) <= $idx ) { return null; }
    $rec = $this->rawData[$idx];
    $id = $rec[$this->idCol];
    if( !array_key_exists("$id", $this->cachedRecords) ) {
      $type = self::getDataType();
      $this->cachedRecords["$id"] = new $type($rec);
    }
    return $this->cachedRecords["$id"];
  }

  /** @return true if any records have changed */
  function hasChanges() { die("not ready"); }
  
  /** @return false if all records could be saved successfully or an array, indexed by id, with a list of error messages for each record with errors */
  function save() { die("not ready"); }
  
  private $idCol;
  private $dataType;
  private $sourceTable;
  private $rawData;
  private $cachedRecords;

}

?>
