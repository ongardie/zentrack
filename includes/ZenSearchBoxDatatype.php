<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 
if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * Contains the ZenSearchBoxDatatype class
 */
 
/**
 * The ZenSearch class specific to data type entries
 */
class ZenSearchBoxDatatype extends ZenSearchBox {
  function ZenSearchBoxDatatype() { }
  
  function init() {
    $k = $this->_key();
    $zen =& $GLOBALS['zen'];
    $this->_possible = count($zen->getDataTypeVals($this->_table()));
  }
  
  function _key() {
    switch($this->_type) {
      case "bin":
        return "bid";
      case "priority":
        return "pid";
      case "type":
        return "type_id";
      case "system":
        return "sid";
      case "task":
        return "task_id";
      default:
        Zen::addDebug("ZenSearchBoxDatatype::_key", "Invalid type ".Zen::ffv($this->_type), 1);
        return false;
    }
  }
  
  function _table() {
    switch($this->_type) {
      case "bin":
        return "ZENTRACK_BINS";
      case "priority":
        return "ZENTRACK_PRIORITIES";
      case "type":
        return "ZENTRACK_TYPES";
      case "system":
        return "ZENTRACK_SYSTEMS";
      case "task":
        return "ZENTRACK_TASKS";
      default:
        Zen::addDebug("ZenSearchBoxDatatype::_table", "Invalid type ".Zen::ffv($this->_type), 1);
        return false;
    }
  }
  
  function _label() {
    switch($this->_type) {
      case "bin":
        return "Bins";
      case "priority":
        return "Priorities";
      case "type":
        return "Types";
      case "system":
        return "Systems";
      case "task":
        return "Tasks";
      default:
        Zen::addDebug("ZenSearchBoxDatatype::_label", "Invalid type ".Zen::ffv($this->_type), 1);
        return "invalid";
    }
  }

  /**
   * Generate a suitable title based on the type of search being conducted
   *
   * @return string
   */
   function getPageTitle() { return tr("Find ?", tr($this->_label())); }
  
  /** 
   * Generate text for form fields to diplay on form
   *
   * @param string $form name of the form
   * @param array $vals key/value pairs representing current values (if the form is being reloaded)
   * @param boolean $hidden if true, then all fields should be rendered hidden (for reposting data)
   * @return string
   */
  function renderFormFields( $form, $vals, $hidden = false ) {
    $vars['name'] = array_key_exists('name',$vals)? Zen::ffv(stripslashes($vals['name'])) : null;
    if( $hidden ) {
      $t = new zenTemplate($this->_templateDir."/searchbox_dth.template");
    }
    else {
      $t = new zenTemplate($this->_templateDir."/searchbox_dt.template");
    }
    $t->values($vars);
    return $t->process();
  }
  
  /**
   * Given a list of parameters, this method performs the search operation and
   * returns a ZenSearchBoxResults object.  The parameters are taken from the
   * _POST data resulting from the renderFormFields() method
   *
   * @return ZenSearchBoxResults
   */
  function getSearchResults() {
    $table = $this->_table();
    $id = $this->_key();
    $where = "WHERE active = 1";
    $match = array_key_exists('name',$_POST)? $_POST['name'] : false;
    $zen =& $GLOBALS['zen'];
    if( $match ) {
      $match = str_replace('*', '%', strtolower($match));
      $match = preg_replace('@^%@', '', $match);
      $match = preg_replace('@%$@', '', $match);
      $match = $zen->checkSlashes("%$match%");
      $where .= " AND lower(name) LIKE $match";
    }

    $query = "SELECT $id as id, name, priority FROM $table $where ORDER BY priority DESC, name";
    $lquery = "SELECT count(*) FROM $table $where";
    $total = $zen->db_get($lquery);
    if( $total > 0 ) {
      $results = $zen->db_getLimitedIndex($query, $this->_queryLimit, $this->_offset);
    }
    else { 
      $results = array(); 
    }

    $sbr = new ZenSearchBoxResults( array('id'=>tr("ID"), 'name'=>tr("Name")), $results, 'id', 'name', $total );
    Zen::addDebug("ZenSearchBoxDatatype::_getSearchResults", "[".$sbr->rows()."]$query", 3);
    return $sbr;
  }
  
  /**
   * Get the focal point for the form
   */
  function getFocalPoint() { return 'name'; }
  
  function showSearchForm() {
    $zen =& $GLOBALS['zen'];
    return $this->_possible > $this->_queryLimit;
  }
  
  function totalRecords() { return $this->_possible; }

  var $_fields;
  var $_possible;
}

?>
