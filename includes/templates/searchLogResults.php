<?{

  // integrity
  unset($params);
  
  // organize the search params
  if( is_array($search_params) ) {
    foreach($search_params as $k=>$v) {
      if( strlen($v) ) {
	$params[] = array($k,"=",$v,1);
      }
    }
  }

  // see if there is a text search and
  // if so, then see what fields are to
  // be searched
  if( $search_text ) {
    $params[] = array("entry","contains",$search_text);
  }

  // see if there is a date to limit search
  // by, and if so, calculate the date
  if( $search_date ) {
    // get a date timestamp for midnight $search_date days before now
    $date = $zen->dateAnchor( "day", $zen->dateAdjust(-$search_date,"days") );
    $params[] = array("created",">=",$date);
  }

  // if there are any search params
  // then perform the query
  if( is_array($params) && count($params) ) {
    // debug
    unset($dp);
    foreach($params as $v) {
      $dp[] = "'".join("','",$v)."'";
    }
    $zen->addDebug("searchResults.php-params[]",join("|",$dp),3);
    // debug
    $logs = $zen->search_logs($params, "AND");
  } else {
    // set an error message
    $errs[] = tr("No valid fields were provided to conduct a search");
  }

}?>
