<?
if( !ZT_DEFINED ) { die("Illegal Access"); }


  /**
   **  TEMPLATE PROCESSING ENGINE
   **
   **  Essentially, the template engine works as follows
   **
   **  // get the template to process
   **  $tmp = new zenTemplate("/web/site/templates/template_name");
   **  // insert indexed array of values to be substituted
   **  $tmp->values($array_of_values);
   **  // get the results
   **  $text = $tmp->process();
   **
   **  A template file will look similar to the following:
   **
   **  <h3>{title}</h3>
   **  <form name="{name}" action="{action}">
   **  {list:array_name:"<input type='text' name='"+index+"' value='"+value+"'>"}
   **  </for>
   **
   ** Valid template entries are:
   **
   ** <ul> 
   **  <li>{varname} - inserts value of varname
   **  <li>{zen:varname} - inserts value of $zen->getSetting("varname")
   **  <li>{list:varname:"text"+index+"more text"+value} - loops through indexed array and prints name/value
   **  <li>{list:varname:"text"+index+"more text"+selected+"other text"+value} - loops through indexed array and print
   **                                                                            name/value (and " selected" when appropriate)
   **  <li>{list:varname:"text"+index+"more text"+checked+"other text"+value} - loops through indexed array and print
   **                                                                            name/value (and " checked" when appropriate)
   **  <li>{foreach:varname:"text"+value+"text"} - loops through array and prints values
   **  <li>{foreach:varname:"text"+selected+"more text"+value+"text"} - prints values and ' selected' if 
   **               field_selected exists and matches current value
   **  <li>{include:template_name} - inserts another template into this one
   **  <li>{if:field:"text to print"+field+"text to print"} - inserts text if field exists
   **  <li>{if:field=something:"text to print"+field+"more text"} - inserts text if field = something
   ** </ul>
   **
   */

class zenTemplate {

  /**
   ** invoke the template class
   **
   ** @param string $template is the path to the template file to load
   */
  function zenTemplate( $template ) {
    $this->_dir = dirname($template);
    $this->_template = $template;
    $this->_get();
    $this->_vars = array('rowcolor'=>'altCell', 'rowcolor_1'=>'cell', 'rowcolor_2'=>'altCell');
  }

  /**
   * load variables into the template engine for parsing
   *
   * @param array $vars indexed array of "name" => "value"
   */
  function values( $vars ) {
    foreach($vars as $k=>$v) {
      $this->_vars["$k"] = $v;
    }
  }

  /**
   * return a text string representing the parsed contents of the template
   *
   * @return string parsed template data, ready for use
   */
  function process() {
    return $this->_parse();
  }

  /**
   * <b>private</b>: get the template file and convert it to a text string
   */
  function _get() {
    if( file_exists($this->_template) ) {
      $this->_text = file($this->_template);
    }
    else {
      $this->_text = array("Template file {$this->_template} could not be found.");
    }
  }

  /**
   * <b>private</b>: returns a zen object
   *
   * @return object zen object
   */
  function _getZenObject() {    
    if( !is_object($this->_zen) ) {
      global $zen;
      $this->_zen = &$zen;
    }
    return $this->_zen;
  }

  /**
   * <b>private</b>: parse the contents of the template and insert values
   *
   * @return string parsed contents
   */
  function _parse() {
    $txt = $this->_text;
    for($i=0; $i<count($txt); $i++) {
      $txt[$i] = preg_replace("@[{]([^}]+)[}]@e", "''.\$this->_insert(\"\\1\").''",$txt[$i]);
    }
    return join("",$txt);
  }

  /**
   * <b>private</b>: parse the inserts in the template and return text for replacement
   *
   * @param string $text text to be replaced
   * @return string text to insert
   */
  function _insert( $text ) {
    $parts = explode(":", $text);
    $index = strtolower(trim($parts[0]));
    if( count($parts) == 1 ) {
      // {varname} - inserts value of varname
      return $this->_getVar($index);
    }    
    else {
      switch($index) {
      case "zen":
	{
	  // {zen:varname}
	  $zen = &$this->_getZenObject();
	  $n = trim($parts[1]);
	  return $zen->getSetting("$n")? $zen->getSetting("$n") : "";
	}
	break;
      case "list":
	{
	  // {list:varname:"text"+index+"more text"+value}
	  $vars = $this->_getVar(trim($parts[1]));
	  if( is_array($vars) ) {
	    $txt = "";
	    // make the string to show
	    $str = $this->_parseString($parts[2]);
	    // loop the list and make output text
	    foreach($vars as $k=>$v) {
              $this->_rowColor();
              if( preg_match('@^\\{include\\(([A-Za-z0-9/_.]+)\\)\\}$@', $str, $matches) ) {
                $txt .= $this->_inc($matches[1], $v, $k);
              }
              else {
                $fv = $this->_getVar("field_value");
                $fl = $this->_getVar("field_label");
                $tmp=$str;
                $_k = Zen::ffv($k);
                if($fv==$_k && strlen($fv) == strlen($_k) || is_array($fv) && in_array($_k, $fv) || 
                                       ( is_array($fv) && in_array($v,array_values($fv)) ) || 
                                       ( is_array($fl) && in_array($_k, $fl) ) ||
                                       (!is_array($fv) && !strlen($_k) && !strlen($fv))) {
                  $tmp = str_replace("{selected}", " selected", $tmp);
                  $tmp = str_replace("{checked}", " checked", $tmp);
                } else {
                  $tmp = str_replace("{selected}", "", $tmp);
                  $tmp = str_replace("{checked}", "", $tmp);
                }
                $tmp = str_replace("{index}", $k, $tmp);
                $txt .= str_replace("{value}", $v, $tmp);
              }
	    }
	    return $txt;
	  }
	  else {
	    return "";
	  }
	}
	break;
      case  "foreach":
	{
	  // {foreach:varname:"text"+value+"text"}
	  $vars = $this->_getVar(trim($parts[1]));
	  if( is_array($vars) ) {
            $sel = $this->_getVar("field_selected");
	    $txt = "";
	    // parse the string
	    $str = $this->_parseString($parts[2]);
	    // create the output text
	    foreach($vars as $v) {
        	$this->_rowColor();

	        $tmp=$str;
          	if($sel==$v && strlen($sel) == strlen($v) || is_array($sel) && in_array($v, $sel) || 
                                       ( is_array($sel) && in_array($v,array_values($sel)) ) || 
                                       ( !is_array($sel) && !strlen($v) && !strlen($sel) ) ||
                                       ( !is_array($sel) && $sel && $sel == $v && strlen($sel) == strlen($v) ) ) {
            		$selected = " selected";
          	} else {
            		$selected = "";
                }


        	//$selected = $sel && $sel == $v && strlen($sel) == strlen($v)? ' selected' : '';
        	if( preg_match('@^\\{include\\(([A-Za-z0-9/_.]+)\\)\\}$@', $str, $matches) ) {
          		$txt .= $this->_inc($matches[1], $v);
        	}
        	else {
          		$s = str_replace("{selected}", $selected, $str);
          		$s = str_replace("{value}", $v, $s);
          		$s = str_replace("{rowcolor}", $this->_vars['rowcolor'], $s);
		        $txt .= $s;
        	}
	    }
	    return $txt;
	  }
	  else {
	    return "";
	  }
	}
	break;
      case  "include":
	{
	  // {include:template_name}
	  return $this->_inc(trim($parts[1]));
	}
	break;
      case  "if":
	{
	  // {if:field:"text to print"+field+"text to print"}
	  // {if:field=something:"text to print"+field+"more text"}
	  $p = trim($parts[1]);
	  // determine if the if condition is true
	  if( strpos($p,"=") > 0 ) {
	    // there is an equals clause
	    list($key,$val) = explode("=",$parts[1]);
	    $key = trim($key);
	    $val = trim($val);
	    $tf = ($this->_getVar($key) == $val);
	  }
	  else {
	    $var = $this->_getVar($p);
	    $tf = ( (is_array($var) && count($var)) || (strlen($var) > 0) );
	  }
	  // execute the query if we met if condition
	  if( $tf ) {
	    return $this->_parseString($parts[2]);
	  }
	  else {
	    return "";
	  }
	}
	break;
      }
    }
    // return something generic if we fall through
    return "{invalid tag: $index}";
  }
  
  /**
   ** Return a value from an array based on match
   **/
  function _inc($file, $val = false, $key = false) {
    $tmp = new zenTemplate("{$this->_dir}/$file");
    $vals = $this->_vars;
    if( $val ) { $vals['curval'] = $val; }
    if( $key ) { $vals['curkey'] = $key; }
	  $tmp->values( $vals );
	  return $tmp->process();
  }
  
  /**
   * Alternate row colors
   */
  function _rowColor() {
    if( $this->_vars['rowcolor'] == $this->_vars['rowcolor_1'] ) { 
      $this->_vars['rowcolor'] = $this->_vars['rowcolor_2'];
    } 
    else { 
      $this->_vars['rowcolor'] = $this->_vars['rowcolor_1']; 
    }
  }

  /**
   ** <b>private</b>: parse a value string and return the results
   **
   ** this will replace variables with their values
   ** and the special keywords index and value
   ** with the text {index} and {value}
   **
   ** the value string should be in the format:
   **  "some text "+a_variable+"some more text"+another_variable... etc.
   **
   ** @param string $text the text string to parse
   ** @return string the parsed data
   **/
  function _parseString( $text, $curval = '', $curtext = '' ) {
    $text = str_replace('\\"', '"', $text);
    $text = str_replace("\\'", "'", $text);
    // parse the string to print
    $vals = explode("+",trim($text));
    $str = "";
    foreach($vals as $v) {
      $v = trim($v);
      // this is a string
      if( strpos($v,'"') === 0 ) {
        $str .= preg_replace('/^"/', "", preg_replace('/"$/', "", $v)); 
      }
      else if( preg_match('@^include\\(([A-Za-z0-9/_.]+)\\)$@', $v, $matches) ) {
        $str .= "\{$v}";
      }
      // this is the foreach key
      else if( $v == "index" ) {
        $str .= "{index}";
      }
      // this is the foreach value
      else if( $v == "value" ) {
        $str .= "{value}";
      }
      // this is used for list elements and is set to " selected" when the key equals the field_value
      else if( $v == "selected" ) {
        $str .= "{selected}";
      }
      // this is used for list elements and is set to " checked" when the key equals the field_value
      else if( $v == "checked" ) {
        $str .= "{checked}";
      }
      // used to alternate colors of rows
      else if( $v == 'rowcolor' ) {
        $str .= "{rowcolor}";
      }
      // this is another variable
      else {
        $str .= $this->_getVar($v);
      }
    }
    // fix return chars
    $str = str_replace('\n', "\n", $str);
    $str = str_replace('\t', "\t", $str);
    return $str;
  }
  
  /**
   ** <b>private</b>: returns a value recieved from the $this->values()
   **
   ** @param string $name the varname
   ** @return string the value of the varname
   **/
  function _getVar($name) {
    if( !is_array($this->_vars) ) { return ""; }
    if( preg_match("@^([a-zA-Z0-9_]+)\\[([a-zA-Z0-9_]+)\\]$@", $name, $matches) ) {
      $x = $matches[1];
      $y = $matches[2];
      if( array_key_exists($x, $this->_vars) && array_key_exists($y, $this->_vars[$x]) ) {
        return $this->_vars[$x][$y];
      }
      else {
        return "";
      }
    }
    if( !isset($this->_vars["$name"]) ) { return ""; }
    return $this->_vars["$name"];
  }

  var $_template; //the file we are using
  var $_zen;
  var $_text;  //the template data loaded and ready for parsing
  var $_vars;  //the variables to use for template parsing
  var $_dir;
}

?>
