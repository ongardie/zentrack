<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Contains the ZenBin class.  Requires ZenDataType.php
 * @package Zen
 */

/** 
 * A bin represents a location, department, or container for organizing tickets.
 * 
 * @package Zen 
 */
class ZenBin extends ZenDataType {

  /**
   * CONSTRUCTOR
   *
   * Loads a ZenBin object for use
   *
   * @param integer $bin_id is the id of the bin (optional)
   * @param ZenBinList $list (optional)loads the bin from a ZenBinList rather than database
   */
  function ZenBin( $bin_id = null, $list = null ) { }

}

?>
