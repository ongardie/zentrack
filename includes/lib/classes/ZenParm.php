<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/*
 * Store parameters used for criteria, arguments, etc.
 *
 * The parm can get its data from several sources (see {@link source()}):
 * <ul>
 *  <li><b>Boolean</b> - the value of this cell is a boolean true/false
 *  <li><b>Database</b> - the value of this cell comes from db table/field 
 *  <li><b>Setting</b> - setting from admin panel 
 *  <li><b>Ini</b> - setting from ini file
 *  <li><b>Form</b> - form data (from posted form)
 *  <li><b>Helper</b> - run a helper function
 *  <li><b>Scope</b> - get variable from session
 *  <li><b>Text</b> - insert value as text
 *  <li><b>User Fxn</b> - run a function from user file
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
   * Returns the final(parsed) value of this parm
   *
   * @return mixed
   */
  function value() {
    $p1 = $this->getField('parm_cat1');
    $p2 = $this->getField('parm_cat2');
    $p3 = $this->getField('parm_cat3');
    $p4 = $this->getField('parm_cat4');
    switch($this->source()) {
    case "boolean":
      return ZenUtils::parseBoolean($p4);
      break;
    case "db":
      $query = Zen::getNewQuery();
      $query->table( $p1 );
      $query->field( $p2 );
      $query->match( $p3, ZEN_EQ, $p4, $p1 );
      return $query->get( Zen::getCacheTime() );
    case "setting":
      return Zen::getSetting( $p1, $p2 ); 
    case "form":
      return ZenUtils::getFormData($p2);
    case "helper":
      return ZenUtils::runHelper($p2, array("parm"=>$this));
    case "ini":
      return ZenUtils::getIni($p1, $p2);
    case "scope":
      return ZenUtils::findGlobal($p1, $p2);
    case "text":
      return $p4;
    case "user":
      return ZenUtils::runScript($p2, array("parm"=>$this));
    default:
      ZenUtils::safeDebug($this, "value", "Requested parm type ".$this->source()." was invalid", 105, LVL_ERROR);
      return null;
    }
  }

  /**
   * Returns the source/type for the parm
   *
   * @return string
   */
  function source() {
    return $this->getField('parm_source');
  }

}

?>