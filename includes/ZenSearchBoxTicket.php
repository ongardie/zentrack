<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 
if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * Contains the ZenSearchBoxTicket and ZenSearchBoxProject classes
 */
 
/**
 * The ZenSearch class specific to tickets and projects
 */
class ZenSearchBoxTicket extends ZenSearchBox {
  function ZenSearchBoxTicket() { }
  
  function init() {
    global $zen;
    global $map;
    $this->_zen =& $zen;
    $this->_map =& $map;
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
    return $this->_possible;
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
    $searchbox_vals = array();
    $txt = '<table cellpadding="2" cellspacing="1">';
    $ctx = new ZenFieldMapRenderContext();
    $ctx->set('view', $this->_view);
    $ctx->set('form', 'searchboxForm');
    foreach($this->_map->listFieldsForView($this->_view) as $f) {
      // fields which are not visible may still have a search value... if so
      // we include it here... if not, then we skip it entirely
      if( $hidden || !$this->_map->getFieldProp($this->_view, $f, 'is_visible') ) {
        if( !empty($vals[$f]) ) {
          $n = Zen::ffv($f);
          $v = Zen::ffv($vals[$f]);
          $txt .= "<input type='hidden' name='$n' value='$v'>\n";
        }
        continue;
      }
      
      if( $this->_map->getFieldProp($this->_view, $f, 'field_type') == 'searchbox' ) {
        $searchbox_vals[$f] = $vals[$f]? explode(',',$vals[$f]) : null;
      }
      
      // all other fields get rendered in the table
      $txt .= '<tr class="bars">';
      $txt .= "<td>".$this->_map->getLabel($this->_view, $f)."</td>";
      $txt .= "<td>";
      if( $this->_map->getFieldProp($this->_view, $f, 'field_type') == 'date' ) {
        // render two fields, so that a date range can be given
        $txt .= "<span class='note'>".tr("between")." ";

        // start date
        $n = "{$f}_start";
        $ctx->set('field', $f);
        $ctx->set('name', $n);
        $ctx->set('value', !empty($vals[$n])? $vals[$n] : null);
        $txt .= $this->_map->renderTicketField( $ctx );
        
        $txt .= " ".tr("and")." ";

        // end date
        $n = "{$f}_end";
        $ctx->set('field', $f);
        $ctx->set('name', $n);
        $ctx->set('value', array_key_exists($n, $vals)? $vals[$n] : null);
        $txt .= $this->_map->renderTicketField( $ctx );
        $txt .= "</span>";
      }
      else {
        $ctx->set('field', $f);
        $ctx->set('value', !empty($vals[$f])? $vals[$f] : null);
        $txt .= $this->_map->renderTicketField( $ctx );
      }
      $txt .= "</td></tr>";
    }
    $txt .= "</table>";
    $txt .= renderSearchboxJs($this->_view, 'searchboxForm', $searchbox_vals);
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
        if( !empty($_POST[$f]) ) {
          $comps[$f] = 'co';
          $vals[$f] = $_POST[$f];
        }
      }
      else {
        if( !empty($_POST[$f]) ) {
          $comps[$f] = 'eq';
          $vals[$f] = Zen::checkNum($f);
        }
      }
    }
    
    // only show projects in project views, only show tickets in ticket views
    if( isset($vals['type_id']) && is_array($vals['type_id']) ) {
      $comps['type_id'] = 'eq';
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
    $rows = $s->search($vals, $this->limit(), $this->offset());
    
    for($i=0; $i<count($rows); $i++) {
      foreach($cols as $k=>$v) {
        $rows[$i][$k] = $this->_map->getTextValue($this->_view, $k, $rows[$i][$k]);
      }
    }
    
    // return results
    Zen::addDebug('ZenSearchBoxTicket::getSearchResults', "returned ".count($rows).
        " rows using limit=".$this->limit().", offset=".$this->offset(), 3);
    return new ZenSearchboxResults($cols, $rows, 'id', 'title', $s->getTotal());
  }
  
  /**
   * Get the focal point for the form
   */
  function getFocalPoint() {
    foreach($this->_map->listFieldsForView($this->_view) as $f) {
      // the field needs to be visible to be useful
      if( $this->_map->getFieldProp($this->_view, $f, 'is_visible') ) {
        return $f;
      }
    }
    return null;
  }
  
  /**
   * Determine if a search is necessary based on the number of items to display
   */
  function showSearchForm() { return $this->getPossible() > $this->_queryLimit; }

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

?>