<?
  /**
   * Holds the ZenRecord interface
   */
   
/**
 * Represents a single record from a database table and its column values.
 * Implementations of this interface allow for reading, modifying, and saving that data.
 */
interface ZenRecord {

  /** @return string the class name of this record type, for use in creating new instances */
  static function getDataType();
  
  /** @return string the database table name where this record is saved */
  static function getSourceTable();

  /** @return string the database field used to store the id of this record */
  static function getIdCol();
  
  /** @return mixed the database (string)field or (array)fields used to comprise a label for this record */
  static function getLabelCol();
  
  /** @return int the id of this record */
  function getId();
  
  /** @return string a descriptive label, such as a ticket title, user name, or bin name */
  function getLabel();
  
  /**
   * Set the value of a field. This will only cause the isChanged() method to
   * return true if the value actually changed.
   *
   * @param string $fieldName must exactly match the database column name
   * @param mixed $fieldValue must be the appropriate value for the column
   * @return true if field exists and value was valid, false otherwise
   */
  function setField( $fieldName, $fieldValue );
  
  /**
   * @param string $fieldName must exactly match the database column name
   * @return mixed a value of the type for the specified column
   */
  function getField( $fieldName );
  
  /**
   * @return true if all fields in this record contain valid values and it is
   * ready to save to the database
   */
  function isValid();
  
  /**
   * @return true if any values have changed since the record was loaded
   */
  function isChanged();
  
  /**
   * @return void if the record is valid and has been saved to the database. Returns
   * a string if an error occurs (containing a description of the error)
   */
  function save();
  
}


?>
