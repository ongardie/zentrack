<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Provides global functions used by all pages
   *
   * @package Libs
   */

  // performance tracking
  $GLOBALS['ptimes']['functions.php'] = array( microtime(), null );

  /**
   * Loads a session or global variable(in that order), just a wrapper to make this quicker and easier
   *
   * @param string $name is the variable, or if in an array, the array it is in
   * @param string $var if the first value was an array, then this one can specify which value (null=whole array)
   */
  function getGlobal( $name, $var = null ) {
    return ZenUtils::findGlobal($name, $var);
  }

  /**
   * Retrieves an ini setting from the zen array
   *
   * @param string $section is the section in the ini file
   * @param string $name is the name of the setting, if null, returns entire section array
   * @return string
   */
  function getini( $section, $name = null ) {
    return ZenUtils::getIni($section, $name);
  }

  /**
   * Returns the unix timestamp representing the last config update
   */
  function lastConfigUpdate() {
    $file = getini('directories','dir_cache').'/last_config_update';
    if( !@file_exists( $file ) ) {
      touch($file);
    }
    return @filemtime( $file );
  }

  /**
   * Touched the last_config_update placeholder so that proper cache data will be updated
   */
  function configHasChanged() {
    @touch( getini('directories','dir_cache')."/last_config_upate" );
  }

  /**
   * Starts a new timer for performance tracking (stored for later retrieval)
   *
   * @param string $item is the name of the timer
   */
  function startPTime( $item ) {
    $GLOBALS['ptimes'][$item] = array( microtime(), null );
  }

  /**
   * Ends a time for performance tracking
   *
   * @param string $item is the name of the timer
   */
  function endPTime( $item ) {
    $GLOBALS['ptimes'][$item][1] = microtime();
  }

  /**
   * Parse a microtime to real time
   */
  function parsemicrotime( $micro ) {
    $p = explode(" ",$micro);
    return ((float)$p[0] + (float)$p[1]);
  }

  /**
   * Displays a microtime
   */
  function showmicrotime( $time ) {
    return number_format($time,3);
  }

  /**
   * Parses and returns difference of two microtimes
   */
  function diffmicrotimes($end, $start) {
    if( $start == '--' || $end == '--' ) { return '--'; }
    $s = parsemicrotime($start);
    $e = parsemicrotime($end);
    if( $e - $s < 0 ) { return "--"; }
    return showmicrotime($e - $s);
  }

  /**
   * Prints out performance times
   */
  function printPTimes() {
    endPTime( "total" );
    $base = parsemicrotime($GLOBALS['ptimes']['total'][0]);
    print "<table border='1' cellpadding='2'>\n";
    print "<tr><th colspan='4'>Performance Times<br>(seconds)</td></tr>\n";
    print "<tr><th>Section</th><th>Start</th><th>Stop</th><th>Elapsed</th></tr>\n";
    foreach( $GLOBALS['ptimes'] as $k=>$v ) {
      $s = is_null($v[0])? '--' : parsemicrotime($v[0]) - $base;
      $e = is_null($v[1])? '--' : parsemicrotime($v[1]) - $base;
      print "<tr>\n";
      // basics
      print "<td>$k</td><td>".showmicrotime($s)."</td><td>".showmicrotime($e)."</td>";
      // elapsed
      print "<td>".diffmicrotimes($v[1],$v[0])."</td>\n";
      print "</tr>\n";
    }
    print "</table>\n";
  }

  /**
   * Catch php errors and redirect them to the messageList
   */
  function zenErrorWrapper( $no, $message, $file, $line ) {
    Zen::debug( $file, $line, "$no: $message", 02, LVL_ERROR );
  }

  endPtime( "functions.php" );
}?>
