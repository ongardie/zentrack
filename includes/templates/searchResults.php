<?{
  
  include("$libDir/sorting.php");
  
  function searchResultsMaxPri( $a, $b ) {
    if( $a > $b ) { return $a; }
    return $b;
  }
  
  // integrity
  $params = array();
  $errs = array();
  
  //#####################################################
  //organize the date
  //#####################################################
  
  $search_dates = array();
  $view = 'search_form';
    
  // determine which bins user can view
  $userBins = $zen->getUsersBins($login_id);
  
  // organize the search params
  if( is_array($search_params) ) {
    foreach($search_params as $k=>$v) {
      if( !strlen($v) || is_array($v) && count($v) == 0 ) { continue; }
      if( is_array($v) && count($v) == 1 && !strlen($v[0]) ) { continue; }
      
      $props = getFmFieldProps($view, $k);
      if( !$props && preg_match('/^([a-zA-Z0-9_]+)_(begin|end)$/', $k, $matches) ) {
        $props = getFmFieldProps($view, $matches[1]);
      }
      $type = $props['data_type'];
      $zen->addDebug('searchResults.php', "Including search_param[$k] ($type)", 3);
      if( $type == 'boolean' && $field['num_rows'] == 1 ) {
        $params[] = array($k, ($v? "=":"!="), 1, 1);
        continue;
      }
      else if( $type == 'date' ) {
        // we process on the _begin dates, so skip _end
        if( strpos($k, '_end') > 0 ) { continue; }
        
        // determine the field name, sans the begin/end suffix
        $base = substr($k, 0, -6);

        // calculate the name of the end field
        $re = "{$base}_end";

        // check for bugs in the form contents... dates must all have an
        // _begin and _end field
        if( !preg_match('/_begin$/', $k) ) {
          $zen->addDebug('searchResults.php', "$k is a date, must have a {$k}_begin and {$k}_end", 1);
          continue;
        }
        
        // convert the user's string to a date integer
        $d1 = $zen->dateParse($v);
        // add to the search parms
        $params[] = array($base, ">=", $d1, 1);
        
        if( empty($search_params["$re"]) ) { 
          $zen->addDebug('searchResults.php', "$re not found, defaulting to $d1+86400", 3);
          $d2 = strtotime("+1 year", $d1); 
        }
        else { $d2 = $zen->dateParse($search_params["$re"]); }
        $params[] = array($base, "<=", $d2, 1);

        $search_dates[$k] = $d1;
        $search_dates[$re] = $d2;
      }
      else {
        $field = $map->getFieldFromMap($view, $k);
        $op = '=';
        if( $field['field_type'] == 'searchbox' ) {
          $v = split(' *, *', $v);
          $op = 'IN';
        }
        else if( is_array($v) ) {
          $op = 'IN';
        }
        switch($k) {
          case "priority":
            if( $or_higher ) {
              if( is_array($v) ) {
                $v = array_reduce($v, "searchResultsMaxPri");
              }
              $params[] = array($zen->table_tickets.".$k",'<=',$vh,1);
            }
            else {
              $params[] = array($zen->table_tickets.".$k",$op,$v,1);
            }
            break;
          case "bin_id":
            if( is_array($v) ) {
              $ok = true;
              foreach($v as $val) {
                if( !in_array($val, $userBins) ) {
                  $ok = false;
                  break;
                }
              }
              $params[] = array($k, 'IN', $v, 1);
            }
            else if( in_array($v, $userBins) ) {
              $params[] = array($k, '=', $v, 1);
            }
            else {
              $errs[] = tr('You do not have permission to search this bin'); 
            }
            break;  
          default:
            $params[] = array($k, $op, $v, 1);
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
      $zen->addDebug("searchResults.php", "Adding text search for $k", 3);
      $c = !(strpos($k, 'custom_text')===false && strpos($k,'description') === false);
      $sp[] = array($k,"contains",$search_text, $c);
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
    
    $limit = $nolimit? 0 : false;
    $tickets = $zen->search_tickets($params, "AND", "0", join(',',$orderby), $limit);//"status DESC, priority DESC"
  }
  
}?>