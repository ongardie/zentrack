<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenParmList class.  Requires ZenList.php
 * @package Zen
 */

/** 
 * Holds a list of parms which are used by actions, filters, and other logic
 * to load dynamic variable values.
 *
 * The ZenParmList is not a standard ZenList data type.  Some fields available to
 * tables which extend ABSTRACT_DATA_TYPE will not be found here.  Be careful
 * how this class is implemented!
 *
 * @package Zen
 */
class ZenParmList extends ZenList {

  /**
   * CONSTRUCTOR
   */
  function ZenParmList( $setId ) {
    //todo
    //todo use $setId
    $this->ZenList();
  }

}

?>
