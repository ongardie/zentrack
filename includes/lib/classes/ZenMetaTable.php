<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package DB */
class ZenMetaTable extends Zen {

  /**
   * CONSTRUCTOR
   *
   * Loads all data for this table from the TABLE_DEFS and FIELD_DEFS
   * information tables
   *
   * @param string $table the database table to obtain meta data for
   */
  function ZenMetaTable( $table ) { }


  /********************
   ** Table Info
   *******************/

  /**
   * Returns the last time this table was updated
   */
  function lastUpdated() { }

  /**
   * Returns the version of this table
   */
  function getVersion() { }

  /**
   * Get all the columns from this table
   *
   * The list is cached the first time it is requested
   *
   * @return ZenMetaFieldList
   */
  function getAllFields() { }

  /**
   * Returns the properties for a specific column
   *
   * @param string $field name of the column
   * @return ZenMetaField
   */
  function getField( $field ) { }

  /**
   * Returns a complete list of all columns and their related form generating information
   *
   * @return array indexed by column name, containing each form related element
   */
  function getFormInfo() { }

  /**
   * Validates values in an indexed array
   *
   * @param array $values indexed array of column -> value
   * @return mixed true if successful or a ZenMessageList if not successful
   */
  function validateData( $values ) { }

  /**
   * Tells whether this table inherits from an abstract type
   *
   * @param string $type abstract table name
   * @return boolean yes or no
   */
  function inherits( $type ) { }


  /*********************
   * DETAIL COLUMN INFO
   ********************/

  /**
   * Returns form field data for a single column
   *
   * @param string $column the column to retrieve
   * @return array containing all form related data for this element
   */
  function getFormFieldInfo( $column ) { }

  /**
   * Tells whether a certain column is required
   * 
   * @param string $column the column name
   * @return boolen yes
   */
  function isRequired( $column ) { }  

  /**
   * Returns the data type of the column
   * 
   * @param string $column the column name
   * @return string data type
   */
  function columnType( $column ) { }  

  /**
   * Returns the max length of data in this column
   * 
   * @param string $column the column name
   * @return integer max length accepted
   */
  function maxLength( $column ) { }  

  /**
   * Returns the form field type for this column
   * 
   * @param string $column the column name
   * @return string form field type
   */
  function formFieldType( $column ) { }  

  /**
   * Validates a single column value
   * 
   * @param string $column the column name
   * @param mixed $value the value to be checked
   * @return boolean valid
   */
  function validateField( $column, $value ) { }  



  /******************
   * EDITING METHODS
   *****************/

  /**
   * Marks this table in the database as updated (as of now)
   */
  function markAsUpdated() { }

  /**
   * Sets the table's current version
   *
   * @param string $newversion the new version for the table
   * @return validated
   */
  function setTableVersion( $newversion ) { }

  /**
   * Sets a column property for this table
   *
   * Also marks this column as updated
   *
   * @param string $column name of the column to update
   * @param string $value the new value of the column
   */
  function setColumnProperty( $column, $value ) { }

  /**
   * Commits any changes to the database
   *
   * Note this will check the previous update times vs the new update times... only
   * records changed will be updated.  Any record time that doesn't match will return
   * an error (probably updated while user was entering form data)
   */
  function save() { }


  /****************
   **  INTERNAL
   ***************/

  /**
   * Loads information about this table from the table_defs table
   */
  function _load() { }

  /**
   * Loads the fields from the field_defs table
   */
  function _loadFields() { }


  /***************
   **  VARIABLES
   **************/

  /** @var string $_version the version of this table */
  var $_version;

  /** @var string $_name the name of this table */
  var $_name;

  /** @var array $_columns the list of columns and their data for this table (populated on request) */
  var $_columns;

}

?>
