<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Includes common utils for processing.  This page should be static
 * and should not depend on any other files.
 */

/**
 * Provides a means to include helper files globally (rather than internal to the {@link runHelper()} function.
 *
 * This method will generate the correct helper file to include based on the function name.
 *
 * @param string $function the name of the function to be run
 */
function includeHelper( $function ) {
  if( !function_exists($function) ) {
    $file = ZenUtils::getIni('directories','dir_helpers')."/"
      .preg_replace('/([^_]+)_([^_]+)_.*$/', "\\1_\\2", $function).'.php';
    if( @file_exists($file) ) {
      include_once($file);
    }
  }
}
 
/** 
 * LVL_NONE for ZenMessage: specifies no output
 */
define("LVL_NONE", 0);

/** 
 * LVL_ERROR for ZenMessage: specifies highest error level (minimal output)
 */
define("LVL_ERROR", 1);

/** 
 * LVL_WARN for ZenMessage: specifies warnings
 */
define("LVL_WARN", 2);

/** 
 * LVL_NOTE for ZenMessage: specifies general notices (good for most stuff)
 */
define("LVL_NOTE", 3);

/** 
 * LVL_INFO alias for LVL_NOTE
 */
define("LVL_INFO", 3);

/** 
 * LVL_DEBUG for ZenMessage: specifies lowest error level (maximum output, very verbose)
 */
define("LVL_DEBUG", 4);

/** 
 * Utility functions (all static, call with ZenUtils::method())
 *
 * Methods in this class shall not depend on $GLOBALS or any other external source for function
 *
 * @package Utils
 */
class ZenUtils {

  /**
   * STATIC: Takes a data type and returns the primary key of that table field
   *
   * This method will validate the class type using is_a to see if it is a valid ZenList
   * or ZenBase child (extends one of these)
   *
   * @static
   * @param mixed $class is class object ($this reference) or string containing classname
   * @return string the name of the primary key column
   */
  function getPrimaryKey( $class ) {
    return ZenUtils::tableNameFromClass($class)."_id";
  }

  /**
   * STATIC: Attempts to locate a global value either in $_SESSION or $GLOBALS
   *
   * @static
   * @param string $key is the variable to search for
   * @param string $sub is an element of the $key array (if needed)
   * @return mixed value found or null if none
   */
  function findGlobal( $key, $sub = null ) {
    if( isset($_SESSION) && isset($_SESSION[$key]) ) {
      return ($sub)? $_SESSION[$key][$sub] : $_SESSION[$key];
    }
    else if( isset($GLOBALS) ) {
      return ($sub)? $GLOBALS[$key][$sub] : $GLOBALS[$key];
    }
    else { return null; }
  }

  /**
   * Attempts to locate a value submitted by a form or url.
   * 
   * Checks $_POST and then $_GET for the param in question and returns
   * the value
   *
   * @return mixed value of the post data
   */
  function getFormData( $key ) {
    if( isset($_POST) && isset($_POST[$key]) ) {
      return $_POST[$key];
    }
    else if( isset($_GET) && isset($_GET[$key]) ) {
      return $_GET[$key];
    }
    else { return null; }
  }

  /**
   * STATIC: Returns the parsed ini file array
   * <p>Retrieval is done as follows:
   * <ol>
   *    <li>Check <code>$_SESSION</code>
   *    <li>Check <code>$_GLOBALS</code>
   *    <li>Find <code>$file</code> and parse (assuming one was provided)
   * </ol>
   *
   *
   * @static
   * @param string $file full directory path to ini file (optional), only used if ini file not found in session or memory
   * @return Array containing parsed zen.ini directives organized by category
   */
  function findIni( $file = null ) {
    if( !empty($_SESSION) && !empty($_SESSION['zen']) ) {
      return $_SESSION['zen'];
    }
    if( !empty($GLOBALS) && !empty($GLOBALS['zen']) ) {
      return $GLOBALS['zen'];
    }
    if( $file ) {
      if( !file_exists($file) ) {
        return null;
      }
      $GLOBALS['zen'] = ZenUtils::read_ini($file);
      return $GLOBALS['zen'];
    }
    return null;
  }

  /**
   * STATIC: Searches the global arrays for zen.ini file data  and returns indexed value
   *
   * @static
   * @param String $category is the ini file category to look in
   * @param String $property is the ini file property to retrieve (if omitted, returns entire category)
   * @return mixed value
   * @see ZenUtils::findIni()
   */
  function getIni( $category, $property = null ) {
    $ini = ZenUtils::findIni();
    if( !is_array($ini) ) { return null; }
    else if( !strlen($property) ) { 
      return isset($ini[$category])? $ini[$category] : null;
    }
    else { 
      return isset($ini[$category][$property])? $ini[$category][$property] : null;
    }
  }

  /**
   * STATIC: Returns the name of the db table corresponding to this class object
   *
   * @static
   * @param mixed $class is a $this object reference or a string containing class name
   * @param string name of table or false if none
   */
  function tableNameFromClass( $class ) { 
    $cname = strtolower(is_object($class)? get_class($class) : $class);
    // remove Zen from beginning of name
    if( strpos( $cname, "zen" ) === 0 ) {
      $cname = substr($cname, 3);
    }
    // remove .class or .php from end if necessary
    if( strpos( $cname, "." ) ) {
      $cname = substr($cname, 0, strpos($cname, '.') );
    }
    
    // remove List from end if necessary
    if( strpos( $cname, 'list' ) == strlen($cname)-4 ) {
      $cname = substr($cname, 0, -4);
    }
    return $cname;
  }

  /**
   * STATIC: Returns the name of a class corresponding to a db table
   *
   * @static
   * @param string $table name of the db table
   * @return string full class name corresponding to table or false if none
   */
  function classNameFromTable( $table ) { 
    // return with proper case and Zen prefix
    return "Zen".ucfirst(strtolower($table));
  }

  /**
   * STATIC: returns a ZenDataType object from a table name and an id
   *
   * @static
   * @param string $table
   * @param integer $id
   */
  function getDataType( $table, $id ) {
    $class = ZenUtils::classNameFromTable($table);
    if( !class_exists($class) ) {
      ZenUtils::safeDebug("ZenUtils", "getDataType", "Class $class not found for table $table, unable to create", 105, LVL_WARN);
      return null;
    }
    return new $class($id);
  }

  /**
   * STATIC: Takes a simple array and returns an associative array in the form key=>value
   *
   * @static
   * @param array $vals the simple array to get data from
   * @param string|int $key is the field to use for the key
   * @param string|int $val is the field to use for val, if this is omitted, then whole array goes in val spot
   */
  function keySet( $vals, $key, $val = null ) {
    $newvals = array();
    for($i=0; $i<count($vals); $i++) {
      if( isset($vals[$i]) && is_array($vals[$i]) ) {
        if( isset($vals[$i][$key]) && strlen($vals[$i][$key]) ) {
          $k = $vals[$i][$key];
          $v = ($val)? $vals[$i][$val] : $vals[$i];
          $newvals[$k] = $v;
        }
      }
    }
    return $newvals;
  }

  /**
   * STATIC: Flatten an multi-dimensional associative array to depth of 1
   *
   * Note that any variables in sub-arrays will overwrite the base values
   *
   * @static
   * @param array $vals is a multi-dimensional associative array
   * @return array a single dimension associative array
   */
  function flatten_array( $vals ) {
    $newvals = array();
    foreach($vals as $key=>$val) {
      if( is_array($val) ) {
        $newvals = array_merge($newvals, ZenUtils::flatten_array($val));
      }
      else {
        $newvals[$key] = $val;
      }
    }
    return $newvals;
  }

  /**
   * STATIC: Prints an array out as formatted text (debug utility)
   *
   * @static
   * @param array $vals can be key/value, multi-level, etc
   * @param string $title printed as title of array
   * @return boolean true if the object was valid and printed
   */
  function printArray( $vals, $title = null ) {
    if( $title ) { print "<p><b>$title</b><div style='font-size:11px'>\n"; }
    if( !is_array($vals) ) { print "<p style='color:red'>-not_array-</p>"; }
    print "<pre>\n";
    print_r($vals);
    print "</pre>\n";
    if( $title ) { print "</div></p>\n"; }
    return true;
  }

  /**
   * STATIC: safely check for equality of two values when type is unsure
   *
   * This method can accurately compare nulls, values which are not set,
   * Objects and most other things accurately.
   *
   * @static
   * @param mixed $val1
   * @param mixed $val2
   * @return boolean
   */
  function safeEquals( $val1, $val2 ) {
    if( !isset($val1) xor !isset($val2) ) {
      // if only one is set
      return false;
    }
    else if( is_array($val1) && is_array($val2) ) {      
      return ZenUtils::arrayEquals($val1, $val2);
    }
    else if( $val1 != $val2 || strlen($val1) != strlen($val2) ) {
      return false;
    }
    return true;
  }

  /**
   * STATIC: Recursively checks values of two arrays for equality
   *
   * @static
   * @param array $arr1
   * @param array $arr2
   * @return boolean
   */
  function arrayEquals( $arr1, $arr2 ) {
    foreach( $arr1 as $key=>$val ) {
      if( !isset($arr2[$key]) ) {
        // don't try to test if arr2[key] isn't set or causes warnings
        // so see if val isset
        if( isset($val) ) {
          return false;
        }
        continue;
      }
      if( !ZenUtils::safeEquals($val, $arr2[$key]) ) {
        return false;
      }
    }
    return true;
  }

  /**
   * STATIC: Formats a value for display in forms
   *
   * @static
   * @param String $text
   * @return String containing formatted text for use in <input..> and <textarea> fields
   */
  function ffv( $text ) { 
    // converts special characters to ascii codes
    // to be used in <input> fields
    if( strlen($text) ) {
      return htmlspecialchars($text,ENT_QUOTES);
    }
    return $text;
  }

  /**
   * STATIC: Cleans a block of pre-formatted text entered by user
   *
   * Specifically for use with the ticket details and logs
   * This will create links out of proper url entries, and
   * preserve spacing, etc.  All html tags will be printed
   * as source.
   * 
   * May also be useful for emails
   *
   * @static
   * @param String $text is the text to display
   * @return String containing formatted text for display in &lt;pre&gt; tags or emails
   */
  function fixPreformattedBlock( $text ) { }

  /**
   * STATIC: Parses a date into a unix timestamp (necessary since strtotime() is beginning to fall short here)
   *
   * This method will parse european date formats if boolean is enabled (note this will interfere with american dates)
   * In general, when calling this method, the config setting for euro dates should be checked and included.
   *
   * @static
   * @param string $date is the date string to parse
   * @return integer unix timestamp representative of date or false if date was invalid
   */
  function parseDate( $date, $eurodates = false ) {
    // clean
    $date = trim($date);

    // validate
    if( !strlen($date) ) { return false; }

    // separator to parse euro date
    $sep = '[/.,-]';

    // if we have eurodate = true and the date is in the format dd/mm/yy[yy] then parse as euro
    if( $eurodates && preg_match("#[0-9]{2}{$sep}[0-9]{2}{$sep}[0-9]{2,4}#", $date) ) {
      // split date and time
      list($date, $time) = explode(' ', $date);
      // break up date
      list($day, $month, $year) = split($sep, $date);
      // break up time
      list($hours, $mins, $seconds) = explode(':', $time);
      // create a unix timestamp and return
      return mktime($hours, $mins, $seconds, $month, $day, $year);
    }
    // otherwise it's english to treat it so
    else {
      return strtotime($date);
    }
  }

  /**
   * STATIC: Determines if a date lies on the interval of a date range
   *
   * Note that for very decicate calculations one should consider that this
   * method will ignore the subtle diffs that may occur because of timezones..
   * for instance.. if the time drops back an hour.. and that causes the new hour
   * to fall on an interval of the base, should this be considered valid? should the
   * base know somehow to know do this event at 4pm instead of 3pm? probably not.
   * most likely the event should happen on the same hour, so this method just ignores
   * such details by default, which is probably right 99.9% of the time.
   *
   * @static
   * @param integer $utime the unix timestamp to compare
   * @param integer $step the increment of our interval (every $step periods)
   * @param string $period is the period traversed (seconds,minutes,hours,days,weeks,months,quarters,years)
   * @param integer $base is any unix timestamp occuring on the desired interval
   * @return boolean is on the interval of the range given
   */
  function dateFallsOn( $utime, $step, $period, $base ) { 
    $diff = ZenUtils::dateDiff( $utime, $base, $period );
    return ($diff % $step == 0);    
  }

  /**
   * STATIC: Returns the number of specified periods between the requested dates
   *
   * @static
   * It is possible that dates might run off by an hour due to daylight savings issues,
   * but I think that the unix timestamps may prevent this... in any event, it's accurate
   * enough for for most uses, and takes care of leap year issues, should probably
   * test for DST problems before using for any sort of date sensitive purposes
   *
   * @param $start is one of the dates
   * @param $end is the other date
   * @param $period is the time period (seconds,minutes,days,hours,weeks,months,quarters,years)
   * @return integer the result or false if invalid period
   */
  function dateDiff( $start, $end, $period ) {

     // for calculations, simplify by reducing possibilities
     if( $start > $end ) {
       $tmp = $start;
       $start = $end;
       $end = $tmp;
     }

     // split up dates
     $sp = getdate($start);
     $ee = getdate($end);
     $diff = $end - $start;
     $div = ZenUtils::secondsIn($period);
     $mod = 0;

     // return correct vals
     // we aren't worried about negative results here since
     // the start date cannot fall after the end date
     switch( strtolower(substr($period,0,2)) ) {
     case "se":
     case "mi":
     case "ho":
     case "da":
     case "we":
       return ZenUtils::convertSecondsTo( $diff, $period );
     case "ye":
       $mod = 12;
     case "qu":
       $mod = 3;
     case "mo":
       {
         $mos = ($ee['years'] - $sp['years'])*12 + $ee['months'] - $sp['months'];
         // if our days are equal, test hours
         if( $ee['days'] == $sp['days'] ) {
           // if our hours are equal, test the minutes, 
           if( $ee['hours'] == $sp['hours'] ) {
             // if our minutes are equal, test seconds
             if( $ee['minutes'] == $sp['minutes'] ) {
               // if the sp seconds are greater then drop a month from the total
               if( $ee['seconds'] < $sp['seconds'] ) { $mos--; }
             }
             // if the sp minutes are greater then drop a month from total
             else if( $ee['minutes'] < $sp['minutes'] ) { $mos--; }
           }
           // if the sp hours are greater then drop a month from the total
           else if( $ee['hours'] < $sp['hours'] ) { $mos--; }
         }
         // if the sp days are greater drop a month from the total
         else if( $ee['days'] < $sp['days'] ) { $mos--; }
         return $mod? floor($mos/$mod) : $mos;
       }
     default:
       return false;
     }
   }

  /**
   * STATIC: Converts seconds(usually diffs between timestamps) to other measures of time
   * 
   * For example, if I pass <code>ZenUtils::convertSecondsTo(120, 'minutes')</code> I will get 2
   * This method rounds to the nearest whole unit (dropping partial times)
   *
   * @static
   * @param integer $seconds is the unix timestampe
   * @param string $period is the period to use (minutes,hours,days,weeks)
   * @return float or false if $period is invalid
   */
  function convertSecondsTo( $seconds, $period ) {
    return floor( $seconds/ZenUtils::secondsIn($period) );
  }

  /**
   * STATIC: Returns the number of seconds in a measure of time
   *
   * @static
   * @param $period is the time period (minutes,days,hours,weeks)
   * @param $num is the number of days/hours/weeks to measure [default to 1]
   * @return integer the result or false if invalid period
   */
   function secondsIn( $period, $num = 1 ) {
     switch( strtolower(substr($period,0,3)) ) {
     case "min":
       $conv = 60 * $num;
       break;
     case "hou":
       $conv = 3600 * $num;
       break;
     case "day":
       $conv = 86400 * $num;
       break;
     case "wee":
       $conv = 604800 * $num;
       break;
     case "sec":
       $conv = $num;
       break;
     default:
       return false;
     }			 
     return $conv;
   }

  /**
   * STATIC: Reads a .ini file, replaces occurences of %variable_name% with another value already declared
   *
   * Note that variables to be used as replacements MUST ALREADY BE SET
   * Additionally, all properties in the ini file must appear under a section heading
   * or this will fail miserably.
   *
   * @static
   * @param string $ini_file is the absolute path to the file
   * @return array parsed ini file contents
   */
  function read_ini( $ini_file ) {
    $data = parse_ini_file( $ini_file, TRUE );
    $bulk = array();
    foreach($data as $section=>$vals) {
      foreach($vals as $key=>$val) {
        while( preg_match("/\%([a-zA-Z0-9_]+)\%/", $val, $matches) ) {
          $v = $matches[1];
          $val = preg_replace("/\%$v\%/", $bulk[$v], $val);
        }
        $data[$section][$key] = $val;
        $bulk[$key] = $data[$section][$key];
      }
    }
    return $data;
  }

  /**
   * STATIC: Parses a setup/data file
   *
   * @static
   * @param string $filename is the path/name of the file
   * @param boolean $explode is the character to expand each row on, if null then return string instead of array
   * @return array containg either string or array elements based on $explode
   */
  function parse_datafile( $filename, $explode = ':' ) {
    if( !@file_exists($filename) ) {
      return false;
    }
    $vals = array();
    $contents = file($filename);
    foreach($contents as $c) {
      $c = trim($c);
      if( strlen($c) && strpos($c, "#") !== 0 ) {
	if( $explode != null ) {
	  $n = count($vals);
	  $v = explode($explode, $c);
	  for($i=0; $i<count($v); $i++) {
	    $vals[$n][$i] = trim($v[$i]);
	  }
	}
	else {
	  $vals[] = $c;
	}
      }
    }
    return $vals;
  }


  /**
   * STATIC: Display member variables and values from a class object (debug utility)
   *
   * @static
   * @param Object $obj the <code>$this</code> reference of an object to print out
   * @return boolean true if the object provided was valid
   */
  function printMemberVariables( $obj ) {
    if( !is_object($obj) ) { return false; }
    return ZenUtils::printArray( get_object_vars($obj) );
  }

  /**
   * STATIC: Display member methods of class object (debug utility)
   *
   * @static
   * @param Object $obj the <code>$this</code> reference of an object to print out
   * @return boolean true if the object provided was valid
   */
  function printMemberMethods( $obj ) {
    if( !is_object($obj) ) { return false; }
    return ZenUtils::printArray( get_class_methods($obj) );    
  }

  /**
   * STATIC: Serialize and save data to a file
   *
   * @static
   * @param string $file is the full path to access the writable file
   * @param mixed $data is whatever data is to be saved
   * @return boolean successful
   */
  function serializeDataToFile( $file, $data ) {
    if( file_exists($file) ) {
      $serializedData = serialize($data);
      $fp = fopen($file);
      fwrite($fp, $serializedData);
      fclose($fp);
      return true;
    }
    return false;
  }

  /**
   * STATIC: Unserialize and restore data from file
   *
   * @static
   * @param string $file is the full path to access the writable file
   * @return mixed whatever was in the file or false if failed
   */
  function unserializeFileToData( $file ) {
    if( file_exists($file) ) {
      $serializedData = join('',file($file));
      return unserialize($serializedData);
    }
    return false; 
  }

  /**
   * STATIC: Provides a safe method for checking for object types.  This
   * will match extending classes as well.
   *
   * @static
   * @param string $expected
   * @param Object $obj
   * @return boolean
   */
  function isInstanceOf( $expected, $obj ) {
    return is_object($obj) && is_a($obj, strtolower($expected));
  }

  /**
   * STATIC: wrapper for {@link isInstanceOf()}
   *
   * @static
   * @param string $expected
   * @param Object $obj
   * @return boolean
   */
  function instanceOf( $expected, $obj ) {
    return ZenUtils::isInstanceOf($expected, $obj);
  }

  /**
   * STATIC: Provides debugging output which is safe to use during installation 
   * (before config is enabled).
   *
   * Normally this method works just like {@link Zen::debug()}, however
   * if $GLOBALS['installMode'] is set to an integer value, then debugging
   * is redirected to stdout, and the level of debugging that is produced
   * is controlled by this value instead of the normal debug.xml configuration.
   *
   * This is useful for classes which may be used during installation,
   * but may also use {@link ZenMessageList} for debugging output during
   * normal operations.
   *
   * @static
   * @param mixed $class the class object ($this) or a string representing the class/script name
   * @param string $method the method/section producing message
   * @param string $message the message to store
   * @param intege $errnum the error number associated with message
   * @param integer $level the level of the message
   * @return boolean true if message was valid and added successfully
   */
  function safeDebug( $class, $method, $message, $errnum, $level ) {    
    if( isset($GLOBALS) && isset($GLOBALS['installMode']) && $GLOBALS['installMode'] ) {
      // check installMode level vs $level
      if( $GLOBALS['installMode'] < $level ) { return false; }
      // we are in install mode, so don't use ZenMessageList
      // determine the level of messages to show, normally this
      // will be 1 (errors), in develop_mode we will relax this to 3(note)
      $lvl = ZenUtils::getIni('debug','develop_mode')? 3 : 1;
      if( $lvl >= $level ) {
        if( is_object($class) ) { $class = get_class($class); }
        print "  [".ZenUtils::displayDebugLevel($level)."]";
        if( $errnum != 0 ) { print "[$errnum]"; }
        print " {$class}->{$method}: $message\n";
        return true;
      }
    }
    else if( class_exists('Zen') && class_exists('ZenMessageList') ) {
      // we are not in install mode, so send to ZenMessageList
      return Zen::debug($class, $method, $message, $errnum, $level);
    }
    return false;
  }

  /**
   * STATIC: Returns a human readable string representing the current debug level
   *
   * @static
   * @param integer $level
   * @return string
   */
  function displayDebugLevel( $level ) {
    switch( $level ) {
    case LVL_ERROR:
      return "ERROR";
    case LVL_WARN:
      return "WARNING";
    case LVL_INFO:
      return "INFO";
    case LVL_DEBUG:
      return "DEBUG";
    default:
      return "MESSAGE";
    }
  }

  /**
   * STATIC: Returns a translation, if the translation engine is available, otherwise
   * parses any variables and returns string 'as-is'
   *
   * @static
   * @param string $text text to translate
   * @param array $vals key/value set containing any values to substitute for ? chars
   */
  function translate( $text, $vals = null ) {
    //todo
    //todo make this initialize the
    //todo tr() method if possible
    //todo
    //todo move the tr() method here?
    //todo
    if( function_exists("tr") ) {
      return tr($text, $vals);
    }
    else if( $vals ) {
      foreach($vals as $v) {
        $text = preg_replace("/\?/", $v, $text, 1);
      }      
    }
    return $text;
  }

  /**
   * STATIC: Reads a helper script and returns the results.
   *
   * The helper script is a file in includes/lib/helpers
   * which is similar to a 'plugin', providing specific
   * functionality for the zentrack system.
   *
   * Helper functions must be named according to the following
   * convention:
   * <pre> 
   * helper_subject_function
   *  - helper: the text "helper"
   *  - subject: db table, form name, or type of helper(action,param,etc)
   *  - function: name of helper function
   * </pre>
   *
   * The helper will be included from a file called helper_subject.php, this
   * will facilitate a means of including common functions without loading the
   * whole kit and kaboodle.
   *
   * The following parms are always expected to appear in the argument list, 
   * for the given helper type.  Others may appear as warranted by the 
   * criteria for the db field:
   * <ul>
   *   <li><b>db/form helper</b>
   *   <ul>
   *     <li>template - template rendering the form
   *     <li>field - array containing all field properties
   *   </ul>
   *   <li><b>action helper</b>
   *   <ul>
   *     <li>action_id - action calling the helper
   *   </ul>
   *   <li><b>parm helper</b>
   *   <ul>
   *     <li>parm - a ZenParm object containg the parm info
   *   </ul>
   * </ul>
   *
   * <b>Example:</b>
   * <code>
   * // (a helper placed on the TICKET.owner field)
   * // therefore the file is called helper_ticket.php
   * // the function_name is helper_ticket_owner.php
   * // this function checks to see if there is an owner,
   * // if not, it tries to assign the current logged in
   * // user as the owner (obviously would be called on
   * // ticket create screen)
   * function helper_ticket_owner( $args ) {
   *   if( !isset($args['default']) || $args['default'] == '{login_id}' ) {
   *     return ZenUtils::findGlobal('login','id');
   *   }
   *   return $args['default'];
   * }
   * </code>
   *
   * @param string $template the name of the template calling this helper (if any)
   * @param string $helper name of helper function
   * @param array $args associative array containing arguments to pass to helper
   * @return mixed the return value of the helper function
   */
  function runHelper($helper, $template, $field, $args) {
    
    includeHelper($helper);
    if( !function_exists($helper) ) {
      ZenUtils::safeDebug("ZenUtils","runHelper","Helper $helper not found!",105,LVL_ERROR);
      return null;
    }
    return $helper($args);   
  }

  /**
   * STATIC: Reads an external shell script or program and returns results
   *
   * The external script must be located in the dir_user (includes/user)
   *
   * If the script is a php script, the path_cli info will be prefixed to
   * facilitate proper execution.  Other scripts will need to be capable
   * of running from the command line simply by calling the file name 
   * followed by arguments to pass.
   *
   * If you wish to run system commands or external programs, you can call 
   * them from a shell or cmd script run by this command.
   *
   * @static
   * @param string $script the script to run in dir_user folder
   * @param array $args arguments for script (must be properly escaped and quoted)
   * @return string any output produced by script
   */
  function runScript($script, $args) {
    $cmd = "$script ".join(" ",$args);
    if( preg_match("/\.php$/", $script) ) {
      $cmd = ZenUtils::getIni('paths', 'path_cli').$cmd;
    }
    return `$cmd`;
  }

  /**
   * STATIC: Runs a user function and returns results safely.
   *
   * A user function must reside in the zen.ini->dir_user directory.  The
   * function must accept an array of arguments (which may be null) and return
   * a result usable by the calling method.
   *
   * All user functions must begin with usr_fxn_, to avoid any ambiguity
   * or conflicts with system functions.
   *
   * @param string $function name of the function to run
   * @param array $args associative array containing args to pass to function, if any
   * @return mixed whatever the function is designed to generate
   */
  function callUserFunction( $function, $args ) {    
    if( !(str_pos($function, 'usr_fxn_') === 0) ) {
      ZenUtils::safeDebug("ZenUtils", "callUserFunction", "Invalid user function ($function), must begin with usr_fxn_!", 
                          105, LVL_ERROR);
      return null;
    }
    if( !function_exists($function) ) {
      ZenUtils::safeDebug("ZenUtils", "callUserFunction", "Specified user function ($function) does not exist!", 105, LVL_ERROR);
      return null; 
    }
    return $function($args);
  }

  /**
   * DO NOT use the constructor, this class may contain only static methods
   */
  function ZenUtils() { 
    ZenUtils::safeDebug("ZenUtils", "ZenUtils", 
                        "Do not try to construct ZenUtils, it contains only static methods", 160, LVL_ERROR);
  }

  /**
   * STATIC: parse a value and try to equate it to a true or false boolean
   *
   * This is accomplished by looking at the php evaluation !$value, if this
   * returns false, the return value is false.  Otherwise, we try to parse
   * the value. 1, 't', 'true', 'y', 'yes' are examples of true results, while
   * 'f', 'n', 0 are examples of false results.
   *
   * Any value which does not meet any of these criteria results in the default
   * being returned.
   *
   * @param mixed $value
   * @param boolean $default (can be null)
   * @return boolean or $default if cannot be parsed
   */
  function parseBoolean($value, $default = false) {
    if( is_bool($value) ) { return $value; }
    if( !strlen($value) ) { return $default; }
    switch( strtolower(substr($value, 0, 1)) ) {
    case "t":
    case "y":
    case 1:
      return true;
    case "f":
    case "n":
    case 0:
      return false;
    default:
      return $default;
    }    
  }

}

?>
