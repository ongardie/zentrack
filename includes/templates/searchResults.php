<?{

  // integrity
  unset($params);
  
  // organize the search params
  if( is_array($search_params) ) {
    foreach($search_params as $k=>$v) {
      if( strlen($v) ) {
	switch($k) {
	case "priority":
	  $params[] = array($k,"<=",$v,1);
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

  if( is_array($params) && !$params["binID"] ) {
    $bins = $zen->getUsersBins($login_id);
    if( is_array($bins) ) {
      $params[] = array("binID","in",$bins,1);
    } else {
      $errs[] = "You do not have access to any bins, a search was not authorized";
    }
  }

  if( !is_array($params) || !count($params) ) {
    // set an error message if there was no form data
    $errs[] = "No valid fields were provided to conduct a search";
  }

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
    $tickets = $zen->search_tickets($params, "AND");
  }

}?>
