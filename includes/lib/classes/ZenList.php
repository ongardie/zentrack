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

    // todo set primarykey

    $this->_position = -1;
    $this->_count = -1;
  }

  /**
   * Limits the results to the set of ids provided (a wrapper for doing criteria() for ticket ids)
   *
   * This also provides a quick means to get a list of data items from a list of ids.  This method
   * and the {@link criteria()} method are mutually exclusive.
   *
   * @param array $ids a simple array of data rows that are to be included
   */
  function criteriaIdSet( $ids ) {
    $this->_criteria = new ZenSearchCriteria( 'OR' );
    $this->_criteria->match( $this->_primarykey, ZEN_IN, $ids );
  }

  /**
   * sets search criteria for populating the list
   *
   * @param ZenSearchParms $criteria
   * @return boolean
   */
  function criteria($criteria) { 
    if( is_a($criteria, "ZenSearchParms") ) {
      $this->_criteria = $criteria;
      return true;
    }
    return false;
  }

  /**
   * sets the method used to sort the results.  Multiple calls on this
   * method will sort on multiple fields, in the order they are set.
   *
   * must be called before load() or loadAll()
   *
   * @param string $field the field to sort on
   * @param boolean $desc sort in reverse order?
   */
  function sort($field, $desc = false) { }

  /**
   * Return a data row
   *
   * @param integer $id
   * @return Object of ZenDataType for this data or false if not found
   */
  function get($id) {
    return $this->_makeObject($id);
  }

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
   * @return ZenDataType object or false if no more results
   */
  function next() { 
    if( $position >= $this->_count ) { return false; }
    return($this->get( $this->_ids[ ++$this->_position ] ));
  }

  /**
   * Tells if there is another item in the list
   *
   * @return boolean there is another item after this one
   */
  function hasNext() { return($this->_position < $this->_count-1); }

  /**
   * resets the list counter to before the first entry
   */
  function reset() { 
    $this->_position = -1; 
    $this->_thisid = null;
  }

  /**
   * returns the number of items in the list
   */
  function count() { return $this->_count; }

  /**
   * searches the rawdata for a specific ticket id, meant for use by ZenDataType constructor only
   *
   * @param integer $id is the id to be found
   * @return array containing data for this row or false if id is invalid
   */
  function find( $id ) {
    if( !$this->_data["$id"] ) {
      $this->debug($this, "find", "ID $id was expected but not found in the list data", 122, LVL_WARN);
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

  /** @var array $_ids the ids, in order they were recieved from db */
  var $_ids;

  /** @var integer $_thisid id of the currently indexed element */
  var $_thisid;

  /** @var string $_primarykey the column used as primary key for this data type */
  var $_primarykey;

  /** @var array $_data the indexed data set */
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

  /** @var ZenSearchParms $_criteria search criteria for filtering db data */
  var $_criteria;

}

?>
