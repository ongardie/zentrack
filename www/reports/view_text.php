<?{

  /*
  **  REPORTS REPORT PAGE
  **  
  **  Creates report images
  **
  */
  
  include_once("./reports_header.php");

  // retrieve the params of the report
  if( $tempid ) { $params = $zen->getTempReport($tempid); }
  else if( $repid ) { $params = $zen->getReportParams($repid); }

  print "<pre>\n";
  print_r($params);
  print "</pre>\n";

}?>





