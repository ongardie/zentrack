<?php
  define("ZT_SECTION", "api");
  $indexDir = dirname(dirname(__FILE__));
  include_once("$indexDir/header.php");
  include_once("$libDir/ZenHttpApi.php");
  
  $api = ZenHttpApi::getInstance('xml');
  print $api->doAction( $api->getAlphanumParm('action', true) );
?>
