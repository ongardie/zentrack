<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenCriteriaSet class. Requires ZenSearchParms.php and ZenParmList.php
 * @package Actions
 */

/**
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
    ZenUtils::prep("ZenSearchParms");
    ZenUtils::prep("ZenParmList");
    $this->_list = array();
    $this->_id = null;
    $this->_parms = null;
    $this->_props = array();
    if( $id ) {
      $this->_load($id);
    }
    else {
      foreach( Zen::getMetaData($this) as $field ) {
	$this->_props[$field] = null;
      }
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
    $this->_props = $query->selectRow( Zen::getCacheTime(), true );

    // create search parms to load the list with
    $searchParms = new ZenSearchParms();
    $searchParms->match('criteria_set_id', ZEN_EQ, $this->_id);

    // load the list of criteria    
    $query = Zen::getNewQuery();
    $query->table('CRITERIA');
    $query->search($searchParms);
    $query->sort('field_pri');
    $this->vals = $query->select( Zen::getCacheTime(), true );
    if( is_array($vals) && count($vals) ) {
      $ids = array();
      foreach($vals as $l) {
        $key = $l['criteria_id'];
        $this->_list[ $key ] = $l;
        $ids[] = $key;
      }
      $this->_loadParms($ids);
    }
    else {
      $this->_list = array();
      $this->_parms = null;
    }
  }

  /**
   * Creates a set of search params to be used for querying database based
   * on this criteria set.
   *
   * This method reads each criteria, extracting the table/field values from 
   * 1st parm (PARM.parm_cat1=table, PARM.parm_cat2=field) and tries to match this 
   * with the evaluated value of the second parm ({@link ZenParm::value()})
   * by means of the criteria operator (CRITERIA.field_comp).
   *
   * It then creates a search parm that emulates this set of properties.
   *
   * <b>Example:</b>
   * <pre>
   * parm1 contains 'parm_cat1'=>'TICKET', 'parm_cat2'=>'ticket_id'
   * parm2->value returns '29'
   * field_comp returns '<='
   * 
   * The search parms would include:
   *   match( 'ticket_id', '<=', 29, 'TICKET' )
   * </pre>  
   *
   * @return ZenSearchParms
   */
  function getSearchParms() {
    $parms = new ZenSearchParms();
    if( !count($this->_list) ) {
      ZenUtils::safeDebug($this, "getSearchParms", "List data not loaded", 161, LVL_ERROR);
      return $parms;
    }
    foreach( $this->_list as $key=>$elem ) {
      $p1 = $this->getParm($elem['criteria_id'], 1);
      if( $p1->source() == 'db' ) {
        // if there is an andor value, then this
        // is a grouping element
        if( $elem['grouping'] ) {
          // if there is an andor, then this
          // is the beginning of a new group
          if( $elem['grouping'] == '(' ) {
            $parms->startGroup($elem['andor']);
          }
          else {
            $parms->endGroup();
          }
          continue;
        }
        
        // determine if we match or exclude
        // based on this criteria
        $m = $elem['parm_exclude']? 'exclude' : 'match';

        // collect the parameters and set up the search parm
        $p2 = $this->getParm($elem['criteria_id'], 2);
        $parms->$m( $p1->getField('parm_cat2'), $elem['field_comp'], 
                    $p2->value(), $p1->getField('parm_cat1') );
      }
    }
    return $parms;
  }

  /**
   * Evaluate the criteria for this set, see if all conditions are met
   *
   * @param integer $criteria_id it null, all criteria are evaluated, otherwise, just this one
   * @return boolean true if criteria passes
   */
  function evaluate( $criteria_id = null ) {
    $list = $criteria_id? 
      array($this->getCriteriaElement($criteria_id)) : $this->_list;
    foreach($list as $key=>$val) {
      $res = false;
      $p1 = $this->getParm($elem['criteria_id'],1);
      $p2 = $this->getParm($elem['criteria_id'],2);
      $v1 = $p1->value();
      $v2 = $p2->value();
      switch( $val['field_comp'] ) {
      case ZEN_EQ:
        $res = $v1 == $v2;
      case ZEN_GT:
        $res = $p1->compare($p2) > 0;
      case ZEN_GE:
        $res = $p1->compare($p2) >= 0;
      case ZEN_LT:
        $res = $p1->compare($p2) < 0;
      case ZEN_LE:
        $res = $p1->compare($p2) <= 0;
      case ZEN_IN:
        $res = is_array($v2) && in_array($v1, $v2);
      case ZEN_CONTAINS:
        $res = !(strpos($v1, $v2) === false);
      case ZEN_BEGINS:
        $res = strpos($v1, $v2) === 0;
      case ZEN_ENDS:
        $res = strpos($v1, $v2) == (strlen($v1)-strlen($v2));
      }

      // invert results if we are looking for exclude
      if( $elem['field_exclude'] ) { $res = !$res; }

      //todo
      //todo
      //todo
      //todo make this use $elem['andor'] values somehow
      //todo
      //todo
      //todo
      //todo

      // return false if it doesn't pass
      if( !$res ) { return false; }      
    }
    return true;
  }

  /**
   * Returns criteria with the specified id
   *
   * @param integer $criteria_id
   */
  function getCriteriaElement( $criteria_id ) {
    if( !isset($this->_list[$criteria_id]) ) {
      ZenUtils::safeDebug($this, "getCriteriaElement", "Specified element ($criteria_id) not found", 105, LVL_WARN);
      return null;
    }
    return $this->_list[$criteria_id];
  }

  /**
   * Returns a parm from this criteria set
   * 
   * This method efficiently generates and stores parm data used by this CriteriaSet using
   * the ZenParmList to prevent several database queries.
   *
   * @param integer $criteria_id the criteria to get a parm for
   * @param integer $index the number (1-parm 1, 2-parm 2)
   * @return ZenParm or false if invalid
   */
  function getParm( $criteria_id, $index ) {
    $crit = $this->getCriteria($criteria_id);
    if( $crit ) {
      $id = $crit['parm_id_$index'];
      return $this->_parms->get($id);
    }
    else {
      return false;
    }
  }

  /**
   * Loads parm data, use on request, only after criteria is loaded.
   *
   * @access private
   */
  function _loadParms( $ids ) {
    $this->_parms = new ZenParmList();
    $this->_parms->criteriaIdArray($ids);
    $this->_parms->sort('parm_pri');
    $this->_parms->sort('parm_name');
    $this->_parms->load();
  }

  /**
   * Return all criteria entries in an array
   *
   * @return array containing each row of criteria
   */
  function getAllCriteria() { return $this->_list; }

  /**
   * Add a new criteria to the set
   *
   * The args must contain one of the two sets of data:
   * <li><b>Grouping Entry</b>
   * <ul>
   *   <li><b>grouping</b> - ( or )
   *   <li><b>andor</b> - if grouping is '(', this must be AND or OR
   *   <li><b>field_pri</b> - order to appear in criteria
   * </ul>
   * <li><b>Criteria Entry</b>
   * <ul>
   *   <li><b>parm_id_1</b> - the id of first parm to compare
   *   <li><b>parm_id_2</b> - the id of second parm to compare
   *   <li><b>field_comp</b> - comparison operator, see {@link ZenQuery.php}
   *   <li><b>field_exclude</b> - 1 or 0, if 1, then this match is exclusive (instead of inclusive)
   *   <li><b>field_pri</b> - order to apprear in criteria list
   *   <li><b>descript</b> - description of criteria
   * </ul>
   *
   * No validation is done on incoming field.  If these are incorrect, it will probably break things.
   *
   * @param array $args as described above
   * @return boolean
   */
  function addCriteria( $args ) {
    if( !$this->_id ) { 
      ZenUtils::safeDebug($this, "addCriteria", 
              "Tried to create criteria on a set which has not been saved!", 
              161, LVL_ERROR);
      return false; 
    }
    $args['criteria_set_id'] = $this->_id;
    return Zen::simpleInsert('CRITERIA',$args);
  }

  /**
   * Delete criteria from this set
   *
   * @param integer $criteria_id
   * @return boolean
   */
  function deleteCriteria( $criteria_id ) {
    if( !$this->_id || !isset($this->_list["$criteria_id"]) ) {
      ZenUtils::safeDebug($this, "deleteCriteria", "Criteria doesn't exist", 
                          105, LVL_ERROR);
      return false;
    }
    return Zen::simpleDelete('CRITERIA', 'criteria_id', $criteria_id);
  }

  /**
   * Update criteria for this set
   *
   * @param array $args updated array containing properties for criteria
   */
  function updateCriteria( $args ) {
    $id = $args['criteria_id'];
    if( !isset($this->_list["$id"]) || !$this->_id ) {
      ZenUtils::safeDebug($this, "updateCriteria", "Criteria doesn't exist", 
                          105, LVL_ERROR);
      return false;
    }
    $query = Zen::getNewQuery();
    $query->table('CRITERIA');
    $query->match('criteria_id',$id);
    foreach($args as $key=>$val) {
      $query->field($key, $val);
    }
    return $query->update();
  }

  /**
   * Set a property of this criteria set.  Valid properties are:
   * <ul>
   *   <li><b>field_name</b> - name of the criteria set
   *   <li><b>andor</b> - AND or OR, match method (any or all)
   *   <li><b>onfail</b> - if used for actions, do we skip this and
   *      continue with rest of the action elements or stop here?
   * </ul>
   *
   * The criteria_set_id cannot be altered.
   *
   * @param string $name name of property
   * @param mixed $value value of property
   * @return boolean true if property was updated
   */
  function setProperty( $name, $value ) {
    if( $name == 'criteria_set_id' || !isset($this->_props[$name]) ) {
      ZenUtils::safeDebug($this, "setProperty", "Invalid property", 
                          105, LVL_ERROR);
      return false;
    }
    $this->_props[$name] = $value;
    return true;
  }

  /**
   * Save the set properties to database
   *
   * This must be done on an empty Criteria Set before any criteria can be added.
   *
   * @return boolean
   */
  function save() {
    $query = Zen::getNewQuery();
    $query->table('CRITERIA_SET');
    $query->matchId($this->_id);
    foreach($this->_props as $key=>$val) {
      if( $key != 'criteria_set_id' ) {
        $query->field($key, $val);
      }
    }
    return $query->update();
  }

  /**
   * For actions, this property determines if the action should continue
   * on this failure (just skipping this specific element) or fail entirely.
   *
   * @return boolean
   */
  function onFail() { return $this->_props['onfail'] > 0? true : false; }

  /** @var integer $_id the id of this set */
  var $_id;
  
  /** @var array $_props the db fields for this set */
  var $_props;
  
  /** @var ZenCriteriaList $_list the list of criteria for this set */
  var $_list;

  /** @var ZenParmList $_parms a list of parms used by this criteria set */
  var $_parms;

}

?>
