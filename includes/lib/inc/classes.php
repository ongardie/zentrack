<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Provides simple means of including the appropriate classes for each page. 
   *
   * @package Libs
   */

  // benchmarking
  if( function_exists("startPTime") ) {
    startPTime("classes.php");
  }

  /** @var array $classes_standard a list of the standard classes, these are included automagically when this page is called */
  $classes_standard = array(
                            "db/DbTypeInfo.php",
                            "Zen.php",
                            "ZenDatabase.php",
                            "ZenList.php",
                            "ZenMessage.php",
                            "ZenMessageList.php",
                            "ZenMetaField.php",
                            "ZenMetaTable.php",
                            "ZenMetaTableList.php",
                            "ZenQuery.php",
                            "ZenTemplate.php",
                            "ZenUtils.php",
                            "ZenXMLParser.php",
                            "adodb/adodb.inc.php" );

  /** @var array $classes_data_types the DataType classes */
  $classes_data_types = array(
                            "ZenDataType.php",
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

  /** @var array $classes_other the other/misc classes we don't use very often */
  $classes_other = array(
                         "ZenDBXML.php",
                         "ZenEmail.php",
                         "ZenFormGenerator.php",
                         "ZenTranslator.php"
                         );

  /** @var array $classes_all all available libraries */
  $classes_all = array_merge($classes_standard, $classes_data_types, $classes_other);

  /** 
   * Loads classes into memory, checks each class to insure it hasn't been loaded already
   *
   * There are prepared lists of classes in this file as well, to assist in determining which to load
   * The standard classes and data types will be loaded in any page that includes the header.php or globals.php
   * utils
   *
   * @param array $set is a list of classes to load, they should have the file ext (.php)
   * @param string $location is the full path to the libraries, if not provided, will search globals for ini settings
   */
  function load_classes( $set, $location ) {
    foreach($set as $class) {
      loadClass($class, $location);
    }
  }

  /**
   * Loads a single class into memory if it doesn't exist already
   *
   * If the location variable is not set, this method will attempt to divine the location by checking the ini settings ($GLOBAL or $_SESSION)
   *
   * @param string $name the name of class to be loaded
   * @param string $location is the full path to the libraries, if not provided, will search globals for ini settings
   */
  function loadClass( $name, $location ) { 
    $file = (strpos($name, '.') > 0)? $name : "$name.php";
    $name = (strpos($name, '.') > 0)? substr($name,0,-4) : $name;
    if( !class_exists( $name ) ) {
      include("$location/$file");
    }
  }

  // benchmarking
  if( function_exists("endPTime") ) {
    endPTime("classes.php");
  }
}?>
