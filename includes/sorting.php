<?
  /**
   * Parses sorting data and stores in session
   * creates a single string which can be passed
   * to queries for sorting results.
   */
   if( $_SESSION && array_key_exists('ztorderby',$_SESSION) ) {
     $orderby = $_SESSION['ztorderby'];
   }
   else {
     $orderby = 'status DESC,priority DESC,otime DESC';
   }
   
   $ordervals = explode(",",$orderby);
   if( $newsort ) {
     $vals = array();
     $ordervals = array( preg_replace('/[^0-9a-zA-Z_ ,]/', '', $newsort) );
     $count = 0;
     foreach($vals as $v) {
       if( ++$count > 3 ) { break; }
       if( $v != $newsort ) {
         $ordervals[] = $v;
       }
     }
     $orderby = join(",",$ordervals);
     $_SESSION['ztorderby'] = $orderby;
   }

?>