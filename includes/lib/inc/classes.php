<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  // benchmarking
  startPTime("classes.php");

  /**
   * @package Libs
   *
   * Provides simple means of including the appropriate classes for each page.  The 
   * methods of interest are {@link getAllClasses} and {@link getCommonClasses}.
   */

  /** Includes the standard classes */
  function getStandardClasses() {
    return array(
                 "Zen.php",
                 "ZenDataType.php",
                 "ZenDatabase.php",
                 "ZenEmail.php",
                 "ZenFormGenerator.php",
                 "ZenList.php",
                 "ZenMessage.php",
                 "ZenMessageList.php",
                 "ZenMetaField.php",
                 "ZenMetaFieldList.php",
                 "ZenMetaTable.php",
                 "ZenMetaTableList.php",
                 "ZenQuery.php",
                 "ZenTemplate.php",
                 "ZenTranslator.php",
                 "ZenXMLParser.php",
                 "adodb/adodb.inc.php" );
  }

  /** Includes the DataType classes */
  function getDataTypeClasses() {
    return array(
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
  }

  /** Includes misc classes */
  function getOtherClasses() {
    return array( 
                 "ZenDBXML.php",
                 "db/DbTypeInfo.php" );
  }

  /** Runs through the list of classes and includes each one with require_once */
  function requireOnceClasses( $array ) {
    global $dir_classes;
    foreach($array as $class) {
      require_once("$dir_classes/$class");
    }
  }

  /** Includes all available classes */
  function includeAllClasses() {
    requireOnceClasses( getStandardClasses() );
    requireOnceClasses( getDataTypeClasses() );
    requireOnceClasses( getOtherClasses() );
  }

  /** Includes classes needed for most pages */
  function includeCommonClasses() {
    requireOnceClasses( getStandardClasses() );
    requireOnceClasses( getDataTypeClasses() );
  }

  if( isset($include_all_classes) && $include_all_classes == true ) {
    includeAllClasses();
  }
  else {
    includeCommonClasses();
  }

  // benchmarking
  endPTime("classes.php");
}?>
