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

  $graph = new zenGraph( "$libDir/reportConfig.php" );

  // retrieve the params of the report
  if( $tempid ) { $params = $zen->getTempReport($tempid); }
  else if( $repid ) { $params = $zen->getReportParams($repid); }
  if( !is_array($params) ) {
    die("report params incorrect, or id not found: $tempid/$repid");
  } 

  // create headings and labels
  $graph->graphTitle = $params["chart_title"];
  $graph->graphSubtitle = $params["chart_subtitle"];
  $graph->yHeading = "Y Heading";
  $graph->ySubHeading = "(In millions)";
  $graph->xHeading = "X Heading";
  $graph->xSubHeading = "(Fiscal Year 2001)";
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

  // set up the date configuration
  // and the xlabels
  if( $params["date_selector"] == "range" ) {
    $params["start_date"] = $zen->dateAdjust(-$params["date_value"], $params["date_range"]);
  }

  // create data set
  // calculate the compact
  // calculate the legend
  if( preg_match("@([a-z]+_)ID@", $params["report_type"], $matches) ) {
    $set_index = array();
    $n = "get_".strtolower($matches[1]);
    $key = $zen->get_table_id($n);
    foreach($params["data_set"] as $d) {
      $vals = $zen->$n($d);
      $k = $vals["$key"];
      switch($n) {
      case "user":
	$val = $zen->formatName($vals,1);
	break;
      default:
	$val = $vals["id"]; 
      }
      $set_index["$k"] = $val;
    }
  } else {
    $n = "get".ucfirst($params["report_type"])."s";
    $set_index = $zen->$n();
  }
  $params["data_set"] = explode(",",$params["data_set"]);
  $params["chart_options"] = explode(",",$params["chart_options"]);
  // set up layers
  $layer_params = array(
			"name" => "",
			"depth" => 10,
			"compact" => $compact,
			"gap"     => 20
			);
  $colors = $graph->getColorScheme();
  function scam_a_color(&$colors) {
    global $graph;
    if( count($colors) < 1 )
      $colors = $graph->getColorScheme();
    $color = array_shift($colors);
    return array($color);
  }
  /*
  ** ADD PIE CHARTS LATER
  if( $params["chart_type"] == "pie" ) {
    //    foreach($params["data_set"] as $d) {      
      $layer_params["name"] = $set_index["$d"];
      $graph->addLayer($layer_params);
      // loop through the elements and get the beef
      // total it up and make an element
      // the graph with the total of the elements
      //$vals = $zen->getSomething(*)
      //$total = array_sum($vals);
      //add $total to the data_array
      //add a legend entry (this is manual)
      $pieSettings = array(
			   "height"=>200,
			   "width"=>400,
			   "depth"=>30,
			   "gap"=>5,
			   "offsetStart"=>0
			   );      
      $data = array(rand(0,50),rand(0,50),rand(0,50),rand(0,50),rand(0,50),rand(0,50));//debug
      $name = $set_index["$d"];
      $graph->showFrame = 0;
      $graph->yLabels = array();
      $graph->xLabels = array();
      $graph->yHeading = "";
      $graph->xHeading = "";
      $graph->ySubHeading = "";
      $graph->xSubHeading = "";
      $graph->addData($data,$name,"pie","default",$pieSettings);
      //    }    
  } else {
  **
  */
    if( count($params["data_set"])>1 ) {
      $colors = $graph->getColorScheme("default-30");
      // make a multi-layered graph for each option
      foreach($params["chart_options"] as $c) {
	// create a layer
	$layer_params["name"] = ucwords(str_replace("_"," ",$c));
	$graph->addLayer($layer_params);
	// wheez da juice
	foreach($params["data_set"] as $d) {
	  // collect the data
	  // $data = ???
	  $data = array(rand(0,50),rand(0,50),rand(0,50),rand(0,50),rand(0,50),rand(0,50));//debug
	  $name = $set_index["$d"];

	  // calculate the step and the number to show
	  // calculate the compression

	  // build the graph
	  $graph->addData($data,$name,$params["chart_type"],scam_a_color($colors));
	}
      }
    } else if( count($params["chart_options"]) > 1 ) {
      // create a single layer graph with seperate bars/lines for each option
      $layer_params["name"] = ucwords(str_replace("_"," ",$c));
      $graph->addLayer($layer_params);
      foreach($params["chart_options"] as $c) {
	// wheez da juice
	// collect the data
	// $data = ???
	$data = array(rand(0,50),rand(0,50),rand(0,50),rand(0,50),rand(0,50),rand(0,50));//debug
	$name = $set_index["$d"];

	// calculate the step and the number to show
	// calculate the compression

	// build the graph
	$graph->addData($data,$name,$params["chart_type"],scam_a_color($colors));
      }      
    } else {
      // create a single layer graph with one data set to graph
      $layer_params["name"] = ucwords(str_replace("_"," ",$c));
      $graph->addLayer($layer_params);
      // collect the data
      // $data = ???
      $data = array(rand(0,50),rand(0,50),rand(0,50),rand(0,50),rand(0,50),rand(0,50));//debug
      $name = $set_index["$d"];

      // calculate the step and the number to show
      // calculate the compression

      // build the graph
      $graph->addData($data,$name,$params["chart_type"],scam_a_color($colors));
    }
    // }

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





