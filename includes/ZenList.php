<?
  /** Holds the ZenList interface */
  
/**
 * Defines a list of records from the database and common functions that
 * each list member is required to provide.
 */
interface ZenList {

  /** @return string type of objects contained in this list, such as ZenUser, ZenTicket, etc */
  static function getDataType();
  
  /** @return mixed the next element in this list or false if there are no more elemnts */
  function next();
  
  /** @return true if calling getNext() would return a valid element. */
  function hasNext();
  
  /** @return int number of elemetns in the list */
  function size();
  
  /** 
   * Sets the internal pointer before the first element, so that calling getNext()
   * will return the first item in the list.
   */
  function reset();
  
  /**
   * Retrieve a record using its id. The implementing class doesn't guarantee
   * this will be a fast operation, so avoid it in general.
   * @param int $id
   * @return mixed the record of type returned by getDataType() or false if it isn't in this list
   */
  function findRecord( $id );
  
  /** @return true if any records have changed */
  function hasChanges();
  
  /** @return false if all records could be saved successfully or an array, indexed by id, with a list of error messages for each record with errors */
  function save();

}

?>
