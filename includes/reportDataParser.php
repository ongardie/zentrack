<?

// retrieve the params of the report
if( $tempid ) { $params = $zen->getTempReport($tempid); }
else if( $repid ) { $params = $zen->getReportParams($repid); }

if( is_array($params) ) {
  $report_type = $params["report_type"];
  $params["data_set"] = explode(",",$params["data_set"]);
  $params["chart_options"] = explode(",",$params["chart_options"]);

  $zen->addDebug("reportDataParser",
	"Report generated with id: {$params['report_id']}",2);
  
  // set up the date configuration
  // and the xlabels
  if( !$params["date_low"] || $params["date_selector"] == "range" ) {
    $today = $zen->dateAnchor("day");
    $params["date_low"] = $zen->dateAdjust(-$params["date_value"], 
					   $params["date_range"],$today);
  }
  // create data set
  // calculate the compact
  // calculate the legend
  if( preg_match("@([a-z]+) ID@i", $params["report_type"], $matches) ) {
    $set_index = array();
    $n = "get_".strtolower($matches[1]);
    $type_column = str_replace(" ","_",strtolower($params["report_type"]));
    $tbl_column = $zen->get_table_id(strtolower($matches[1]));
    foreach($params["data_set"] as $d) {
      $vals = $zen->$n($d);
      $k = $vals["$tbl_column"];
      if( $d == "user" ) {
	$val = $zen->formatName($vals,1);
      } else {
	$val = substr($vals["title"],0,20);
      }
      $set_index["$k"] = $val;
    }    
  } else {
    $n = "get".ucfirst($params["report_type"])."s";
    $set_index = $zen->$n();
    $type_column = strtolower($params["report_type"])."_id";
  }
  $date_set = array();
  $date_labels = array();
  $step = ($params["date_value"] >= 20)?
    ceil($params["date_value"]/10) : 1;
  $end_date = $zen->dateAdjust($params["date_value"],$params["date_range"],
			       $params["date_low"]);
  for($i=0; $i<$params["date_value"]; $i+=$step) {
    $cdate = ($i>0)? 
      $zen->dateAdjust($i,$params["date_range"],$params["date_low"]) : 
      $params["date_low"];
    $edate = $zen->dateAdjust($step,$params["date_range"],$cdate);
    if( $edate > $end_date ) {
      $edate = $end_date;
      $i = $params["date_value"]+1;     
    }
    $sub = strtolower(substr($params["date_range"],0,2));
    if( $sub == "da" ) {
      $key = strftime("%a %D",$cdate);
    } else if( $sub == "mo" ) {
      $key = strftime("$b $D",$cdate);
    } else if( $sub == "ye" ) {
      $key = strftime("%Y",$cdate);
    } else if( $sub == "ho" || $sub == "mi" ) {
      if( $params["date_value"] > 24 ) {
	$key = strftime($zen->date_fmt_short." ".$zen->time_fmt,$cdate);
      } else {
	$key = strftime($zen->time_fmt,$cdate);
      }
    } else {
      $key = " $i";
    }
    $date_set[] = array($cdate,$edate);
    $date_labels[] = $key;
  }

  if( $params["chart_combine"] > 0 ) {
    $params["data_set"] = array($params["data_set"]);
    $set_index["Array"] = "Combined ".$report_type."s";
  }
  
  $data_array = array();
  $rows_count = array();
  $rows_hours = array();
  foreach($params["chart_options"] as $o) {
    // activity
    // count
    // hours_actual
    // hours_estimated
    // time  
    switch($o) {
    case "activity":
      $fcall = "reportActivity";
      $date1 = "created";
      $date2 = "created";
      $rows_count[] = $o;
      break;
    case "count":
      $fcall = "reportTickets";
      $date1 = "ctime";
      $date2 = "otime";
      $rows_count[] = $o;
      break;
    case "hours_estimated":
      $fcall = "reportEstimated";
      $date1 = "ctime";
      $date2 = "otime";
      $rows_hours[] = $o;
      break;
    case "hours_actual":
      $fcall = "reportHours";
      $date1 = "created";
      $date2 = "created";
      $rows_hours[] = $o;
      break;
    case "time":
      $fcall = "reportElapsed";
      $date1 = "ctime";
      $date2 = "otime";
      $rows_hours[] = $o;
    }
    foreach($params["data_set"] as $d) {      
      if( $params["report_type"] == "Project ID" ) {
	$vars = $zen->getProjectChildren($d);
	$type_column = "ticket_id";
	if( is_array($vars) ) {
	  $vals = array();
	  foreach($vars as $v) {
	    if( in_array($v["type_id"],$zen->projectTypeIDs()) ) {
	      $nvars = $zen->getProjectChildren($v["id"]);
	      if( is_array($nvars) ) {
		$vals = array_merge($vals,$nvars);
	      }
	    } 
	    $vals[] = $v["id"];
	  }
	} else {
	  $vals = array(-1);
	}
	$sprms = array("$type_column"=>array("l.$type_column","IN",$vals));
      } else {
	$sprms = (is_array($d))?
	  array("$type_column"=>array("l.$type_column","IN",$d)):
	  array("$type_column"=>array("l.$type_column","=",$d));
      }
      foreach($date_set as $ds) {
	if( $ds[0] ) {
	  if( $date1 == "ctime" ) {
	    $sprms["date1"] = array("OR",array(
					       array("l.$date1","IS","NULL"),
					       array("l.$date1",">=",$ds[0])));
	  } else {
	    $sprms["date1"] = array("l.$date1",">=",$ds[0]);
	  }
	}
	if( $ds[1] ) {
	  if( $date2 == "ctime" ) {
	    $sprms["date2"] = array("OR",array(
					       array("l.$date2","IS","NULL"),
					       array("l.$date2","<",$ds[1])));
	  } else {
	    $sprms["date2"] = array("l.$date2","<",$ds[1]);
	  }
	}
	$data_array["$o"]["$d"][] = $zen->$fcall($sprms);
      }
    }
  }
  // check for 2 y axis
  if( count($rows_count) && count($rows_hours) ) {
    // get max of each axis
    $mc = 0;
    $mh = 0;
    foreach($rows_count as $o) {
      foreach($data_array["$o"] as $d=>$vals) {
	foreach($vals as $v) {
	  if( $v > $mc ) {
	    $mc = $v;
	  }
	}
      }
    }
    foreach($rows_hours as $o) {
      foreach($data_array["$o"] as $d=>$vals) {
	foreach($vals as $v) {
	  if( $v > $mh ) {
	    $mh = $v;
	  }
	}
      }
    }    
    // round the values
    $mh = ceil($mh/10)*10;
    $mc = ceil($mc/10)*10;
    // create the y2labels
    // if they aren't equal
    if( $mh != $mc ) {
      $y_2_set = array();
      if( $mc < 10 && $mh >= 10 )
	$mc = 10;
      else if( $mh < 10 && $mc >= 10 )
	$mh = 10;
      $v = ($mh > $mc)? $mc : $mh;
      for($i=0; $i<=5; $i++) {
	if( $i == 0 )
	  $n = 0;
	else
	  $n = round($v/5*$i,1);
	$y_2_set[] = $n;
      }      
      if( $mh > $mc ) {
	$y_heading = "Hours";
	$y2_set_type = "Quantity";     
      } else {
	$y_heading = "Quantity";
	$y2_set_type = "Hours";
      }
    } else {
      $y_heading = "Hours/Quantity";
    }
  } else {
    $y_heading = (count($rows_count))? "Quantity" : "Hours";
  }
}
    
?>
