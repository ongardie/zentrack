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
   * CONSTRUCTOR: Prepares the parm list by collecting a list of ids which are
   * relevant to this list and loading the data for each parm.
   */
  function ZenParmList( $setId ) {
    ZenUtils::prep("ZenParm");
    $this->ZenList();

    // retrieve ids of parms belonging to this list
    $query = Zen::getNewQuery();
    $query->table('PARM_SET');
    $query->match('parm_set_id',$setId);
    $query->sort('parm_pri');
    $parmIds = $query->selectList('parm_id');

    // load data for the relevant ids
    // and make sure that the data is sorted
    // in the order of this array
    $this->criteriaIdArray($parmIds, true);
    $this->load();
  }

}

?>
