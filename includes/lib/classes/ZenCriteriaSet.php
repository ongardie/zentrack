<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/*
 * Store criteria which can be used for searching data, setting up parameters, etc
 *
 * @package Actions
 */
class ZenCriteriaSet {

  /**
   * CONSTRUCTOR: create a ZenCriteriaSet, if an id is provided, it
   * will be loaded, otherwise the criteria set will be empty.
   *
   * @param integer $setId the criteria set id to load
   */
  function ZenCriteriaSet( $id = null ) {
    $this->_list = new ZenCriteriaList();
    if( $id ) {
      $this->_load($id);
    }
    else {
      $this->_id = null;
      $this->_props = array();
      foreach( Zen::getMetaData($this) as $field ) {
	$this->_props[$field] = null;
      }
      $this->_list = array();
    }
  }

  /**
   * Load the criteria information from database
   *
   * @param integer $id the id of this criteria set
   */
  function _load( $id ) {
    // get data for this set
    $this->_id = $id;
    $query = Zen::getNewQuery();
    $query->table( 'CRITERIA_SET' );
    $query->matchId($id);
    $this->_props = $query->selectRow( Zen::getCacheTime() );

    // create search parms to load the list with
    $searchParms = new ZenSearchParms();
    $searchParms->match('criteria_set_id', ZEN_EQ, $this->_id);

    // load the list of criteria    
    $query = Zen::getNewQuery();
    $query->table('CRITERIA');
    $query->search($searchParms);
    $rows = $query->select( Zen::getCacheTime() );
    if( count($rows) ) {
      foreach($rows as $r) {
	//todo
	//todo generate the information for this criteria entry
	//todo
	//todo
      }
    }
  }

  /**
   * Creates a set of search params to be used for querying database.
   *
   * Must method before using this.
   *
   * @return ZenSearchParms
   */
  function getSearchParms() {
    $parms = new ZenSearchParms();
    if( !isset($this->_list) ) {
      ZenUtils::safeDebug($this, "getSearchParms", "List data not loaded", 161, LVL_ERROR);
      return $parms;
    }
    $list->reset();
    while( $list->hasNext() ) {
      $p = $list->next();
      //todo
      //todo
      //todo read the param list and create a search parms set
    }
  }

  /**
   * Evaluate the criteria for this set, see if conditions are met
   *
   * @param integer $criteria_id it null, all criteria are evaluated, otherwise, just this one
   * @return boolean
   */
  function evaluate( $criteria_id = null ) {
    //todo
    //todo evaluate parms and determine
    //todo if conditions are met
    //todo
  }

  //todo: add a new criteria 

  //todo: delete a criteria

  //todo: update a criteria

  //todo: alter properties of this set

  //todo: save changes

  //todo: updated? list entries updated?

  /** @var integer $_id the id of this set */
  var $_id;
  
  /** @var array $_props the db fields for this set */
  var $_props;
  
  /** @var ZenCriteriaList $_list the list of criteria for this set */
  var $_list;

}

?>