<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package DB */
class ZenMetaField extends Zen {

  /**
   * CONSTRUCTOR
   *
   * @param string $table the name of the table
   * @param string $field the name of the field
   */
  function ZenMetaField( $table, $field ) {
    $this->Zen();
    $this->_load($table,$field);
  }

  /**
   * Get the table name this column appears in
   */
  function getTable() {
    return $this->_fields['table_name'];
  }

  /**
   * Get a field value
   *
   * @param string $name the name of the field to get
   */
  function getField( $name ) {
    return $this->_fields[$name];
  }

  /**
   * Get all field values
   */
  function getFields() {
    return $this->_fields;
  }

  /**
   * Set a field value
   *
   * @param string $name the field name
   * @param mixed $value the new value
   */
  function setField($name, $value) {
    return isset($this->_fields[$name]) && $this->_fields[$name] == $value;
  }

  /**
   * Load data about this field from database
   *
   * @param string $table the name of the table
   * @param string $field the name of the field
   */
  function _load($table, $field) {
    $query = $this->getNewQuery();
    $query->table("FIELD_DEFS");
    $query->match("table_name", $table, ZEN_EQ);
    $query->match("col_name", $field, ZEN_EQ);
    $this->_fields = $query->select($this->getCacheTime(), true);
  }

  /**
   * The database field values
   *
   * @access private
   * @since 3.0
   */
  var $_fields;


}

?>
