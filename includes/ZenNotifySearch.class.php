<?

/**
 * ZenNotifySearch object contains a user, company, employee, or notify
 * recipient
 *
 * Note that there is no way to load data into this class. It is read only.
 *
 * @abstract
 */
class ZenNotifySearch extends ZenNotifyRecipient {
  
  /**
   * Default constructor, included here so that implementing classes can
   * call the super method (in case we decide to put something here later)
   */
  function ZenNotifySearch( $id = null, $data = null ) {
    $this->_dataType = "ZenNotifySearch";
    $this->ZenRecordBase($id, $data);
  }
  
  function validFields() {
    $f = parent::validFields();
    $f[] = "type";
    $f[] = "text";
    return $f;
  }
  
  function fieldProps($columnName) {
    if( $columnName == 'type' ) { return array("alphanumeric",50,false); }
    else if( $columnName == 'text' ) { return array('string',0,false); }
    else if( strpos($columnName, "_id") > 0 ) {
      return array("id", 50, false);
    }
    return parent::fieldProps($columnName);
  }  
  
  function createDataArray() { return $this->_data; }
  
  function save() { die("This data type is read only, save not allowed"); }
}


/**
 * A list of possible notify recipients retrieved from company, employee, or zt
 * user tables via name or email address.
 */
 class ZenNotifySearchList extends ZenListBase {
   
   function ZenNotifySearchList() {
     $this->_dataType = "ZenNotifySearch";
     $this->ZenListBase();
   }
   
  function getSourceTable() { return ZenNotifySearch::getSourceTable(); }
  function getIdCol() { return ZenNotifySearch::getIdCol(); }
  function validFields() { return ZenNotifySearch::validFields(); }
  
  /**
   * Override the load method; we're going to search several tables rather
   * than the normal behavior
   *
   * @param array $args according to contract, but only contains 1 string: the search term
   * @return int number of records loaded
   */
  function load($args) {
    // clear any currently loaded info
    $this->_isChanged = false;
    $this->_cachedRecords = array();
    $this->_changedRecords = array();
    $this->reset();
    
    // generate search parameters
    list($txt) = $args;
    $email = Zen::checkEmail($txt);
    
    // search various tables and collect results
    $this->_rawData = array_merge(
         $this->_getUsers($txt, $email),
         $this->_getCompanies($txt, $email),
         $this->_getEmployees($txt, $email),
         $this->_getNotifys($txt, $email)
      );
    
    return count($this->_data);
  }
  
  function _getUsers($txt, $email) {
    global $zen;
    
    // build search parms
    $parms = array();
    $this->_addLoginParm($parms, $txt);
    $this->_addEmailParm($parms, $email);
    $this->_addInitialsParm($parms, $txt);
    $this->_addNameParm($parms, $txt);
    if( empty($parms) ) { return array(); }
    
    // query db for results
    $zt_users = $this->_fetchMorePossibles($parms, $zen->table_users, 
                                          array('fname','lname','email'));
    if( empty($zt_users) ) { return array(); }
    
    // convert results to notify entries
    $vals = array();
    foreach($zt_users as $u) {
      $u['name'] = $zen->formatName($u);
      $u['email'] = Zen::checkEmail($u['email']);
      $vals[] = $u;
    }
    return $vals;
  }
  
  function _getCompanies($txt, $email) {
    global $zen;

    // build search parms
    $parms = array();
    $this->_addTitleParm($parms, $txt);
    $this->_addEmailParm($parms, $email);
    if( empty($parms) ) { return array(); }
    
    // query company table
    $comps = $this->_fetchMorePossibles($parms, $zen->table_company,
                                      array('title','email'));
    if( empty($comps) ) { return array(); }
    
    // parse results
    $vals = array();
    foreach($comps as $c) {
      $c['name'] = $c['title'];
      $c['email'] = Zen::checkEmail($c['email']);
      $vals[] = $c;
    }
    return $vals;
  }
  
  function _getEmployees($txt, $email) {
    global $zen;
    
    // build search parms
    $parms = array();
    $this->_addEmailParm($parms, $email);
    $this->_addInitialsParm($parms, $txt);
    $this->_addNameParm($parms, $txt);
    if( empty($parms) ) { return array(); }
    
    // query db
    $emps = $this->_fetchMorePossibles($parms, $zen->table_employee,
                                       array('fname','lname','email'));
    if( empty($emps) ) { return array(); }
    
    // process results
    $vals = array();
    foreach($emps as $e) {
      $e['name'] = $zen->formatName($e);
      $e['email'] = Zen::checkEmail($e['email']);
      $vals[] = $e;
    }
    return $vals;
  }
  
  function _getNotifys($txt, $email) {
    global $zen;
    
    // build search parms
    $parms = array();
    $this->_addEmailParm($parms, $email);
    $parms['name'] = array('name', '=', $txt);
    
    // query db
    $query = "SELECT max(id),name,email FROM {$zen->table_notify_list} WHERE ";
    $query .= $zen->build_search_clause($parms);
    $query .= " GROUP BY email ";
    $vals = $zen->db_queryIndexed($query);
    return empty($vals)? array() : $vals;
  }
  
  /** assumes $email is already cleaned and validated */
  function _addEmailParm( &$parms, $email ) {
    if( $email ) { $parms[] = array('email', '=', $email); }
  }
  
  /** always adds title parm */
  function _addTitleParm( &$parms, $txt ) {
    $parms[] = array('title', '=', $txt);
  }
  
  /** adds name if space exists and it has 2 words */
  function _addNameParm( &$parms, $txt ) {
    if( strpos($txt, ' ') > 0 ) {
      list($fname,$lname) = explode(" ",$txt,2);
      $nameparts = array( array('fname', '=', $fname), array('lname', '=', $lname) );
      $parms[] = array( 'AND', $nameparts );
    }
  }
  
  /** adds initials if they are alphanumeric and < 5 chars long */
  function _addInitialsParm( &$parms, $txt ) {
    if( Zen::checkAlphanum($txt) && strlen($txt) < 5 ) { 
      $parms[] = array('initials', '=', $txt); 
    }
  }
  
  /** adds login if it's alphanumeric */
  function _addLoginParm( &$parms, $txt ) {
    if( Zen::checkAlphanum($txt) !== false ) {
      $parms[] = array('login', '=', $txt);
    }
  }
  
  /** fetch results from db */
  function _fetchMorePossibles($parms, $table, $cols) {
    global $zen;
    $pos = strpos($table, '_');
    $type = substr($table, ($pos? $pos+1 : 0));
    $where = $zen->build_search_clause($parms, 'OR');
    $c = join(",",$cols);
    $c .= ", '$type' as type ";
    $query = "SELECT $c FROM $table WHERE $where";
    return $zen->db_queryIndexed($query);
    //$vals = 
    //Zen::dprintf($parms);//debug
    //Zen::dprintf($query);//debug
    //Zen::dprintf($vals); //debug
    //return $vals;
  }
  
  function save() {
    //todo
    //todo
    //todo
    //todo
    //todo
    die("not ready");
  }

 }
?>