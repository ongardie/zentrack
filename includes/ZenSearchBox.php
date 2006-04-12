<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 
if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * Container for the ZenSearchBox class and impls
 */

/**
 * An abstract class used to generate searchbox windows.  Implementations of this
 * class must define all methods marked with @abstract.
 *
 * There is no need to instanciate instances of this class, just call
 * ZenSearchBox::getInstance( $mode ), where $mode corresponds with the name
 * of one of the implementations.
 *
 * @abstract
 */
class ZenSearchBox {
  
  /** @private */
  function ZenSearchBox() { die("Use ZenSearchBox::getInstance()"); }
  
  /** 
   * @static
   */
  function &getInstance( $templateDir, $mode, $multi, $type = false ) {
    $mode = ucfirst(strtolower($mode));
    $n = "ZenSearchBox$mode";
    if( class_exists($n) ) {
      $c = new $n();
      $c->load($templateDir, $mode, $multi, $type);
      $c->init();
      return $c;
    }
    return false;
  }
  
  /** @private */
  function load( $templateDir, $mode, $multi, $type) {
    $this->_templateDir = $templateDir;
    $this->_mode = $mode;
    $this->_type = $type;
    $this->_parms = array();
    $this->_comps = array();
    $this->_matchany = false;
    $this->_multi = $multi;
    $this->_queryLimit = isset($_POST['queryLimit'])? $_POST['queryLimit'] : 25;
    $this->_offset = isset($_POST['offset'])? $_POST['offset'] : 0;
  }
  
  function mode() { return $this->_mode; }
  
  function multi() { return $this->_multi; }
  
  function type() { return $this->_type; }
  
  /**
   * Change the search from an 'AND' context to an 'OR' context
   */
  function matchAnyField() { $this->_matchany = true; }
  
  /**
   * Add a parameter into the current search group, if no search group
   * is currently opened, a default one will be created
   *
   * @param string $field
   * @param string $value
   * @param string $comp a comparator usable with ZenSearch::setComparators()
   */
  function addSearchParm( $field, $value, $comp = 'eq' ) {
    $this->_parms[$field] = $value;
    $this->_comps[$field] = $comp;
  }
  
  /**
   * Returns the number of items displayed per page
   */
  function getQueryLimit() { return $this->_queryLimit; }
  
  /** @abstract */
  function init() { die("Implementations must define the _init method"); }

  /**
   * Generate a suitable title based on the type of search being conducted
   *
   * @abstract
   * @return string
   */
   function getPageTitle() { die("Implementations must define the _getPageTitle() method"); }
  
  /** 
   * Generate text for form fields to diplay on form
   *
   * @abstract
   * @param string $form name of the form
   * @param array $vals key/value pairs representing current values (if the form is being reloaded)
   * @param boolean $hidden if true, then all fields should be rendered hidden (for reposting data)
   * @return string
   */
  function renderFormFields( $form, $vals, $hidden = false ) { die("Implementations must define the renderFormFields() method"); }
  
  /**
   * Given a list of parameters, this method performs the search operation and
   * returns a ZenSearchBoxResults object.  The parameters are taken from the
   * _POST data resulting from the _renderFormFields() method
   *
   * @abstract
   * @return ZenSearchBoxResults
   */
  function getSearchResults() { die("Implementations must define the getSearchResults() method"); }
  
  /**
   * Get the focal point for the form
   */
  function getFocalPoint() { die("Implementations must define the getFocalPoint() method"); }
  
  /**
   * Determine if a search is necessary based on the number of items to display
   */
  function showSearchForm() { die("Implementations must define the showSearchForm() method"); }
  
  /**
   * Returns the total number of records that can be queried against by this form
   */
  function totalRecords() { die("Implementations must define the totalRecords() method"); }
  
  var $_templateDir;
  var $_mode;
  var $_type;
  var $_parms;
  var $_comps;
  var $_matchany;
  var $_queryLimit;
  var $_offset;
}

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

class ZenSearchBoxUser extends ZenSearchBox {
  function ZenSearchBoxUser() { }
  
  function init() {
    $this->_select = "<select name='{name}'>"
                    ."<option value='co'>Contains</option>"
                    ."<option value='eq'>Equals</option>"
                    ."<option value='bw'>Begins With</option>"
                    ."<option value='ew'>Ends With</option>";    
    $this->_fields = array(
      "user_id"  => array('label' => 'ID',         'type' => 'int',  'search' => false, 'show'=>true),
      "lname"    => array('label' => 'Last Name',  'type' => 'text', 'search' => true,  'show'=>true),
      "fname"    => array('label' => 'First Name', 'type' => 'text', 'search' => true,  'show'=>true),
      "initials" => array('label' => 'Initials',   'type' => 'text', 'search' => true,  'show'=>false),
      "email"    => array('label' => 'Email',      'type' => 'text', 'search' => true,  'show'=>false),
      "login"    => array('label' => 'Login',      'type' => 'text', 'search' => true,  'show'=>false),
      "notes"    => array('label' => 'Notes',      'type' => 'text', 'search' => true,  'show'=>false)
    );
    $zen =& $GLOBALS['zen'];
    $this->_possible = $zen->db_get("SELECT COUNT(*) FROM {$zen->table_users} WHERE ACTIVE = 1");
  }

  /**
   * Generate a suitable title based on the type of search being conducted
   *
   * @return string
   */
   function getPageTitle() { return tr("Find Users"); }
  
  /** 
   * Generate text for form fields to diplay on form
   *
   * @param string $form name of the form
   * @param array $vals key/value pairs representing current values (if the form is being reloaded)
   * @param boolean $hidden if true, then all fields should be rendered hidden (for reposting data)
   * @return string
   */
  function renderFormFields( $form, $vals, $hidden = false ) {
    $txt = '';
    print "<table>";
    foreach($this->_fields as $f=>$v) {
      // not a searchable field
      if( !$v['search'] ) { continue; }
      $val = array_key_exists($f, $vals)? Zen::ffv($vals[$f]) : '';
      $txt .= "<tr class='bars'>";
      $txt .= "<td>".Zen::ffv(tr($v['label']))."</td>";
      $txt .= "<td>".str_replace('{name}', $f, $this->_select)."</td>";
      $txt .= "<td><input type='text' name='$f' value='$val'></td>";
      $txt .= "</tr>";
    }
    print "</table>";
    return $txt;
  }
  
  /**
   * Given a list of parameters, this method performs the search operation and
   * returns a ZenSearchBoxResults object.  The parameters are taken from the
   * _POST data resulting from the renderFormFields() method
   *
   * @return ZenSearchBoxResults
   */
  function getSearchResults() {
    $zen =& $GLOBALS['zen'];
    $showfields = array();
    $cols = array( 'active' );
    $vals = array( 'active'=>1 );
    $comps = array( 'active'=>'eq' );
    foreach($this->_fields as $f=>$v) {
      // avoid antoher iteration by just getting out search fields now
      if( $v['show'] ) { $showfields[$f] = $v['label']; }
      // not a search field
      if( !$v['search'] ) { continue; }
      // no value was entered for this item
      if( !array_key_exists($f, $_POST) ) { continue; }
      // display searched on fields because they searched using them
      if( !array_key_exists($showfields[$f]) ) {
        $showfields[$f] = $v['label'];
      }
      // set up our search data
      $cols[] = $f;
      $vals[$f] = $_POST[$f];
      $comps[$f] = $_POST["{$f}_comp"];
    }
    
    // set up search parameters and run
    $s = new ZenSearch();
    $s->init( $zen->table_users, $cols );
    $s->sortBy( 'lname, fname' );
    $s->setComparators( $comps );
    if( $this->_matchany ) { $s->matchAnyField(); }
    $rows = $s->search($vals, $this->_queryLimit, $this->_offset);
    
    //Zen::printArray($rows, "rows"); //debug
    
    // return results
    Zen::addDebug('ZenSearchBoxUser::getSearchResults', "{$zen->table_users}[".count($rows)."]".join(',',$cols), 3);
    return new ZenSearchboxResults($showfields, $rows, 'user_id', array('lname','fname'), $s->getTotal());
  }
  
  /**
   * Get the focal point for the form
   */
  function getFocalPoint() { return 'lname'; }
  
  function showSearchForm() {
    return( $this->_possible > $this->_queryLimit );
  }
  
  function totalRecords() { die("Implementations must define the totalRecords() method"); }

  var $_fields;
  var $_possible;
  var $_select;
}

class ZenSearchBoxTicket extends ZenSearchBox {
  function ZenSearchBoxTicket() { }
  
  function init() {
    $this->_zen =& $GLOBALS['zen'];
    $this->_map =& $GLOBALS['map'];
    $this->_pids = $this->_zen->projectTypeIds();
    $this->_isproject = false;
    $this->_view = 'searchbox_ticket';
    $this->_possible = false;
    $login_id = ZenSessionManager::getSession('login_id');
    $this->_bins = $this->_zen->getUsersBins($login_id);
  }
  
  var $_zen;
  var $_possible;
  var $_pids;
  var $_map;
  var $_isproject;
  var $_view;
  var $_bins;
  
  /**
   * Get the possible number of entries for this type
   */
  function getPossible() {
    if( strlen($this->_possible) > 0 ) { return $this->_possible; }
    $in = $this->_isproject? 'IN' : 'NOT IN';
    $ids = join(',', $this->_pids);
    if( count($this->_bins) > 100 ) {
      $bt = false;
      for($i=0; $i<count($this->_bins); $i += 100) {
        $e = $i+100 < count($this->_bins)? $i+100 : count($this->bins)-1;
        $x = join(',',array_slice($this->_bins, $i, $e));
        $bt? " OR bin_id IN ($x) " : "( bin_id in ($x) ";
      }
      $bt .= ')';
    }
    else {
      $bt = "bin_id IN (".join(',', $this->_bins).")";
    }
    $this->_possible = $this->_zen->db_get("SELECT COUNT(*) FROM ".$this->_zen->table_tickets." WHERE type_id $in ($ids) AND $bt");
  }

  /**
   * Generate a suitable title based on the type of search being conducted
   *
   * @abstract
   * @return string
   */
   function getPageTitle() { return tr("Find Tickets"); }
  
  /** 
   * Generate text for form fields to diplay on form
   *
   * @param string $form name of the form
   * @param array $vals key/value pairs representing current values (if the form is being reloaded)
   * @param boolean $hidden if true, then all fields should be rendered hidden (for reposting data)
   * @return string
   */
  function renderFormFields( $form, $vals, $hidden = false ) {
    $txt = '<table cellpadding="2" cellspacing="1">';
    $ctx = new ZenFieldMapRenderContext();
    $ctx->set('view', $this->_view);
    $ctx->set('form', $form);
    foreach($this->_map->listFieldsForView($this->_view) as $f) {
      $txt .= '<tr class="cell">';
      $txt .= "<td>".$this->_map->getLabel($this->_view, $f)."</td>";
      $txt .= "<td>";
      if( $this->_map->getFieldProp($this->_view, $f, 'field_type') == 'date' ) {
        // render two fields, so that a date range can be given
        $txt .= "<span class='note'>".tr("between")." ";

        // start date
        $n = "{$f}_start";
        $ctx->set('field', $f);
        $ctx->set('name', $n);
        $ctx->set('value', array_key_exists($n, $vals)? $vals[$n] : null);
        $txt .= $this->_map->renderTicketField( $context );
        
        $txt .= " ".tr("and")." ";

        // end date
        $n = "{$f}_end";
        $ctx->set('field', $f);
        $ctx->set('name', $n);
        $ctx->set('value', array_key_exists($n, $vals)? $vals[$n] : null);
        $txt .= $this->_map->renderTicketField( $context );
        
        $txt .= "</span>";
      }
      else {
        $ctx->set('field', $f);
        $ctx->set('value', array_key_exists($f, $vals)? $vals[$f] : null);
        $txt .= $this->_map->renderTicketField( $context );
      }
      $txt .= "</td></tr>";
    }
    return $txt;
  }
  
  /**
   * Given a list of parameters, this method performs the search operation and
   * returns a ZenSearchBoxResults object.  The parameters are taken from the
   * _POST data resulting from the renderFormFields() method
   *
   * @abstract
   * @return ZenSearchBoxResults
   */
  function getSearchResults() {
    if( $this->_matchany ) {
      // matchany is not allowed because we must restrict 
      Zen::addDebug('ZenSearchBoxTicket::getSearchResults', 'matchAnyField not compatable for security reasons', 1);
    }
    
    $comps = array();
    $vals = array();
    $cols = array();
    foreach($this->_map->listFieldsForView($this->_view) as $f) {
      // store a list of visible fields for the results
      if( $this->_map->getFieldProp($this->_view, $f, 'is_visible') ) {
        $cols[$f] = $this->_map->getLabel($this->_view, $f); 
      }
      // collect information about the field
      $fp = getFmFieldProps($this->_view, $f);
      if( $this->_map->getFieldProp($this->_view, $f, 'field_type') == 'date' ) {
        // date fields have a range, so there are two fields to consider
        $s = "{$f}_start";
        $e = "{$f}_end";
        $st = isset($_POST[$s])? Zen::checkNum($_POST[$s]) : false;
        $et = isset($_POST[$e])? Zen::checkNum($_POST[$e]) : false;
        if( $st && $et ) {
          // this is a valid date range
          $comps[$f] = 'bt';
          $vals[$f] = array($st, $et);
        }
        else if( $st ) {
          // only a start time was entered, so use a simple "greater than"
          $comps[$f] = 'ge';
          $vals[$f] = $st;
        }
        else if( $et ) {
          // only an end time was entered, so use a simple "less than"
          $comps[$f] = 'lt';
          $vals[$f] = $et;
        }
      }
      else if( $fp['field_type'] == 'text' || $f['field_type'] == 'string' ) {
        if( isset($_POST[$f]) ) {
          $comps[$f] = 'co';
          $vals[$f] = $_POST[$f];
        }
      }
    }
    
    // only show projects in project views, only show tickets in ticket views
    if( isset($vals['type_id']) && is_array($vals['type_id']) ) {
      foreach($vals['type_id'] as $v) {
        if( in_array($v, $this->_pids) != $this->_isproject ) {
          $vals['type_id'] = $this->_pids;
          $comps['type_id'] = $this->_isproject? 'eq' : 'ne';
          break;
        }
      }
    }
    else if( !isset($comps['type_id']) || in_array($comps['type_id'], $this->_pids) != $this->_isproject ) {
      $comps['type_id'] = $this->_isproject? 'eq' : 'ne';
      $vals['type_id'] = $this->_pids;
    }
    
    // construct search
    $s = new ZenSearch();
    $s->initFromMap($this->_view, $this->_map);
    $s->setComparators($comps);
    $rows = $s->search($vals, $this->_queryLimit, $this->_offset);
    
    for($i=0; $i<count($rows); $i++) {
      foreach($cols as $k=>$v) {
        $rows[$i][$k] = $this->_map->getTextValue($this->_view, $k, $rows[$i][$k]);
      }
    }
    
    // return results
    Zen::addDebug('ZenSearchBoxTicket::getSearchResults', "returned ".count($rows)." rows", 3);
    return new ZenSearchboxResults($cols, $rows, 'id', 'title', $s->getTotal());
  }
  
  /**
   * Get the focal point for the form
   */
  function getFocalPoint() { die("Implementations must define the getFocalPoint() method"); }
  
  /**
   * Determine if a search is necessary based on the number of items to display
   */
  function showSearchForm() { return $this->_possible > $this->_queryLimit; }

  function totalRecords() { die("Implementations must define the totalRecords() method"); }
}

class ZenSearchBoxProject extends ZenSearchBoxTicket {
  function ZenSearchBoxProject() { }
  
  /** @abstract */
  function init() {
    parent::init();
    $this->_isproject = true;
    $this->_view = 'searchbox_project';
  }

  /**
   * Generate a suitable title based on the type of search being conducted
   *
   * @abstract
   * @return string
   */
   function getPageTitle() { return tr("Find Projects"); }
  
}

class ZenSearchBoxResults {
  
  function ZenSearchBoxResults( $cols, $vals, $id_col, $label_col, $total ) {
    $this->_vals = $vals;
    $this->_cols = $cols;
    $this->_id = $id_col;
    $this->_label = $label_col;
    $this->_total = $total;
  }
  
  function rows() { return is_array($this->_vals)? count($this->_vals) : 0; }
  
  function vals() { return $this->_vals; }
  
  function cols() { return array_keys($this->_cols); }
  
  function labels() { return $this->_cols; }
  
  function id( $row ) { return $row[$this->_id]; }
  
  function label( $row ) {
    if( is_array($this->_label) ) {
      $txt = '';
      foreach($this->_label as $k) {
        $txt .= $txt? ','.$row[$k] : $row[$k];
      }
      return $txt;
    }
    return $row[$this->_label]; 
  }
  
  function total() { return $this->_total; }
  
  var $_vals;
  var $_cols;
  var $_id;
  var $_label;
  var $_total;
  
}

?>