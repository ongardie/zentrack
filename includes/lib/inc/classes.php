<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 
  startPTime("classes.php");

  // include all classes
  function getStandardClasses() {
    return array(
                 "Zen.class",
                 "ZenDataType.class",
                 "ZenDatabase.class",
                 "ZenEmail.class",
                 "ZenFormGenerator.class",
                 "ZenList.class",
                 "ZenMessage.class",
                 "ZenMessageList.class",
                 "ZenMetaField.class",
                 "ZenMetaFieldList.class",
                 "ZenMetaTable.class",
                 "ZenMetaTableList.class",
                 "ZenQuery.class",
                 "ZenTemplate.class",
                 "ZenTranslator.class",
                 "ZenXMLParser.class",
                 "adodb/adodb.inc.php" );
  }

  function getDataTypeClasses() {
    return array(
                 "ZenAccess.class",
                 "ZenAccessList.class",
                 "ZenAction.class",
                 "ZenActionList.class",
                 "ZenAttachment.class",
                 "ZenAttachmentList.class",
                 "ZenBin.class",
                 "ZenBinList.class",
                 "ZenFilter.class",
                 "ZenFilterList.class",
                 "ZenNotifyList.class",
                 "ZenPriority.class",
                 "ZenPriorityList.class",
                 "ZenRole.class",
                 "ZenStage.class",
                 "ZenStageList.class",
                 "ZenSystem.class",
                 "ZenSystemList.class",
                 "ZenTask.class",
                 "ZenTaskList.class",
                 "ZenTicket.class",
                 "ZenTicketList.class",
                 "ZenRelatedList.class",
                 "ZenTrigger.class",
                 "ZenTriggerList.class",
                 "ZenType.class",
                 "ZenTypeList.class",
                 "ZenUser.class",
                 "ZenUserList.class" );
  }

  function getOtherClasses() {
    return array( 
                 "ZenDBXML.class",
                 "db/DbTypeInfo.class" );
  }

  function requireOnceClasses( $array ) {
    global $dir_classes;
    foreach($array as $class) {
      require_once("$dir_classes/$class");
    }
  }

  function includeAllClasses() {
    requireOnceClasses( getStandardClasses() );
    requireOnceClasses( getDataTypeClasses() );
    requireOnceClasses( getOtherClasses() );
  }

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

  endPTime("classes.php");
}?>
