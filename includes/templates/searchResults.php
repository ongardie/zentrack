<?{
  // set up search parms
  include("{$libDir}/prepareSearchVarfields.php");
  
  // integrity
  $params = array();
  $errs = array();
  
  //#####################################################
  //organize the date
  //#####################################################
  
  //opened date
  $search_dates = array();
  if (!empty($otime_begin)){
    $d1 = $zen->dateParse($otime_begin);
    $params[] = array("otime", ">=", $d1, 1);
    if (!empty($otime_end)){
      $d2 = $zen->dateParse($otime_end);
      $params[] = array("otime", "<=", $d2+86400, 1);
    }
    else {
      $d2 = $d1;
      $params[] = array("otime", "<=", $d2+86400, 1);
    }
    $search_dates['otime_begin'] = $d1;
    $search_dates['otime_end'] = $d2;
  }
  $otime_begin = null;
  $otime_end = null;
  
  //closed date
  if (!empty($ctime_begin)){
    $d1 = $zen->dateParse($ctime_begin);
    $params[] = array("ctime", ">=", $d1, 1);
    if (!empty($ctime_end)){
      $d2 = $zen->dateParse($ctime_end);
      $params[] = array("ctime", "<=", $d2+86400, 1);
    }
    else {
      $d2 = $d1;
      $params[] = array("ctime", "<=", $d2+86400, 1);
    }
    $search_dates['ctime_begin'] = $d1;
    $search_dates['ctime_end'] = $d2;
  }
  $ctime_begin = null;
  $ctime_end = null;
  
  // custom dates
  foreach( $varfieldsDates as $k=>$v ) {
    $kb = "{$k}_begin";
    $rb = "custom_$kb";
    $ke = "{$k}_end";
    $re = "custom_$ke";
    if( !empty($$rb) ) {
      $d1 = $zen->dateParse($$rb);
      $params[] = array($k, ">=", $d1, 1);
      if (!empty($$re)){
        $d2 = $zen->dateParse($$re);
        $params[] = array($k, "<=", $d2+86400, 1);
      }
      else {
        $d2 = $d1;
        $params[] = array($k, "<=", $d2+86400, 1);
      }
    }
    $search_dates[$kb] = $d1;
    $search_dates[$ke] = $d2;
  }
  
  //#####################################################
  //orderby checkin
  //#####################################################
  if ($orderby == "") {
    $orderby="status DESC, priority DESC";
  }
  
  // determine which bins user can view
  $userBins = $zen->getUsersBins($login_id);
  
  // organize the search params
  if( is_array($search_params) ) {
    foreach($search_params as $k=>$v) {
      if( strlen($v) ) {
        $type = getVarfieldDataType($k);
        if( $type == 'boolean' ) {
          $params[] = array($k, ($v? "=":"!="), 1, 1);
        }
        else {
          switch($k) {
            case "priority":
            $params[] = array($zen->table_tickets.".$k","<=",$v,1);
            break;
            case "bin_id":
            if( in_array($v, $userBins) ) {
              $params[] = array($k, '=', $v, 1);
            }
            else {
              $errs[] = tr('You do not have permission to search this bin'); 
            }
            break;
            default: 
            $params[] = array($k, "=", $v, 1);
            break;
          }
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
      $c = !(strpos($k, 'custom_text')===false && strpos($k,'description') === false);
      $sp[] = array($f,"contains",$search_text, $c);
    }
    $params[] = (count($sp)>1)? array("OR",$sp) : $sp[0];
  }
  
  if( !array_key_exists("bin_id", $params) ) {
    if( is_array($userBins) && count($userBins) ) {
      $params[] = array("bin_id","in",$userBins,1);
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
  if( !count($errs) ) {
    // debug
    unset($dp);
    foreach($params as $v) {
      $dp[] = "'".join("','",$v)."'";
    }
    $zen->addDebug("searchResults.php-params[]",join("|",$dp),3);
    
    $tickets = $zen->search_tickets($params, "AND", "0", $orderby);//"status DESC, priority DESC"
  }
  
}?>