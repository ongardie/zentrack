
<?{
	
  // integrity
  unset($params);
  
	//#####################################################
	//organize the date
	//#####################################################
	//start date
	if (!empty($date)){
	  $search_params["otime"] = $zen->dateParse(strip_tags($date));
	  $search_params["otime_end"] = $search_params[otime] + 86400;
	}
	   
  	//begin date
  	if (!empty($begin)){
	  $search_params["begin"] = $zen->dateParse(strip_tags($begin));
	}
		
    //end date
    if (!empty($end)){
	  $search_params["end"] = $zen->dateParse(strip_tags($end)) + 86400;
	}
	$date = NULL;
	$begin = NULL;
	$end = NULL;
  
 	//#####################################################
  	//orderby checken
  	//#####################################################
  	if ($orderby == "") {
	  $orderby="status DESC, priority DESC";
 	}
  
  // organize the search params
  if( is_array($search_params) ) {
    foreach($search_params as $k=>$v) {
      if( strlen($v) ) {
	switch($k) {
	case "priority":
	  $params[] = array($zen->table_tickets.".$k","<=",$v,1);
	  break;
	case "otime":
	  $params[] = array("otime", ">=",$v,1);
	  break;
	case "otime_end":
	  $params[] = array("otime", "<=",$v,1);
	  break;
	case "begin":
	  $params[] = array("otime", ">=",$v,1);
	  break;
	case "end":
	  $params[] = array("otime", "<=",$v,1);
	  break;
	default: 
	  $params[] = array($k,"=",$v,1);
	  break;
	}
      }
    }
  }

  // see if there is a text search and
  // if so, then see what fields are to
  // be searched
  if( $search_text && is_array($search_fields) && count($search_fields)>0 ) {
    unset($sp);
    foreach($search_fields as $k=>$f) {
      $sp[] = array($f,"contains",$search_text);
    }
    $params[] = (count($sp)>1)? array("OR",$sp) : $sp[0];
  }

  if( is_array($params) && !$params["bin_id"] ) {
    $bins = $zen->getUsersBins($login_id);
    if( is_array($bins) ) {
      $params[] = array("bin_id","in",$bins,1);
    } else {
      $errs[] = tr("You do not have access to any bins.")." ".tr("A search was not authorized");
    }
  }

  if( !is_array($params) || !count($params) ) {
    // set an error message if there was no form data
    $errs[] = tr("No valid fields were provided to conduct a search");
  }

  $tickets = null;

  // if there are any search params
  // then perform the query
  if( !is_array($errs) ) {
    // debug
    unset($dp);
    foreach($params as $v) {
      $dp[] = "'".join("','",$v)."'";
    }
    $zen->addDebug("searchResults.php-params[]",join("|",$dp),3);
    // debug
    $tickets = $zen->search_tickets($params, "AND","0",$orderby);//"status DESC, priority DESC"
  }
}?>
    