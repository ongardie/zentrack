<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * The ZenMessageList is a utility for error reporting and logging
 *
 * The message list should not be called by its constructor... it should only
 * be called by using getInstance()
 *
 * @package Zen
 */
class ZenMessageList extends Zen {

  /**
   * Returns the static/global instance of this class, or creates a new one if needed
   *
   * @param String $config is the xml config file to use for creation (if needed)
   * @return ZenMessageList the static instance of the message list class
   */
  function &getInstance() {
    if( !isset($GLOBALS['messageList']) || $GLOBALS['messageList'] == null ) {
      $file = $_SESSION['zen']['directories']['dir_config']."/".$_SESSION['zen']['debug']['debug_configfile'];
      $GLOBALS['messageList'] = new ZenMessageList( $file );
    }
    return $GLOBALS['messageList'];
  }

  /**
   * CONSTRUCTOR
   *
   * loads an empty MessageList object with the level designation to accept
   * the primary use for this class is to be called through a global scope to
   * maintain a single list of all errors
   *
   * the messages will be filtered according to the debug settings in the appropriate xml file
   *
   * The output of the list may be further streamlined using the filter() method
   *
   * @param string $config is the xml file which holds the debug config info
   */
  function ZenMessageList( $config ) {
    $this->_messages = array();    

    $this->_counts = array();
    $this->_counts["total"] = 0;
    $this->_counts["level"] = array();

    $this->_levels = array();
    $this->_levels["default"] = array( "default" => 0 );

    $res = $this->_loadConfig($config);    
  }

  /**
   * adds a message to the list (if it meets the debug xml file requirements)
   *
   * @param string $class is the page or class adding the message
   * @param string $method is the method or section adding the message
   * @param string $message is the message to add
   * @param integer $errnum is the error number associated with message
   * @param integer $level is the level of importance
   * @return boolean whether message was added or not
   */
  function add( $class, $method, $message, $errnum, $level = 3 ) { 
    if( !strlen($class) ) {
      $class = "default";
      $method = "default";
    }
    else if( !strlen($method) ) {
      $method = "default";
    }
    if( !strlen($message) ) {
      $message = "";
    }
    if( !strlen($errnum) ) {
      $errnum = 0;
    }    
    if( !strlen($level) ) {
      $level = 0;
    }
    if( $this->_isValid( $level, $class, $method, $errnum ) ) {
      $this->_messages[] = new ZenMessage($class,$method,$message,$errnum,$level);
      $this->_addCount($level);
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * returns the errors in html format for debugging or on-screen display
   *
   * Note that this may be used with filter() to control the messages displayed
   *
   * @param boolean $debug tells whether or not to include class and method names
   * @return string containing formatted text for all errors
   */
  function outputHTML( $debug = false ) { 
    // open an outer block
    $txt = $this->_blockformat[0];
    
    foreach($this->_messages as $m) {
      if( $this->_show($m) ) {
        $l = $m->getLevel();      
        $s = "[".$m->getNumber()."] ".$m->get();
        if( $debug )
          $s = $m->getClass()."->".$m->getMethod().": ".$s;
        $txt .= $this->_msgformat[$l][0].$s.$this->_msgformat[$l][1];
      }
    }

    // close the outer block
    $txt .= $this->_blockformat[1];
    
    // return results
    return $txt;
  }

  /**
   * returns the errors in text format for logging or emails
   *
   * Note that this may be used with filter() to control the messages displayed
   *
   * @param boolean $debug tells whether or not to include class and method names
   * @return string containing formatted text with no html
   */
  function outputText( $debug ) {
    $txt = "";
    foreach($this->_messages as $m) {
      if( $this->_show($m) ) {
        $l = $m->getLevel();      
        $s = "[".$m->getNumber()."] ".$m->get();
        if( $debug )
          $s = $m->getClass()."->".$m->getMethod().": ".$s;
        $txt .= "\t".$s."\n";
      }
    }

    // close the outer block
    $txt .= $this->_blockformat[1];
    
    // return results
    return $txt;
  }


  /**
   * retrieves the list of ZenMessage objects in an array
   *
   * @return array of ZenMessage objects in an array (ordered as they were entered)
   */
  function getArray() { 
    return $this->_messages;
  }

  /**
   * filters the current message objects by the given parameters
   *
   * @param integer $level is the error level to meet
   * @param mixed $class the class(es) to limit results to
   * @param mixed $method the method(s) to limit results to
   * @param mixed $errornum specifies a certain error type(s) to match
   */
  function filter($level = null, $class = null, $method = null, $errnum = null) { 
    $this->_filters = array();    
    $this->_filters["level"] = $level;
    $this->_filters["class"] = $class;
    $this->_filters["method"] = $method;
    $this->_filters["errnum"] = $errnum;
  }

  /**
   * tells if a message has not been filtered (i.e. should be displayed)
   *
   * @param ZenMessage $msg the message in question
   * @return boolean true: display, false: skip
   */
  function _show( $msg ) {
    // don't bother if there are no filters
    if( !is_array($this->_filters) || !count($this->_filters) )
      return true;

    // shorthand
    $f = $this->_filters;

    // check level
    if( $f["level"] && ( 
          (is_array($f["level"]) && in_array($msg->getLevel(),$f["level"]))
            ||
          (!is_array($f["level"]) && $f["level"] == $msg->getLevel())
       ) ) return false;

    // check class
    if( $f["class"] && ( 
          (is_array($f["class"]) && in_array($msg->getClass(),$f["class"]))
            ||
          (!is_array($f["class"]) && $f["class"] == $msg->getClass())
       ) ) return false;

    // check method
    if( $f["method"] && ( 
          (is_array($f["method"]) && in_array($msg->getMethod(),$f["method"]))
            ||
          (!is_array($f["method"]) && $f["method"] == $msg->getMethod())
       ) ) return false;

    // check error number
    if( $f["errnum"] && ( 
          (is_array($f["errnum"]) && in_array($msg->getErrnum(),$f["errnum"]))
            ||
          (!is_array($f["errnum"]) && $f["errnum"] == $msg->getNumber())
       ) ) return false;

    // everything passed to return true
    return true;
  }

  /**
   * resets all filter criteria
   */
  function clearFilters() { $this->_filters = null; }

  /**
   * Clears all messages stored in list
   */
  function clearMessages() { $this->_messages = array(); }

  /**
   * Tells if a message should be logged or ignored
   *
   * @return boolean validated against debug config
   */
  function _isValid( $level, $class, $method, $errnum ) {
    if( !isset($this->_levels[$class]) ) {
      $class = "default";
      $method = "default";
    }
    else if( !isset($this->_levels[$class][$method]) && !isset($this->_levels[$class]["default"]) ) {
      $class = "default";
      $method = "default";
    }
    else if( !isset($this->_levels[$class][$method]) ) {
      $method = "default";
    }
    return( $level <= $this->_levels[$class][$method] );
  }

  /**
   * sets the counters to control how many error messages exist
   *
   * necessary since messages are stored in a simple ordered array
   * and the possibility of filters exists
   *
   * @param string $class 
   * @param string $method
   * @param integer $errnum
   * @param integer $level
   */
  function _addCount($level) {
    // the total count
    $this->_counts["total"]++;

    // the total count for error level
    if( !isset($this->_counts["level"][$level]) )
      $this->_counts["level"][$level] = 1;
    else
      $this->_counts["level"][$level]++;
  }

  /**
   * returns a count of ZenMessage objects stored
   *
   * note that this ignores the filter criteria which
   * might be in place
   *
   * @param integer $level (optional)
   * @return integer the count
   */
  function count( $level = null ) {
    if( $level && isset($this->_counts["level"][$level]) )
      return $this->_counts["level"][$level];
    else if( $level )
      return 0;
    else
      return $this->_counts["total"];
  }

  /**
   * Loads the xml debugging config file and parses into memory
   *
   * The values are stored in $this->_levels, indexed by error level, class and name
   *
   * @param String $xmlfile the complete path to the xml file to load config from
   * @return integer 0-failed, 1-loaded from session, 2-loaded from file
   */
  function _loadConfig( $xmlfile ) {
    if( is_array($_SESSION['cache']['messageListConfig']) ) {
      $this->_levels = $_SESSION['cache']['messageListConfig'];
      return 1;
    }
    else {
      $res = $this->_loadXMLConfig($xmlfile);
      if( $res > 0 ) $_SESSION['cache']['messageListConfig'] = $this->_levels;
      return $res;
    }
  }

  /**
   * Parses and loads xml data for debug properties
   *
   * @return integer 0-failed, 2-loaded from file
   */
  function _loadXMLConfig( $xmlfile ) {
    // get xml data
    $data = join("",file($xmlfile));    
    // create an xml parser and parse data
    $parser = new ZenXMLParser();
    $nodes =& $parser->parse($data); 
    $vals = $nodes->toArray();
    // set some debugging (since we can't add messages to this List yet)
    $msgs = $this->_processNodes($vals);
    // do some debugging checks
    if( !isset($this->_levels["default"]) ) {
      $msgs[] = array(1, 143, "The &lt;root&gt; node was not found.  A root node is required");
    }
    if( is_array($msgs) && count($msgs) ) {
      foreach($msgs as $m) {
        $this->add( get_class($this), "_loadXMLConfig", $m[2], $m[1], $m[0] );
      }
      return 0;
    }
    else {
      return 2;
    }
  }

  /**
   * Runs through each node and parses contents, performs basic validation
   *
   * @param array $vals the nodes to check
   * @return array containing any errors (returns empty array if no errors)
   */
  function _processNodes( $vals ) {
    //    ZenUtils::printArray($vals);
    $msgs = array();
    // run through the xml output
    foreach($vals["children"] as $cat=>$vars) {
      if( $cat == 'root' ) {
        $v = $vars[0];
        if( isset($v["properties"]["level"]) ) {
          $this->_levels["default"] = array("default"=>$v["properties"]["level"]);
        } 
      }
      else if( $cat == 'class' ) {
        foreach($vars as $v) {
          $r = $this->_processClassNode( $v );
          $msgs = array_merge($msgs,$r);
        }
      }
      else if( $cat == "format" ) {
        foreach($vars as $v) {
          $r = $this->_processFormatNode($v);
          $msgs = array_merge($msgs,$r);
        }
      }
      else {
        $msgs[] = array(2, 141, "{$cat} invalid node type -- ignored");
      }
    }
    return $msgs;
  }
  
  /**
   * Takes care of class nodes in the xml file
   *
   * @param array $node and children
   * @return array containing any errors
   */
  function _processClassNode( $node ) {
    $msgs = array();
    $n = $node["properties"]["name"];
    if( !isset($this->_levels[$n]) ) {
      $this->_levels[$n] = array();
      if( isset($node["properties"]["level"]) )
        $this->_levels[$n]["default"] = $node["properties"]["level"];
    }
    foreach($node["children"] as $name=>$vals) {
      if( $name == "method" ) {
        foreach($vals as $c) {
          $cn = $c["properties"]["name"];
          $this->_levels[$n][$cn] = $c["properties"]["level"]; 
        }
      }
      else { $msgs[] = array(2, 141, "{$n}->{$c['name']} invalid - ignored"); }
    }
    return $msgs;
  }

  /**
   * Processes format nodes, performs basic validation
   *
   * @param array $node the node to process
   * @return array containing any errors
   */
  function _processFormatNode( $node ) {
    $msgs = array();
    foreach($node["children"] as $n=>$vals) {
      $c = $vals[0];
      if( $n == "block" ) {
        $this->_blockformat = array($c["children"]["open"][0]["data"], $c["children"]["close"][0]["data"]);
      }
      else if( preg_match("/^level([0-9]+)$/", $n, $matches) ) {
        $m = $matches[1];
        $this->_msgformat[$m] = array($c["children"]["open"][0]["data"], $c["children"]["close"][0]["data"]);
      }
      else { $msgs[] = array(2, 141, "{$node['name']}->{$n} invalid - ignored"); }
    }
    return $msgs;
  }

  /**
   * Prints out the debug level settings in raw text format
   */
  function printDebugSettings() { ZenUtils::printArray($this->_levels); }

  /* VARIABLES */

  /** @var array $_filters list only items in this array */
  var $_filters;

  /** @var integer $_counter the current position in the ZenMessageList */
  var $_counter = 0;

  /** @var array $_counts the count of messages, for use in count() function:
   *  <ul>
   *    <li>"total" => total_count
   *    <li>"class" => array("total"=>total_count, "method1"=>count, "method2"...)
   *    <li>"errors" => array( number => count, ... )
   *  </ul>
   */
  var $_counts;

  /** @var array $_levels the level of message stored (1-error, 2-warning, 3-notice) indexed by each class and overall */
  var $_levels;

  /** @var array $_messages the list of message objects */
  var $_messages;

  /** @var array $_blockformat how to format the output blocks @see show() */
  var $_blockformat = array( "<ul>\n", "</ul>\n" ); 

  /** @var array $_msgformat how to format output messages @see show() */
  var $_msgformat = array( 1 => array("<li class='error'>","</li>\n"),
                           2 => array("<li class='warn'>","</li>\n"),
                           3 => array("<li class='msg'>","</li>\n") );


}

?>
