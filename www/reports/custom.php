<?
  /*
  **  REPORTS INDEX PAGE
  **  
  **  Shows menus for report generation
  **
  */
  
  
  include("reports_header.php");
  $page_title = tr("Admin Section");
  include("$libDir/nav.php");

   if( is_array($_POST) ) {
     extract($_POST);
   }
   if( $repid ) {
      $params = $zen->getReportParams($repid);
      if( !is_array($params) ) {
	$errs[] = tr("Report ID not found");
      }
      extract($params);
   }
   else if( $tempid ) {
     $params = $zen->getTempReport($tempid);
     if( !is_array($params) )
       $errs[] = tr("That temporary report doesn't exist");
     extract($params);
   }
 
   if( $errs ) {
     $zen->printErrors($errs);
   } else {
     include("$templateDir/reportsMenu.php");
   }

  include("$libDir/footer.php");

?>