<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * This is a base class to allow for retrieving lists of various things.  Several primary purposes
 * exist for this class: 
 * <ol>
 *  <li>Abstraction of redundant code for obtaining lists
 *  <li>Standardization of search procedures
 *  <li>(hopefully)get enough info in results to avoid producing a seperate object for each item
 *  <li>Provide methods for sorting results on the fly
 *  <li>Allow for possible serialization and passing between pages (reducing system load considerably)
 * </ol>
 *
 * This class should not be called, rather, it should be extended and used
 * by a child class.
 *
 * All child classes must define the ZenMetaTable object in their constructor
 *
 * @package Zen 
*/
class ZenList extends Zen {

  /**
   * CONSTRUCTOR
   *
   * This method recieves the ZenMetaTable object, and utilizes this to find out
   * which columns and tables are valid for use by this object. This allows for 
   * validation of the incoming params.
   *
   * @param ZenMetaTable $metainfo a ZenMetaTable object corresponding to this data type
   */
  function ZenList( $metainfo ) { 
    // get validation info

    // call Zen()

  }

  /**
   * Limits the results to the set of ids provided (a wrapper for doing criteria() for ticket ids)
   *
   * This also provides a quick means to get a list of data items from a list of ids
   *
   * @param array $ids a simple array of data rows that are to be included
   */
  function criteriaIdSet( $ids ) { }

  /**
   * sets search criteria for populating the list
   *
   * Must be called before load()
   * The operator can be any of the following:
   * <ul>
   *  <li>Contains: $value is a string to be matched
   *  <li>Begins: $value is a string to be matched
   *  <li>Ends: $value is a string to be matched
   *  <li>Equals: $value is a string to be matched
   *  <li>In: $value is an array of possible choices
   * </ul>
   * Any of the operators may be preceeded by a ! to indicate
   * not [condition].
   *
   * @param string $field the field to filter by
   * @param mixed $value the value to filter by
   * @param string $operator the operator to use
   */
  function criteria($field, $value, $operator = ZEN_EQ) { }

  /**
   * sets the method used to sort the results
   *
   * must be called before load()
   *
   * @param string $field the field to sort on
   * @param boolean $desc sort in reverse order?
   */
  function sort($field, $desc = false) { }

  /**
   * performs the match and loads results
   *
   * @param integer $limit is the maximum number to load
   * @param integer $offset is the offset to use (i.e. start with 10 instead of 1)
   * @return integer the number matched
   */
  function load($limit = 0, $offset = 0) { }

  /**
   * gets the next result in the list (essentially an iterator)
   *
   * @return ZenTicket object or false if no more results
   */
  function next() { }

  /**
   * Tells if there is another item in the list
   *
   * @return boolean there is another item after this one
   */
  function hasNext() { return($this->_position < $this->_count()); }

  /**
   * resets the list counter to the first result
   */
  function reset() { }

  /**
   * returns the number of items in the list
   */
  function count() { }

  /**
   * gets data from the database and loads it into $this->_rawdata
   *
   * This method also sets $this->_count and $this->_loaded
   *
   * @return integer number of records stored in $this->_rawdata
   * @private
   */
  function _loadRawData() { }

  /**
   * searches the rawdata for a specific ticket id and indexes all entries until it is found
   *
   * note that for retrieving several tickets at random from the raw data, this will produce
   * roughly a log*n algorithm, making for a fairly fast search pattern, since the first element will
   * take an average of n/2 cycles, and the second will take an average of n/4 cycles, etc.
   *
   * @param integer $id is the id to be found
   * @return Object of the type specified (see the extending class makeObject() method)
   */
  function find( $id ) {
    if( !is_array($this->_rawdata) ) {
      $this->debug($this, "find", "Return data is empty, cannot fetch ID $id", 2, 121);
      return false;
    }
    if( !$this->_data["$id"] ) {
      $key = ZenUtils::getPrimaryKey( ZenUtils::tableNameFromClass($this) );
      while( $vals = array_shift($this->_rawdata) ) {
        $n = $vals[$key];
        $this->_data["$n"] = $vals;
        if( $n == $id )
          return $this->_makeObject($vals);
      }
      $this->debug($this, "find", "ID $id was expected but not found in the list data", 2, 122);
      return false;
    }
    return $this->_data["$id"];
  }

  /**
   * Constructs a new data type object containing the data row requested
   *
   * @param insteger $id the row to return
   * @return ZenDataType of the data type comparable to this list
   */
  function _makeObject( $id ) {
    $n = $this->_datatype;
    return new $n( $id, $this );
  }


  /* VARIABLES */

  /** @var string $_datatype the data type class for this List type (set in constructor) */
  var $_datatype;

  /** @var string $_listtype the list object extending this List class (set in constructor) */
  var $_listtype;

  /** @var array $_rawdata the non-indexed data, straight from the db */
  var $_rawdata;

  /** @var integer $_thisid id of the currently indexed element */
  var $_thisid;

  /** @var string $_primarykey the column used as primary key for this data type */
  var $_primarykey;

  /** @var array $_data the indexed data set, populated on-demand by the get methods */
  var $_data;

  /** @var integer $_position the current position in the result list */
  var $_position = 0;

  /** @var integer $_count the number matched */
  var $_count = 0;

  /** @var boolean $_loaded whether load() has been called */
  var $_loaded = false;

  /** @var ZenMetaTable $_metainfo the ZenMetaTable object provided by the extending class */
  var $_metainfo;

  /** @var array $_columns is the list of valid columns, and their data types... provided by the constructor */
  var $_columns;

}

?>
