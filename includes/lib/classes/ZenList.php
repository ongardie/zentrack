<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenList class.  Requires Zen.php
 * @package Zen
 */

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
 * The basic way to employ this class is to create an instance of a class which extends this
 * one, use the various criteria methods and sort to determine contents and order of the list,
 * then call {@link load()} to prepare the data.  Once the data is prepared, the {@link next()},
 * {@link hasNext()}, {@link reset()}, and {@link count()} methods can be used to iterate
 * through the elements of the list.
 *
 * If this constructor is called a super, there is no need to call the load()
 * method.  However, if this class is initiated directly instead of through
 * a child class, you must call the load() method.
 *
 * @package Zen 
*/
class ZenList extends Zen {

  /**
   * CONSTRUCTOR
   *
   * If this constructor is called a super, there is no need to call the load()
   * method.  However, if this class is initiated directly instead of through
   * a child class, you must call the load() method.
   * 
   * This method recieves the ZenMetaTable object, and utilizes this to find out
   * which columns and tables are valid for use by this object. This allows for 
   * validation of the incoming params.
   */
  function ZenList() { 
    // call Zen()
    $this->Zen();

    // initialize params
    $this->_criteria = null;
    $this->_sortCriteria = array();
    $this->_data = null;
    $this->_position = -1;
    $this->_count = -1;
    $this->_loadParms = array(0,0);

    // call the load method if we inherited a usable data type
    $data_type = get_class($this);
    if( strtolower($data_type) != "zenlist" ) {
      $this->loadAbstract($data_type);
    }

  }

  /**
   * Load the data type information manually (used if this class is called directly
   * instead of using an inherited class)
   *
   * @param string $data_type the inherited ZenDataType for this class
   */
  function loadAbstract( $data_type ) {
    // find the meta info
    $this->_dataType = preg_replace('/List$/', '', $data_type);
    $this->_table = ZenUtils::tableNameFromClass($data_type);
    $this->_metaTable = Zen::getMetaData($this);

    /** @var integer $_thisid id of the currently indexed element */
    $this->_thisid = null;

    /** @var string $_primarykey the column used as primary key for this data type */
    $this->_primarykey = ZenUtils::getPrimaryKey( $data_type );
  }

  /**
   * Limits the results to the set of ids provided (a wrapper for doing criteria() for ticket ids)
   *
   * This also provides a quick means to get a list of data items from a list of ids.  This method
   * and the {@link criteria()} method are mutually exclusive.
   *
   * @param array $ids a simple array of data rows that are to be included
   * @param boolean $sortby if true, then results will be sorted by this id list instead of sort parms
   */
  function criteriaIdArray( $ids, $sortby = false ) {
    ZenUtils::prep("ZenSearchParms");
    $this->_criteria = new ZenSearchParms( 'OR' );
    $this->_criteria->match( $this->_primarykey, ZEN_IN, $ids );
    if( $sortby ) { $this->_sortByIds = $ids; }
  }

  /**
   * Use an existing criteria set to search for matches to be added to this list
   *
   * @param integer $setId the id of the criteria set to load
   * @return boolean
   */
  function criteriaSetId( $setId ) {
    ZenUtils::prep("ZenCriteriaSet");
    $set = new ZenCriteriaSet($setId);
    return $this->criteria( $set->getSearchParms() );
  }

  /**
   * sets search criteria for populating the list
   *
   * @param ZenSearchParms $criteria
   * @return boolean
   */
  function criteria($criteria) { 
    if( ZenUtils::instanceOf("ZenSearchParms", $criteria) ) {
      $this->_criteria = $criteria;
      return true;
    }
    return false;
  }

  /**
   * Sets the method used to sort the results.  Multiple calls on this
   * method will sort on multiple fields, in the order they are set.
   *
   * If $fields is an array, it is mapped (string)field->(boolean)descending.
   * For instance, if you want to sort a table on name ASC, id DESC, you
   * would use array( "name"=>false, "id"=>true )
   *
   * <b>Must be called before load() or loadAll()</b>
   *
   * @param mixed $fields associative array of fields/method or (string)field_name
   * @param boolean $reverse if $fields is a string and this is true, sort in descending order
   */
  function sort($fields, $reverse = false) {
    if( !is_array($fields) ) {
      $fields = array($fields => $reverse);
    }
    foreach($fields as $k=>$v) {
      $this->_sortCriteria["$k"] = $v;
    }
  }

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
   * performs the match and loads results.  
   *
   * If this class is being used directly (i.e. not an inherited class) the 
   * loadAbstract() method must be called before attempting to use this.
   *
   * @param integer $limit is the maximum number to load
   * @param integer $offset is the offset to use (i.e. start with 10 instead of 1)
   * @return integer the number matched
   */
  function load($limit = 0, $offset = 0) {
    // do not load the list multiple times, unless the limit and offset
    // have changed
    if( $this->isLoaded() && ZenUtils::arrayEquals($this->_loadParms, array($limit,$offset)) ) {
      return count($this->count());
    }

    // store the parms for use later
    $this->_loadParms = array($limit,$offset);

    if( !$this->_table ) {
      $this->debug($this, "load", 
                   "The list has not been properly initialized (probably need to call loadAbstract)", 
                   161, LVL_ERROR);
      return false;
    }

    // initialize our data query
    $query = Zen::getNewQuery();
    $query->table( $this->_table );

    // create search and sort criteria
    if( $this->_criteria ) {
      $query->search($this->_criteria);
    }
    if( count($this->_sortCriteria) ) {
      foreach($this->_sortCriteria as $field=>$desc) {
        $query->sort($field, $desc);
      }
    }

    // generate data
    $ids = array();
    $this->_data = array();
    $rows = $query->select(Zen::getCacheTime(),true);
    if( is_array($rows) ) {
      $this->_count = count($rows);
      foreach($rows as $r) {
        $key = $this->getPrimaryKey();
        $id = $r[ $key ];
        $ids[] = $id;
        $this->_data["$id"] = $r;
      }

      // resort the ids if necessary
      if( $this->_sortByIds ) {
        // we will take the existing
        // ids and resort them
        $keys = $ids;
        $ids = array();
        
        // iterate through the ids and
        // order result accordingly
        foreach($this->_sortByIds as $id) {
          if( in_array($id, $keys) ) {
            $ids[] = $key;
          }
        }
      
        // any values left over should
        // just be appended to the end
        // (hopefully this doesn't happen)
        foreach($keys as $id) {
          if( !in_array($id, $ids) ) {
            $ids[] = $id;
          }
        }
      }
    }

    // assign sorted ids
    $this->_ids = $ids;

    // reset some params
    $this->_count = count($this->_data);
    $this->_loaded = true;
    $this->_position = 0;
    return $this->count();
  }

  /**
   * gets the next result in the list (essentially an iterator)
   *
   * @return ZenDataType object or false if no more results
   */
  function next() { 
    if( $this->_position >= $this->_count ) { return false; }
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
   * Returns a list of ids (in sorted order) contained in this list.
   *
   * Normally, you will simply want to use the hasNext() and next() methods.
   *
   * @return array contains (integer)id elements
   */
  function listIds() { return $this->_ids; }

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
  function findData( $id ) {
    if( !isset($this->_data["$id"]) ) {
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
    $n = $this->getDataType();
    if( class_exists($n) 
        && ZenUtils::tableNameFromClass($this) != "" ) {
      return new $n( $id, $this );
    }
    else {
      return ZenDataType::abstractDataType($this->_table, $id, $this);
    }
  }

  /**
   * Get the primary key for the table associated with this List
   *
   * @return String primary key field name
   */
  function getPrimaryKey() {
    return $this->_primarykey;
  }
  
  /**
   * Get the data type (class name) this List is responsible for
   * (the class is not guaranteed to exist)
   *
   * @return string
   */
  function getDataType() {
    return $this->_dataType;
  }

  /**
   * Get the source table this list recieves data from
   */
  function getTable() {
    return $this->_table;
  }

  /**
   * Returns true if this list has been loaded and is ready for use
   *
   * @return boolean
   */
  function isLoaded() { return $this->_loaded; }

  

  /* VARIABLES */

  /** @var String $_dataType the source type for this List */
  var $_dataType;

  /** @var String $_table the source table for this List */
  var $_table;

  /** @var array $_ids the ids, in order they were recieved from db */
  var $_ids;

  /** @var integer $_thisid id of the currently indexed element */
  var $_thisid;

  /** @var string $_primarykey the column used as primary key for this data type */
  var $_primarykey;

  /** @var array $_data the indexed data set, this data is not necessarily sorted, the ids are used for this */
  var $_data;

  /** @var integer $_position the current position in the result list */
  var $_position = 0;

  /** @var integer $_count the number matched */
  var $_count = 0;

  /** @var boolean $_loaded whether load() has been called */
  var $_loaded = false;

  /** @var array $_loadParms [0]-limit, [1]-offset; stored for determining if loaded data needs recalculation */
  var $_loadParms;

  /** @var ZenMetaTable $_metaTable the ZenMetaTable object provided by the extending class */
  var $_metaTable;

  /** @var ZenSearchParms $_criteria search criteria for filtering db data */
  var $_criteria;

  /** @var array $_sortCriteria array containing array( (String)field, (boolean)descending ) elements */
  var $_sortCriteria;

  /** @var array $_sortByIds if set, this list of ids will be used to sort results, instead of sort parms */
  var $_sortByIds = null;

}

?>
