<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package DbTypeInfo */

class DbTypeInfo {

  /**
   * CONSTRUCTOR - load correct db type info from xml
   *
   * @param ZenDatabase $dbo is the database connection
   */
  function DbTypeInfo( $dbo ) { }

  /**
   * creates sql needed to drop a table
   *
   * @param string $table
   * @return array of sql statements
   */
  function _dropTableSyntax( $table ) { }

  /**
   * creates sql needed to add a table
   *
   * @params string $table
   * @return array of sql statements
   */
  function _addTableSyntax( $table ) { }

  /**
   * creates sql needed to drop a column
   *
   * @param string $table
   * @param string $column
   * @return array of sql statements
   * @return array of sql statements
   */
  function _dropColumnSyntax( $table, $column ) { }

  /**
   * creates sql needed to add a column
   *
   * @param string $table
   * @param string $name of column
   * @param string $type data type
   * @param string $unique (true or false)
   * @param integer $length (if applicable) of column
   * @param string $formtype field type in a form
   * @param string $description description of column
   * @param string $required (true or false)
   * @return array of sql statements
   */
  function _addColumnSyntax( $table, $name, $type, $unique, $length, $formtype, $description, $required ) { }

  /**
   * creates an index on a table for various columns
   *
   * @param string $name name of the index
   * @param string $table
   * @param array $columns
   * @param boolean $unique
   * @return array of sql statements
   */
  function _addIndexSyntax( $name, $table, $columns, $unique = false ) { }

  /**
   * drops an index on a table
   *
   * @param string $table
   * @param string $name name of the index
   */
  function _dropIndexSyntax( $table, $name ) { }

  /**
   * Parses xml data and loads properties for use
   */
  function _load() { }


  /*************************************
   **   SETTINGS
   ************************************/

  /** @var string $_delete specifies the delete prefix */
  var $_delete;

  /** @var string $_unique specifies the unique identifier */
  var $_unique;

  /** @var string $_uniqueindex specifies the unique index identifier */
  var $_uniqueindex;

  /** @var string $_primarykey specifies the primary key identifier */
  var $_primarykey;

  /** @var string $_datatypes specifies the properties for each data type */
  var $_datatypes;

?>
