<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenSearchParms class.
 * @package Zen
 */

/** 
 * Search parameters to be used for constructing db search queries.
 *
 * These parameters are passed to {ZenQuery::search()} method.
 *
 * @package DB
 */
class ZenSearchParms {

  /**
   * Construct a new ZenSearchParms object
   *
   * @param string $andor is the base conjunction: either 'AND' or 'OR'
   */
  function ZenSearchParms( $andor = 'AND' ) {
    // create array, initialize the opening andor command
    $this->_parms = array( array('',$andor) );
  }

  /**
   * Creates a match condition.  The format of this method is the same as {@link ZenQuery::match()}
   */
  function match( $field, $operator, $value, $table = null ) {
    $this->_parms[] = array($field, $operator, $value, $table, 'match');
  }

  /**
   * Creates an exclude condition.  The format of this method is the same as {@link ZenQuery::exclude()}
   */
  function exclude( $field, $operator, $value, $table = null ) {
    $this->_parms[] = array($field, $operator, $value, $table, 'exclude');
  }

  /**
   * Starts a grouping set.  Groups can be nested.  For instance:
   *
   * <pre><code>
   *   $sp = new ZenSearchParms('OR');
   *   $sp->startGroup('AND');
   *      $sp->match('column1', ZEN_LT, 20);
   *      $sp->match('column1', ZEN_GE, 10);
   *   $sp->endGroup();
   *   $sp->match('column2', ZEN_CONTAINS, 'happy');
   *   $sp->generate();
   *   $query->search( $sp );
   * </code></pre>
   *
   * Would produce: WHERE (column1 < 20 AND column1 >= 10) OR column2 LIKE '%happy%'
   *
   * <pre><code>
   *   $sp = new ZenSearchParms('AND');
   *   $sp->startGroup('OR');
   *     $sp->startGroup('AND');
   *       $sp->match('column1', ZEN_LT, 20);
   *       $sp->match('column1', ZEN_GE, 10);
   *     $sp->endGroup();
   *     $sp->exclude('column2', ZEN_EQ, 'sad');
   *   $sp->endGroup();
   *   $sp->match('column3', ZEN_CONTAINS, 'red');
   *   $query->search( $sp );
   * </code></pre>
   *
   * Would produce: WHERE ((column1 < 20 AND column1 >= 10) OR column2 != 'sad') AND column3 LIKE '%red%'
   *
   * @param string $andor is either 'AND' or 'OR'
   */
  function startGroup( $andor ) {
    $this->_parms[] = array('(',$andor);
  }

  /**
   * Closes a grouping set.  See {@link startGroup()}.
   */
  function endGroup() { $this->_parms[] = ')'; }

  /**
   * Return the parms for use
   *
   * @return array of grouping symbols and parm arrays
   */
  function getParms() { 
    return $this->_parms; 
  }

  /** @var array the complete set of search parameters */
  var $_parms;
}

?>
