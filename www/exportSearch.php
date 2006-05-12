<?
  include("header.php");
  
  //print "<pre>\n";  //debug
  $nolimit = 1;
  include("$templateDir/searchResults.php");

  // creates the csv file header, comment out for debugging
  //header("Content-type: application/vnd.ms-excel");
  
  //debug: fix these
  header("Content-disposition:  attachment; filename=".date("Y-m-d").".csv");
  header("Pragma: public");
  
  // creates readable column names
  function prepareColumnNames() {
    static $names;
    if( !isset($names) ) {
      $map = $GLOBALS['map'];
      $names = array();
      foreach( $map->listFieldsForView('search_export') as $k ) {
        if( !$map->getFieldProp('search_export', $k, 'is_visible') ) { continue; }
        $names[$k] = $map->getLabel('search_export', $k);
      }
    }
    return $names;
  }
  
  // print a readable value in place of database junk
  function humanReadableValue( $key, $val ) {
    global $map;
    return $map->getTextValue('search_export', $key, $val);
  }
  
  // iterate over an array of values and create a row of csv data
  function getCsvRow( $values, $headings = false ) {
    // skip empty rows
    if( !is_array($values) ) { return "\n"; }
    $text = "";
    $i=1;
    foreach(prepareColumnNames() as $k=>$l) {
      $v = $values[$k];

      // escape content for each cell
      if( !$headings ) { $v = humanReadableValue($k,$v); }
      $text .= getCsvCell($v);
      if( $i < count($values) ) {
        // print comma if this is not the last cell
        $text .= ",";
      }
      $i++;
    }
    // finish off row and return
    return $text."\n";
  }
  
  // escape content
  function getCsvCell( $text ) {
    // replaces " with ""
    // replaces \n with a space
    // encloses in quotes to fix commas
    return "\"".str_replace('"', '""', str_replace("\n", "|", str_replace("\r", "|", $text)))."\"";
  }
  
  if( is_array($tickets) && count($tickets) ) {
    // we have content
    
    // find out which bins this user can view
    $userBins = $zen->getUsersBins($login_id);
    
    // print column headings
    print "\n";
    print getCsvRow( prepareColumnNames(), true );
    print "\n";
    
    // print the ticket contents
    foreach($tickets as $t) {
      print getCsvRow($t);
    }
  }
  else {
    // we have no content
    print "\n,,,No results for your search\n";
  }
  
  //print "</pre>\n"; //debug
?>