<?{

  /*
  **  REPORTS REPORT PAGE
  **  
  **  Creates report images
  **
  */
  
  include("reports_header.php");

  include("$libDir/zen.class");
  include("$libDir/zenGraph.class");

  $graph = new zenGraph( "$includesDir/reportConfig.php" );

  // retrieve the params of the report
  if( $tempid ) {
    $params = $zen->getTempReport($tempid);
  }
  else if( $repid ) {
    $params = $zen->getReportParams($repid);
  }
  if( !is_array($params) && false ) {
    die(tr("report params incorrect, or id not found") . ": $tempid/$repid");
  }
  $graph->graphTitle = "something";//$params["report_name"];
  $graph->graphSubtitle = "something";//$params["report_subtitle"];

  // create data set
  include("randomData.php");

  // set the system params
  $graph->yHeading = "";
  $graph->ySubHeading = "(In millions)";
  $graph->xHeading = "Month";
  $graph->xSubHeading = "(Fiscal Year 2001)";
  $graph->colorBackground = "#333333";//array(50,50,50);
  $graph->imageHeight = 500;
  $graph->imageWidth = 500;
  // customize the number of yLabels
  $graph->yLabels = array(-25,0,25,50,75,100,125,150,175);
  // create the layer
  $graph->addLayer( array(
			 "name" => "",
			 "depth" => 8,
			 "compact" => 6,
			 "gap"     => 20
			 ) );

  // add some data to plot
  $graph->addData( $data9,  "Green Apples", 'column', array('#009900') );
  $graph->addData( $data10, "Red Apples", 'stack',  array('#990000') );
  $graph->addData( $data11, "Blue Apples", 'stack',  array('#000099') );

  // must add legend after data
  $graph->addLegend(array("Title" => "Breakdown",
			  "Float" => array(100,100),
			  "Transparency" => 100,
			  "PointShape" => "diamond",
			  "PointSize" => 10,
			  "BorderThickness" => 2,
			  "BorderColor" => "#888888",
			  "BackgroundColor" => "#555555-55",
			  "ForegroundColor" => "#FFFFFF"));
  // draw the image
  $graph->drawGraph();

}?>





