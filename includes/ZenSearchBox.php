<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 
if( !ZT_DEFINED ) { die("Illegal Access"); }

include_once("$libDir/ZenSearchBoxDatatype.php");
include_once("$libDir/ZenSearchBoxUser.php");
include_once("$libDir/ZenSearchBoxTicket.php");
include_once("$libDir/ZenSearchBoxContact.php");

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
    $this->_queryLimit = isset($_POST['queryLimit'])? $_POST['queryLimit'] : 10;
    $this->_offset = isset($_POST['offset'])? $_POST['offset'] : 0;
  }
  
  function mode() { return $this->_mode; }
  
  function multi() { return $this->_multi; }
  
  function type() { return $this->_type; }
  
  function offset() { return $this->_offset; }
  
  function limit() { return $this->_queryLimit; }
  
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
