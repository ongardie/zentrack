<?{

  /*
  **  REPORTS REPORT PAGE
  **  
  **  Creates report images
  **
  */
  
  include_once("./reports_header.php");

  include_once("$libDir/zen.class");
  include_once("$libDir/zenGraph.class");

  include_once("$libDir/reportDataParser.php");
  $chart_options = $params["chart_options"];

  $graph = new zenGraph( "$libDir/reportConfig.php" );
  $graph->debug = 0; // set this only if viewing the image directly

  // create headings and labels
  $graph->graphTitle = $params["chart_title"];
  $graph->graphSubtitle = $params["chart_subtitle"];
  $graph->yHeading = $params["report_type"];
  $graph->ySubHeading = "";
  $graph->xHeading = ucwords($params["date_range"]);
  $graph->xSubHeading = "";
  //  $graph->yLabels = '';

  // set system params
  $graph->colorBackground = $zen->settings["color_bars"];
  $graph->colorForeground = $zen->settings["color_bar_text"];
  $graph->colorGraphBackground = $zen->settings["color_background"];
  $graph->colorGraphForeground = $zen->settings["color_text"];
  $graph->colorXGuidelines = $zen->settings["color_text"]."-FB";
  $graph->colorYGuidelines = $zen->settings["color_text"]."-FB";
  $graph->titleColor = $zen->settings["color_text"];
  $graph->headingColor = $zen->settings["color_bar_text"];
  $graph->subHeadingColor = $zen->settings["color_bar_text"];
  $graph->labelColor = $zen->settings["color_text"];
  $graph->imageHeight = $zen->reportImageHeight;
  $graph->imageWidth = $zen->reportImageWidth;

  $graph->yMin = 0;

  if( count($date_labels) > 10 ) {
    $compact = 2;
  } else {
    $compact = 1;
  }
  $graph->xLabels = array(0=>"");
  for($i=$compact-1; $i<count($date_labels); $i+=$compact) {
    $graph->xLabels[] = $date_labels[$i];
  }

  // set up layers
  $layer_params = array(
			"name" => "",
			"depth" => 10,
			"gap"     => 20
			);
  if( $compact > 1 )
    $layer_params["compact"] = $compact;

  $colors = $graph->getColorScheme();
  function scam_a_color(&$colors) {
    global $graph;
    if( count($colors) < 1 )
      $colors = $graph->getColorScheme();
    $color = array_shift($colors);
    return array($color);
  }

  $colors = $graph->getColorScheme("default-30");
  if( count($params["data_set"]) > 1 && !$params["chart_combine"] ) {
    foreach($chart_options as $o) {
      if( count($chart_options) > 0 )
	$layer_params["name"] = $option_names["$o"];
      else
	$layer_params["name"] = "";
      $graph->addLayer($layer_params);
      foreach($params["data_set"] as $d) {
	$data = $data_array["$o"]["$d"];
	$name = $set_index["$d"];
	$graph->addData($data,$name,$params["chart_type"],scam_a_color($colors));
      }
    } 
  } else {
    foreach($params["data_set"] as $d) {
      $layer_params["name"] = "";//$set_index["$d"];
      $graph->addLayer($layer_params);
      foreach($chart_options as $o) {
	$data = $data_array["$o"]["$d"];
	$name = $option_names["$o"];
	$graph->addData($data,$name,$params["chart_type"],scam_a_color($colors));
      }
    }
  }

  // must add legend after data
  if( count($params["data_set"]) > 1 || count($params["chart_options"]) > 1 ) {
    $legendData = array("Title" => $params["report_type"],
			"Location" => "middle-right",
			"Transparency" => 0,
			"PointShape" => "diamond",
			"PointSize" => $zen->settings["font_size"]-2,
			"BorderThickness" => 2,
			"BorderColor" => $zen->settings["color_alt_text"],
			"BackgroundColor" => $zen->settings["color_title_background"],
			"ForegroundColor" => $zen->settings["color_title_txt"]);
    $graph->addLegend($legendData);
  }

  // draw the image
  $graph->drawGraph();

}?>
