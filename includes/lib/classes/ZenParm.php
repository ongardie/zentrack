<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenParm class.  Requires ZenDataType.php
 * @package Actions
 */

/**
 * Store parameters used for criteria, arguments, etc.
 *
 * The parm can get its data from several sources (see {@link source()}):
 * <ul>
 *  <li><b>Admin Setting</b> - setting from admin panel 
 *  <li><b>Boolean</b> - the value of this cell is a boolean true/false
 *  <li><b>Database</b> - the value of this cell comes from db table/field 
 *  <li><b>Environment</b> - get value from environment ($_SERVER, $_ENV, $HTTP_VARS, etc)
 *  <li><b>Form Data</b> - form data (from posted form, $_POST)
 *  <li><b>Helper</b> - run a helper function
 *  <li><b>Session</b> - get variable from session ($_SESSION, $GLOBALS)
 *  <li><b>Text</b> - insert value as text
 *  <li><b>User Function</b> - run a function from user file
 *  <li><b>zen.ini</b> - setting from ini file
 * </ul>
 *
 * @package Actions
 */
class ZenParm extends ZenDataType {

  /**
   * CONSTRUCTOR: load the designated parm from database
   *
   * @param integer $id if null, then an empty parm is created
   * @param ZenParmList $list ZenParm created from list instead of db
   */
  function ZenParm( $id = null, $list = null ) {
    $this->ZenDataType($id, $list);
  }

  /**
   * Compare this ZenParm with the parm provided
   *
   * @param ZenParm $parm
   * @return integer -1(less than), 0(equal), +1(greater than)
   */
  function compare( $parm ) {
    $v1 = $this->value();
    $v2 = $parm->value();
    if( ZenUtils::safeEquals($v1, $v2) ) { return 0; }
    else if( $v1 > $v2 ) { return 1; }
    else if( $v1 < $v2 ) { return -1; }
    else { return 0; }
  }

  /**
   * Return the name of this param
   */
  function name() {
    return $this->getField('parm_name');
  }

  /**
   * Load data for this parm
   */
  function _load() {
    ZenUtils::mark("ZenParm ".$this->_id." load");
    $p1 = $this->getField('parm_cat1');
    $p2 = $this->getField('parm_cat2');
    $p3 = $this->getField('parm_cat3');
    $p4 = $this->getField('parm_cat4');
    switch($this->source()) {
    case "boolean":
      $this->_val = ZenUtils::parseBoolean($p4);
      break;
    case "db":
      $query = Zen::getNewQuery();
      $query->table( $p1 );
      $query->field( $p2 );
      $query->match( $p3, ZEN_EQ, $p4, $p1 );
      $this->_val = $query->get( Zen::getCacheTime() );
      break;
    case "setting":
      $this->_val = Zen::getSetting( $p1, $p2 );
      break;
    case "form":
      $this->_val = ZenUtils::getFormData($p2);
      break;
    case "formfields":
      $this->_val = array();
      $t = Zen::getMetaData($p1);
      $this->_val = $t->listFields();
    case "helper":
      $this->_val = ZenUtils::runHelper($p2, array("parm"=>$this));
      break;
    case "ini":
      $this->_val = ZenUtils::getIni($p1, $p2);
    case "scope":
      $this->_val = ZenUtils::findGlobal($p1, $p2);
    case "text":
      $this->_val = $p4;
    case "user":
      $this->_val = ZenUtils::runScript($p2, array("parm"=>$this));
    default:
      ZenUtils::safeDebug($this, "value", "Requested parm type ".$this->source()." was invalid", 105, LVL_ERROR);
      $this->_val = null;
    }
    ZenUtils::unmark("ZenParm ".$this->_id." load");
  }
  
  /**
   * Returns the final(parsed) value of this parm
   *
   * @return mixed
   */
  function value() {
    if( !$this->_val ) {
      $this->_load(); 
    }
    return $this->_val;
  }

  /**
   * Returns the source/type for the parm
   *
   * @return string
   */
  function source() {
    return $this->getField('parm_source');
  }
  
  /**
   * @var mixed $_val stores the parm value
   */
  var $_val;

}

?>
