<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * @package Libs
   *
   * Provides simple means of including the appropriate classes for each page.  The 
   */

  // benchmarking
  if( function_exists("startPTime") ) {
    startPTime("classes.php");
  }

  /** Includes the standard classes */
  $standard_classes = array(
                            "Zen.php",
                            "ZenDataType.php",
                            "ZenDatabase.php",
                            "ZenEmail.php",
                            "ZenFormGenerator.php",
                            "ZenList.php",
                            "ZenMessage.php",
                            "ZenMessageList.php",
                            "ZenMetaField.php",
                            "ZenMetaTable.php",
                            "ZenMetaTableList.php",
                            "ZenQuery.php",
                            "ZenTemplate.php",
                            "ZenTranslator.php",
                            "ZenXMLParser.php",
                            "ZenUtils.php",
                            "adodb/adodb.inc.php" );

  /** Includes the DataType classes */
  $data_type_classes = array(
                            "ZenAccess.php",
                            "ZenAccessList.php",
                            "ZenAction.php",
                            "ZenActionList.php",
                            "ZenAttachment.php",
                            "ZenAttachmentList.php",
                            "ZenBin.php",
                            "ZenBinList.php",
                            "ZenFilter.php",
                            "ZenFilterList.php",
                            "ZenNotifyList.php",
                            "ZenPriority.php",
                            "ZenPriorityList.php",
                            "ZenRole.php",
                            "ZenStage.php",
                            "ZenStageList.php",
                            "ZenSystem.php",
                            "ZenSystemList.php",
                            "ZenTask.php",
                            "ZenTaskList.php",
                            "ZenTicket.php",
                            "ZenTicketList.php",
                            "ZenRelatedList.php",
                            "ZenTrigger.php",
                            "ZenTriggerList.php",
                            "ZenType.php",
                            "ZenTypeList.php",
                            "ZenUser.php",
                            "ZenUserList.php" );

  /** The other/misc classes */
  $other_classes = array(
                         "ZenDBXML.php",
                         "db/DbTypeInfo.php" );

  foreach($standard_classes as $class) {
    include_once("$dir_classes/$class");
  }

  foreach($data_type_classes as $class) {
    include_once("$dir_classes/$class");
  }

  // benchmarking
  if( function_exists("endPTime") ) {
    endPTime("classes.php");
  }
}?>
