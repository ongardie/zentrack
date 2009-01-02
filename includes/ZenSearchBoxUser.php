<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 
if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * Contains the ZenSearchBoxUser class
 */
 
/**
 * The ZenSearchBox class specific to users
 */
class ZenSearchBoxUser extends ZenSearchBox {
  function ZenSearchBoxUser() { }
  
  function init() {
    $this->_fields = array(
      "user_id"  => array('label' => 'ID',         'type' => 'int',  'search' => false, 'show'=>true),
      "lname"    => array('label' => 'Last Name',  'type' => 'text', 'search' => true,  'show'=>true),
      "fname"    => array('label' => 'First Name', 'type' => 'text', 'search' => true,  'show'=>true),
      "initials" => array('label' => 'Initials',   'type' => 'text', 'search' => true,  'show'=>false),
      "email"    => array('label' => 'Email',      'type' => 'text', 'search' => true,  'show'=>false),
      "login"    => array('label' => 'Login',      'type' => 'text', 'search' => true,  'show'=>false),
      "notes"    => array('label' => 'Notes',      'type' => 'text', 'search' => true,  'show'=>false)
    );
    global $zen;
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
    $txt = "<table>";
    foreach($this->_fields as $f=>$v) {
      // not a searchable field
      if( !$v['search'] ) { continue; }
      $val = array_key_exists($f, $vals)? Zen::ffv($vals[$f]) : '';
      if( $hidden ) {
        $txt .= "<input type='hidden' name='$f' value='$val'>\n";
        $txt .= "<input type='hidden' name='{$f}_comp' value='".$this->_getCompVal($f)."'>\n";
        continue;
      }
      
      $txt .= "<tr class='bars'>";
      $txt .= "<td>".Zen::ffv(tr($v['label']))."</td>";
      $txt .= "<td>".$this->_showSelect($f)."</td>";
      $txt .= "<td><input type='text' name='$f' value='$val'></td>";
      $txt .= "</tr>\n";
    }
    $txt .= "</table>";
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
    global $zen;
    $showfields = array();
    $cols = array( 'active' );
    $vals = array( 'active'=>0 );
    $comps = array( 'active'=>'gt' );
    foreach($this->_fields as $f=>$v) {
      // avoid antoher iteration by just getting out search fields now
      if( $v['show'] ) { $showfields[$f] = $v['label']; }
      // not a search field
      if( !$v['search'] ) { continue; }
      // no value was entered for this item
      if( empty($_POST[$f]) ) { continue; }
      // display searched on fields because they searched using them
      if( !array_key_exists($f, $showfields) ) { $showfields[$f] = $v['label']; }
      // set up our search data
      $cols[] = $f;
      $vals[$f] = $_POST[$f];
      $comps[$f] = $this->_getCompVal($f);
    }
    
    // construct a list of filtered bins, check to make sure
    // that the bins are in the search parms, or no search parm
    // was set for the bin
    $bins = $zen->getUsersBins($_SESSION['login_id'], 'level_user');
    $newvals = array();
    foreach($bins as $b) {
      if( empty($comps['bin_id']) || in_array($comps['bin_id'], $b) ) {
        $newvals[] = $b;
      }
    }
    $comps['bin_id'] = $newvals;
    
    // set up search parameters and run
    $s = new ZenSearch();
    $s->init( $zen->table_users, $cols );
    $s->sortBy( 'lname, fname' );
    $s->setComparators( $comps );
    if( $this->_matchany ) { $s->matchAnyField(); }
    $rows = $s->search($vals, $this->_queryLimit, $this->_offset);
    
    // return results
    Zen::addDebug('ZenSearchBoxUser::getSearchResults', "{$zen->table_users}[".count($rows)."]".join(',',$cols), 3);
    return new ZenSearchboxResults($showfields, $rows, 'user_id', array('lname','fname'), $s->getTotal());
  }
  
  /**
   * Get the focal point for the form
   */
  function getFocalPoint() {
    // just return the name of the first visible field
    foreach($this->_fields as $k=>$v) { if( $v['show'] ) { return $k; } }
  }
  
  function showSearchForm() {
    return( $this->_possible > $this->_queryLimit );
  }
  
  function totalRecords() { die("Implementations must define the totalRecords() method"); }
  
  function _showSelect( $name ) {
    $val = $this->_getCompVal($name);
    $options = array('co' => 'Contains', 'eq' => 'Equals', 'bw' => 'Begins With', 'ew' => 'Ends With');
    $txt = "<select name='{$name}_comp'>";
    foreach($options as $k=>$v) {
      $s = $val == $k? ' selected' : '';
      $txt .= "<option value='$k'$s>$v</option>";
    }
    $txt .= "</select>";
    return $txt;
  }
  
  function _getCompVal( $f ) {
    $n = "{$f}_comp";
    return empty($_POST[$n])? 'co' : $_POST[$n];
  }

  var $_fields;
  var $_possible;
}

?>