<?
 /**
  * Performs dynamic lookups for notification tables
  * and returns results as a string.
  *
  * Only works for local clients, enforced by using session ids.
  */

  include("../header.php");
  include_once("$libDir/libs/JSON.php");
  include_once("$libDir/ZenListBase.php");
  include_once("$libDir/ZenRecordBase.php");
  include_once("$libDir/ZenNotifyRecipient.php");
  include_once("$libDir/ZenNotifySearch.class.php");
  
  $json = new Services_JSON();
  
  $values = array();
  if( !empty($_GET['q']) ) {
    $list = new ZenNotifySearchList();
    $list->load( array($_GET['q']) );
    while(($u = $list->next()) !== false) {
      $values[] = $u->createDataArray();
    }
    if( empty($values) ) { $values = array("email"=>$_GET['q']); }
  }
  
  
  //todo strip all values and check for security problems
  //todo
  //todo
  //todo
  //todo
  //todo
  //todo
  //todo
  
  print $json->encode($values);
 
?>