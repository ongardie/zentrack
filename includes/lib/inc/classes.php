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

  /** 
   * @var array $classes_standard a list of the standard classes, 
   * these are assumed to always be included by the existing libs,
   * and should not require a call to {@link ZenUtils::prep()}
   */
  $classes_common = array(
                          "ZenUtils",     //should be first to get loaded
                          "Zen",
                          "ZenDatabase",
                          "ZenDataType",
                          "ZenDbSchema",
                          "ZenList",
                          "ZenMessage",
                          "ZenMessageList",
                          "ZenQuery",
                          "adodb/adodb.inc",
                          "smarty/Smarty.class");

  /** @var array $classes_data_types the DataType classes */
  $classes_data_types = array(
                            "ZenAccess",
                            "ZenAccessList",
                            "ZenAction",
                            "ZenActionList",
                            "ZenAttachment",
                            "ZenAttachmentList",
                            "ZenBin",
                            "ZenBinList",
                            "ZenFilter",
                            "ZenFilterList",
                            "ZenNotifyList",
                            "ZenParm",
                            "ZenParmList",
                            "ZenPriority",
                            "ZenPriorityList",
                            "ZenRole",
                            "ZenStage",
                            "ZenStageList",
                            "ZenSystem",
                            "ZenSystemList",
                            "ZenTask",
                            "ZenTaskList",
                            "ZenTicket",
                            "ZenTicketList",
                            "ZenRelatedList",
                            "ZenTrigger",
                            "ZenTriggerList",
                            "ZenType",
                            "ZenTypeList",
                            "ZenUser",
                            "ZenUserList" );

  /** @var array $classes_other the other/misc classes we don't use very often */
  $classes_other = array(
                         "ZenCriteriaSet",
                         "ZenDbTypeInfo",
                         "ZenDBXML",
                         "ZenEmail",
                         "ZenFormGenerator",
                         "ZenMetaDb",
                         "ZenMetaField",
                         "ZenMetaTable",
                         "ZenTemplate",
                         "ZenTranslator",
                         "ZenXMLParser"
                         );

  /** @var array $classes_all all available libraries */
  $classes_all = array_merge($classes_common, 
                             $classes_data_types, 
                             $classes_other);

  /** 
   * Loads classes into memory, checks each class to insure it hasn't been loaded already
   *
   * There are prepared lists of classes in this file as well, to assist in determining which to load
   * The standard classes and data types will be loaded in any page that includes the header.php or globals.php
   * utils
   *
   * @param array $set is a list of classes to load, they should have the file ext (.php)
   * @param string $location is the full path to the libraries
   */
  function load_classes( $set, $location ) {
    if( function_exists("startPTime") ) {
      startPtime("load_classes: ".count($set));
    }
    foreach($set as $class) {
      if( !class_exists($class) ) {
        include("$location/$class.php");
      }
    }
    if( function_exists("startPTime") ) {
      endPtime("load_classes: ".count($set));
    }
  }

  // benchmarking
  if( function_exists("endPTime") ) {
    endPTime("classes.php");
  }
}?>
