<?
  /**
   * Parses sorting data and stores in session
   * creates a single string which can be passed
   * to queries for sorting results.
   */

  $sm =& $zen->getSessionManager();
  $orderby  = $sm->find('ztorderby');
  if( !$orderby ) {
    $orderby = 'status DESC,priority DESC,otime DESC';
    $sm->store('ztorderby', $orderby);
  }
   
  if( $newsort ) {
    $vals = explode(",",$orderby);
    $ordervals = array( preg_replace('/[^0-9a-zA-Z_ ,]/', '', $newsort) );
    $count = 0;
    foreach($vals as $v) {
      if( ++$count > 3 ) { break; }
      if( $v != $newsort ) {
        $ordervals[] = $v;
      }
    }
    $orderby = join(",",$ordervals);
    $sm->store('ztorderby', $orderby);
  }

?>