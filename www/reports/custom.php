<?
  /*
  **  REPORTS INDEX PAGE
  **  
  **  Shows menus for report generation
  **
  */
  
  
  include("./reports_header.php");
  $page_tile = "Admin Section";
  include("$libDir/nav.php");

   if( is_array($_POST) ) {
     extract($_POST);
   }
   if( $repid ) {
      $params = $zen->getReportParams($repid);
      if( !is_array($params) ) {
	$errs[] = "Report ID not found";
      }
      extract($params);
   }
   else if( $tempid ) {
     $params = $zen->getTempReport($tempid);
     if( !is_array($params) )
       $errs[] = "That temporary report doesn't exist";
     extract($params);
   }
 
   if( $errs ) {
     $zen->printErrors($errs);
   } else {
     include("$templateDir/reportsMenu.php");
   }

  include("$libDir/footer.php");

?>