<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * This file defines some tests that are used by the ZenDataTypeTest and ZenListTest classes
   * for PHPUnit.
   *
   * @package PHPUnit
   */

  /**
   * A test class for the {@link ZenList} methods
   *
   * @package PHPUnit
   */
  class ZenDataType_testList extends ZenList {
    function ZenDataType_testList() {
      $this->ZenList();
    }
  }

  /**
   * A test class for the {@link ZenDataType} methods
   *
   * @package PHPUnit
   */
  class ZenDataType_test extends ZenDataType {    
    function ZenDataType_test($id, $zenlist) {
      $this->ZenDataType($id, $zenlist);
    }
  }

}?>