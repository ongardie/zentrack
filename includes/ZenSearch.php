<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 
if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * Contains the ZenSearch class
 */
 
/**
 * The ZenSearch class is used for creating generic search results from
 * any data type in the zt system.  
 *
 * The table to be searched must contain a corresponding field map and view map
 *
 * The view map must contain an entry which designates the source table.
 */
class ZenSearch {
  
  /**
   * Construct a new search object.
   *
   * @param string $view the view map entry to examine
   * @param ZenFieldMap $map instance of the ZenFieldMap class
   */
  function ZenSearch() {
    $this->_order = false;
    $this->_andor = 'AND';
    $this->_comps = array();
    $this->_total = 0;
  }
  
  /**
   * Initialize the ZenSearch from a field map
   */
  function initFromMap($view, &$map) {
    Zen::addDebug('ZenSearch::initFromMap', $view, 3);
    $this->_table = $map->getViewProp($view, 'table');
    $this->_fields = $map->listFieldsForView($view);
  }
  
  /**
   * Initialize from generic input data
   */
  function init($table, $fields) {
    Zen::addDebug('ZenSearch::init', "$table(".join(',',$fields).")", 3);
    $this->_table = $table;
    $this->_fields = $fields;
  }
  
  /**
   * Set the comparison method to be 'OR' instead of 'AND', meaning that
   * any field which matches returns a result instead of requiring all
   * fields to match to produce a result.
   */
   function matchAnyField() {
     Zen::addDebug('ZenSearch::matchAnyField', 'set to on', 3);
     $this->_andor = 'OR';
   }
  
  /**
   * Set the sort order for our method.  The text passed here is directly
   * inserted into the sql query without checks or validation.
   *
   * @param string $order the order by clause for sql query
   */
  function sortby( $order ) {
    Zen::addDebug('ZenSearch::sortby', $order, 3);
    $this->_order = $order;
  }
  
  /**
   * Set the comparators to use with each field.
   *
   * The associative should contain (string)field -> (string)comparator, 
   * where comparator represents one of the following:
   * <pre>
   *   eq     value matches text exactly
   *   co     value contains text
   *   bw     value begins with text
   *   ew     value ends with text
   *   gt     value is greater than integer value of text
   *   ge     value is greater than or equal to integer value of text
   *   lt     value is less than integer value of text
   *   le     value is less than or equal to integer value of text
   *   ne     value is not equal to text
   *   nc     value does not contain text
   *   bt     value is "between" two date timestamps (see search() method)
   * </ul>
   *
   * A special case occurs when the comparator for a field is set to "between"
   * and an array with exactly two elements is provided for the value.  In 
   * this special case, the values are assumed to be (int)timestamps which represent
   * a minimum (inclusive) and maximum (exclusive) date value that the field should
   * fall between.
   *
   * If the comparators are not provided, or a particular field does not appear
   * in the list, then the comparator defaults to 'co' for text fields and 'eq'
   * for all others.
   *
   * @param array $comps see description above
   */
  function setComparators( $comps ) {
    $this->_comps = $comps;
  }
  
  /**
   * Perform a search using values from the array provided.  The array is
   * an associative array of (string)field -> (mixed)value.
   *
   * The value can be an array of (string)choices or a (string)value.
   *
   * A special case occurs when the comparator for a field is set to "bt" (between)
   * and an array with exactly two elements is provided for the value.  In 
   * this special case, the values are assumed to be (int)timestamps which represent
   * a minimum (inclusive) and maximum (exclusive) date value that the field should
   * fall between.
   *
   * @see ZenSearch::setComparators()
   * @see ZenSearch::matchAnyField()
   * 
   * @param array $vals a key/value pair of (string)field -> (mixed)value to be matched (see above)
   * @param string $order ORDER BY clause
   * @return array containing rows of key/value pairs representing the columns of the table and their values
   */
   function search( $vals, $limit = 0, $offset = 0 ) {
     $zen = $GLOBALS['zen'];
     // generate search params
     $parms = array();
     foreach($this->_fields as $f) {
       // skip missing fields
       if( !array_key_exists($f, $vals) ) { continue; }
       
       // set up our value
       $v = $vals[$f];
       
       // create a comparator
       $c = $this->_comp($f);
       if( is_array($v) && count($v) == 2 && $c == 'bt' ) {
         // this special case occurs when using a 'between' comparator
         // with two dates.  We create a sub-select to add into the query
         // instead of the normal process
         $parms[] = array('AND', array( array($f, '>=', $v[0]), array($f, '<', $v[0]) ));
       }
       
       if( is_array($v) ) {
         $c = ($c == '!=')? '!IN' : 'IN';
       }
       
       if( $c == 'contains' ) { $v = str_replace('*', '%', $v); }
       
       // generate our parameter
       $parms[] = array($f, $c, $v);
     }
     
     if( $this->_table == 'ZENTRACK_TICKETS' ) {
       // always observe bin access rights
       $login_id = ZenSessionManager::getSession('login_id');
       $ubins = $zen->getUsersBins($login_id);
       if( count($ubins) > 100 ) {
         // split IN(..) statements into groups of 100, required for db2 and sql server
         $bins = array();
         $i=0;
         $j = 100;
         while( $i < count($ubins) ) {
           // observe upper limit (may not be exactly 100 records)
           if( $i+$j >= count($ubins) ) { $j = count($ubins)-$i; }
           $bins[] = array('bin_id', 'IN', array_slice($ubins, $i, $j));
           $i = $i+$j;
         }
         $bv = array('OR', $bins);
       }
       else {
         $bv = array('bin_id', 'IN', $ubins);
       }
       if( count($parms) ) {
         $parms = array( array($this->_andor, $parms), $bv );
         $this->_andor = 'AND';
       }
       else {
         $parms = $bins;
         $this->_andor = 'OR';
       }
     }
     
     if( count($parms) ) {
       $where = ' WHERE '.$zen->recursiveSearchClause($parms, $this->_andor);
     }
     
     // create sql query
     $query = "SELECT * FROM ".$this->_table." $where ORDER BY ".$this->_order();
     
     // get results and return
     if( $limit ) {
       $res = $zen->db_getLimitedIndex($query, $limit, $offset);
       $this->_total = count($res);
       if( $this->_total >= $limit || $offset + $limit > $this->_total ) {
         $this->_total = $zen->db_get("SELECT COUNT(*) FROM ".$this->_table." $where");
       }
     }
     else {
       $res = $zen->db_queryIndexed($query);
       $this->_total = count($res);
     }
     Zen::addDebug('ZenSearch::search', "[".count($res)."]$query", 3);
     return $res;
   }
   
   /**
    * If $limit was used in search() function, this will return the total
    * number of records that matched the query, if $limit was not used, 
    * this will always be the same as the number of rows in the query
    */
   function getTotal() { return $this->_total; }
   
   /**
    * Create a default ordering scheme for the current table
    */
   function _order() {
     if( $this->_order ) { return $this->_order; }
     switch(str_replace('ZENTRACK_', '', $this->_table)) {
       case 'USERS':
         return 'lname, fname';
       case 'TICKETS':
         return 'priority, otime desc';
       default:
         return 'priority DESC, name';
     }
   }
   
   /**
    * Generate a comparator for a given field based on the values in the
    * comparator given or a default value ('co' for strings and 'eq' for others)
    */
   function _comp( $field ) {
     $comparator = array_key_exists($field, $this->_comps)? $this->_comps[$field] : false;
     if( !$comparator ) {
       // create default comparator
       $fp = getFmFieldProps($this->_view, $field);
       if( $fp['data_type'] == 'string' || $fp['data_type'] == 'text' ) {
         $comparator = 'co';
       }
       else {
         $comparator = 'eq';
       }
     }
     switch($comparator) {
       case "eq": return "=";
       case "co": return "contains";
       case "bw": return "b";
       case "ew": return "e";
       case "gt": return ">";
       case "ge": return "<";
       case "lt": return "<=";
       case "le": return ">=";
       case "ne": return "!=";
       case "nc": return "";
       case "bt": return "bt";
       default: return "eq";
     }
   }
   
   var $_map;
   var $_view;
   var $_fields;
   var $_table;
   var $_order;
   var $_comps;
   var $_andor;
   var $_total;

}

?>