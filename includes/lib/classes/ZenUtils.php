<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 
 
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
   * @param mixed $class is class object ($this reference) or string containing classname
   * @return string the name of the primary key column
   */
  function getPrimaryKey( $class ) {
    return ZenUtils::tableNameFromClass($class)."_id";
  }

  /**
   * Attempts to locate a global value either in $_SESSION or $GLOBALS
   *
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
   * STATIC: Returns the parsed ini file array
   * <p>Retrieval is done as follows:
   * <ol>
   *    <li>Check <code>$_SESSION</code>
   *    <li>Check <code>$_GLOBALS</code>
   *    <li>Find <code>$file</code> and parse (assuming one was provided)
   * </ol>
   *
   *
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
      if( !file_exists($file) && class_exists("Zen") ) {
        return null;
      }
      return ZenUtils::read_ini($file);
    }
  }

  /**
   * STATIC: Searches the global arrays for zen.ini file data  and returns indexed value
   *
   * @param String $category is the ini file category to look in
   * @param String $property is the ini file property to retrieve (if omitted, returns entire category)
   * @return mixed value
   * @see ZenUtils::findIni()
   */
  function getIni( $category, $property = null ) {
    $ini = ZenUtils::findIni();
    if( !is_array($ini) ) { return null; }
    else if( !strlen($property) ) { return $ini[$category]; }
    else { return $ini[$category][$property]; }
  }

  /**
   * STATIC: Returns the name of the db table corresponding to this class object
   *
   * @param mixed $class is a $this object reference or a string containing class name
   * @param string name of table or false if none
   */
  function tableNameFromClass( $class ) { 
    $cname = strtolower(is_object($class)? get_class($class) : $class);
    // remove Zen from beginning of name
    if( strpos( $cname, "Zen" ) === 0 ) {
      $cname = substr($cname, 3);    
    }
    // remove .class from end if necessary
    if( strpos( $cname, ".class" ) ) {
      $cname = substr($cname, 0, -4);
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
   * @param string $table name of the db table
   * @return string full class name corresponding to table or false if none
   */
  function classNameFromTable( $table ) { 
    // return with proper case and Zen prefix
    return "Zen".ucfirst(strtolower($table));
  }

  /**
   * STATIC: Takes a simple array and returns an associative array in the form key=>value
   *
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
    if( $title ) { print "</div>\n"; }
    return true;
  }

  /**
   * STATIC: safely check for equality of two values when type is unsure
   *
   * @param mixed $val1
   * @param mixed $val2
   * @return boolean
   */
  function safeEquals( $val1, $val2 ) {
    if( !isset($val) xor !isset($val2) ) {
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
   * @param String $text
   * @return String containing formatted text for use in <input..> and <textarea> fields
   */
  function ffv( $text ) { }

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
   * @param integer $utime the unix timestamp to compare
   * @param integer $step the increment of our interval (every $step periods)
   * @param string $period is the period traversed (days,hours,weeks,months,years)
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
    * It is possible that dates might run off by an hour due to daylight savings issues,
    * but I think that the unix timestamps may prevent this... in any event, it's accurate
    * enough for for most uses, and takes care of leap year issues, should probably
    * test for DST problems before using for any sort of date sensitive purposes
    *
    * @param $start is one of the dates
    * @param $end is the other date
    * @param $period is the time period (days,hours,weeks,months,quarters,years)
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
   * @param Object $obj the <code>$this</code> reference of an object to print out
   * @return boolean true if the object provided was valid
   */
  function printMemberMethods( $obj ) {
    if( !is_object($obj) ) { return false; }
    return ZenUtils::printArray( get_class_methods($obj) );    
  }

  /**
   * Serialize and save data to a file
   *
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
   * Unserialize and restore data from file
   *
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


}

?>
