<?
  /**
   * Parses sorting data and stores in session
   * creates a single string which can be passed
   * to queries for sorting results.
   */
   
  $sm =& $zen->getSessionManager();
  $orderby  = $sm->find('ztorderby');
  if( !$orderby ) {
    $orderby = array('status DESC','priority DESC','otime DESC');
    $sm->store('ztorderby', $orderby);
  }
  
  if( $newsort ) {
    // make sure our sorting field is valid
    $tempsort = strpos($newsort, " DESC") > 0?
        str_replace(" DESC", "", $newsort) : $newsort;
    if( !array_key_exists($tempsort, $GLOBALS['zt_field_dependencies']['fields']) ) {
      $zen->addDebug('sorting.php', "Invalid column '$tempsort'", 1);
      $newsort = false;
    }
  }
   
  if( $newsort ) {
    // if we have a valid sorting field, drop it into our stuff.
    $ordervals = array( preg_replace('/[^0-9a-zA-Z_ ]/', '', $newsort) );
    $count = 0;
    foreach($orderby as $v) {
      if( ++$count > 3 ) { break; }
      $ok = true;
      if( $v == $newsort ) { $ok = false; }
      else if( strpos($v, " DESC") > 0 ) {
        if( $newsort." DESC" == $v ) { $ok = false; }
      }
      else {
        if( $v." DESC" == $newsort ) { $ok = false; }
      }
      if( $ok ) { $ordervals[] = $v; }
    }
    $orderby = $ordervals;
    $sm->store('ztorderby', $orderby);
    $zen->addDebug("sorting.php", "search order set to ".join(',',$orderby),2);
  }

?>