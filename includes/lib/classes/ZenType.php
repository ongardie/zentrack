<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package Zen */
class ZenType extends ZenDataType {

  /**
   *  CONSTRUCTOR
   * Loads a ZenType object for use
   *
   * @param integer $type_id is the id of the type (optional)
   * @param ZenTypeList $list (optional)loads the type from a ZenTypeList rather than database
   */
  function ZenType( $type_id = null, $list = null ) { }

  /**
   * Returns a list of fields used by tickets of this type
   *
   * @return array of col_name values used by tickets of this type
   */
  function getTypeFields() { }

  /**
   * Returns a list of actions applicable to this type
   * 
   * @return ZenActionList
   */
  function getTypeActions() { }

  /**
   * Returns a list of triggers applicable to this type
   *
   * @return ZenTriggerList
   */
  function getTypeTriggers() { }

  /**
   * Returns a list of bins associated with this type
   *
   * @return ZenBinList
   */
  function getTypeBins() { }

  /**
   * Returns a list of priorities associated with this type
   *
   * @return ZenPriorityList
   */
  function getTypePriorities() { }

  /**
   * Returns a list of systems associated witht this type
   * 
   * @return ZenSystemList
   */
  function getTypeSystems() { }

  /**
   * Returns a list of stages used by this type
   *
   * @return ZenStageList
   */
  function getTypeStages() { }

}

?>
