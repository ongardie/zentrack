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

  // for now, we need a hack to match all to hours
  // later, may want to convert everything to $zen->elapsed_unit
  // instead
  $zen->elapsed_unit = "hours";

  include_once("$libDir/reportDataParser.php");
  $chart_options = $params["chart_options"];

  $graph = new zenGraph( "$libDir/reportConfig.php" );
  $graph->debug = 0; // set this only if viewing the image directly

  // create headings and labels
  $graph->graphTitle = $params["chart_title"];
  $graph->graphSubtitle = $params["chart_subtitle"];
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
  $graph->valueFontColor = $zen->settings["color_text"];
  $graph->yMin = 0;
  if( $params["show_data_vals"] > 0 ) {
    $graph->showValueOnGraph = 1;
  }

  $graph->yHeading = $y_heading;
  if( $y_2_set && count($y_2_set) ) {
    $graph->ySubHeading = "($y2_set_type on right axis)";
    $graph->y2Labels = $y_2_set;
  }

  // change the font angle if we have a lot
  // of stuff to graph, so it will fit better
  if( $params["chart_type"] == "column" 
	&& count($date_labels) * count($set_index) > 25 )
	$graph->valueFontAngle = 90;

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
			"name"    => "",
			"depth"   => 10,
			"gap"     => 20
			);

  // set up a method for getting unique colors
  // to show elements with
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
  // set up a method for getting shapes to show
  // the items with
  $point_shapes = array("diamond","square","dot","triangle","plus","strike");
  $curpoint = 0;
  function scam_a_shape() {
    global $curpoint;
    $shape = $point_shapes[$curpoint];
    $curpoint++;
    if( $curpoint == count($point_shapes) )
      $curpoint = 0;
    return $shape;
  }

  $colors = $graph->getColorScheme("default-30");
  if( count($params["data_set"]) > 1 && !$params["chart_combine"] ) {
    foreach($chart_options as $o) {
      if( isset($y2_set_type) && $y2_set_type != "" ) {
	if( ($y2_set_type == "Hours" && in_array($o,$rows_hours))
	    ||
	    ($y2_set_type == "Quantity" && in_array($o,$rows_count))
	    )
	  $xoptions = array("y2scale"=>1);
	else
	  $xoptions = null;
     } else {
       $xoptions = null;
     }
      if( $params["chart_type"] == "scatter" ) {
	if( !is_array($xoptions) )
	  $xoptions = array();
	$xoptions["pointShape"] = scam_a_shape();
      }
      if( count($chart_options) > 0 )
	$layer_params["name"] = $option_names["$o"];
      else
	$layer_params["name"] = "";
      $graph->addLayer($layer_params);
      foreach($params["data_set"] as $d) {
	$data = $data_array["$o"]["$d"];
	$name = $set_index["$d"];
	$graph->addData($data,$name,$params["chart_type"],
			scam_a_color($colors),$xoptions);
      }
    } 
  } else {
    foreach($params["data_set"] as $d) {
      $layer_params["name"] = "";//$set_index["$d"];
      $graph->addLayer($layer_params);
      $ashape = scam_a_shape();
      foreach($chart_options as $o) {
	if( isset($y2_set_type) && $y2_set_type != "" ) {
	  if( ($y2_set_type == "Hours" && in_array($o,$rows_hours))
	      ||
	      ($y2_set_type == "Quantity" && in_array($o,$rows_count))
	      )
	    $xoptions = array("y2scale"=>1);
	  else
	    $xoptions = null;
	} else {
	  $xoptions = null;
	}
	if( $params["chart_type"] == "scatter" ) {
	  if( !is_array($xoptions) )
	    $xoptions = array();
	  $xoptions["pointShape"] = $ashape;
	}
	$data = $data_array["$o"]["$d"];
	$name = $option_names["$o"];
	$graph->addData($data,$name,$params["chart_type"],
			scam_a_color($colors),$xoptions);
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