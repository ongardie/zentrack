<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

  /**
   *  TEMPLATE PROCESSING ENGINE
   *
   *  Essentially, the template engine works as follows
   *
   *  // get the template to process
   *  $tmp = new zenTemplate("/web/site/templates/template_name");
   *  // insert indexed array of values to be substituted
   *  $tmp->values($array_of_values);
   *  // get the results
   *  $text = $tmp->process();
   *
   *  A template file will look similar to the following:
   *
   *  <h3>{title}</h3>
   *  <form name="{name}" action="{action}">
   *  {list:array_name:"<input type='text' name='"+index+"' value='"+value+"'"}
   *  </for>
   *
   * Valid template entries are:
   *
   * <ul> 
   *  <li>{varname} - inserts value of varname
   *  <li>{varname/default_value} - inserts value of varname, if not found, default_value is substituted
   *  <li>{zen:varname} - inserts value from config settings, i.e. Zen::getSetting("varname")
   *  <li>{foreach:varname:"text"+index+"more text"+value} - loops through indexed array and prints name/value
   *  <li>{foreach:varname:%sub-template%} - loops through the indexed array and passes name/value to sub-template
   *  <li>{list:varname:"text"+value+"text"} - loops through array and prints values
   *  <li>{list:varname:%sub-template%} - loops through the array, passing values to the sub-template
   *  <li>{include:template_name} - inserts another template into this one
   *  <li>{if:field:"text to print"+field+"text to print"} - inserts text if field exists
   *  <li>{if:field:%sub-template%} - inserts sub-template if field exists
   *  <li>{if:field=something:"text to print"+field+"more text"} - inserts text if field = something
   *  <li>{if:field=something:%sub-template%} - inserts sub-template if field = something
   *  <li>{function:function_name:param1,param2,param3} - runs a global function and inserts the return value
   * </ul>
   *
   * @package Utils
   */
class zenTemplate {

  /**
   * invoke the template class
   *
   * @param string $template is the path to the template file to load
   */
  function zenTemplate( $template ) {
    $this->_template = $template;
    $this->_get();
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
      $this->_text = array("Template file $template could not be found.");
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
        return isset($zen->settings["$n"])? $zen->settings["$n"] : "";
      }
      break;
      case "foreach":
      {
        // {foreach:varname:"text"+index+"more text"+value}
        // {foreach:varname:%sub-template%}
        
        return _parseForeach($parts);
      }
      break;
      case  "list":
      {
        // {list:varname:"text"+value+"text"}
        // {list:varname:%sub-template%}
        
        return _parseList($parts);
      }
      break;
      case  "include":
      {
        // {include:template_name}
        $tmp = new zenTemplate(trim($parts[1]));
        $tmp->values( $this->_vars );
        return $tmp->process();
      }
      break;
      case  "if":
      {
        // {if:field:"text to print"+field+"text to print"}
        // {if:field=something:"text to print"+field+"more text"}
        // {if:field:%sub-template%}
        // {if:field=something:%sub-template%}
        
        return _parseIf($parts);
      }
      break;
      }
    }
    // return something generic if we fall through
    return "{invalid tag: $index}";
  }
  
  /**
   ** <b>private</b>: parse a {foreach} call in a template
   **
   ** @param array $parts the parts of the foreach call to be parsed
   ** @return string the parsed {foreach} call
   **/
  function _parseForeach($parts)
  {
    $vars = $this->_getVar(trim($parts[1]));
    if( is_array($vars) ) {
      $txt = "";
      // make the string to show
      $str = $this->_parseString($parts[2]);
      // loop the list and make output text
      foreach($vars as $k=>$v) {
        // determine if we are to process text or a template
        if (preg_match('|^%.+%$', $parts[2])) {
          // return the template
          
          $tplname = substr(substr($parts[2], 1), -1);
          $txt .= $this->parseSubtemplate($tplname, $v, $k);
        } else {
          // return the text
          $tmp = str_replace("{index}", $k, $str);
          $txt .= str_replace("{value}", $v, $tmp);
        }
      }
      return $txt;
    }
    else {
      return "";
    }
  }
  
  /**
   ** <b>private</b>: parse a {list} call in a template
   **
   ** @param array $parts the parts of the list call to be parsed
   ** @return string the parsed {list} call
   **/
  function _parseList($parts) {
    $vars = $this->_getVar(trim($parts[1]));
    if( is_array($vars) ) {
      $txt = "";
      // parse the string
      $str = $this->_parseString($parts[2]);
      // create the output text
      foreach($vars as $v) {
        // determine if we are to process text or a template
        if (preg_match('|^%.+%$', $parts[2])) {
          // return the template
          
          $tplname = substr(substr($parts[2], 1), -1);
          
          $txt .= parseSubtemplate($tplname, $v);
        } else {
          //return the text
          $txt .= str_replace("{value}", $v, $str);
        }
      }
      return $txt;
    }
    else {
      return "";
    }
  }
  
  /**
   ** <b>private</b>: parse a {list} call in a template
   **
   ** @param array $parts the parts of the if call to be parsed
   ** @return string the parsed {if} call
   **/
  function _parseIf() {
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
      // determine if we are expecting to include a template or not
      if( preg_match("|^%.+%$|", $parts[2]) )  {
        // return template
        
        $tplname = substr(substr($parts[2], 1), -1);
        return $this->_parseSubtemplate($tplname, $this->_vars);
        
        /*
        $tpl = new zenTemplate($this->templateDir."/".$tplname);
        $tpl->values($this->_vars);
        
        return $tpl->process();
        */
      } else {
        // return text
        return $this->_parseString($parts[2]);
      }
    }
    else {
      return "";
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
  function _parseString( $text ) {
    $text = str_replace('\\"', '"', $text);
    // parse the string to print
    $vals = explode("+",trim($text));
    $str = "";
    foreach($vals as $v) {
      $v = trim($v);
      // this is a string
      if( strpos($v,'"') === 0 ) {
	$str .= preg_replace('/^"/', "", preg_replace('/"$/', "", $v)); 
      }
      // this is the foreach key
      else if( $v == "index" ) {
	$str .= "{index}";
      }
      // this is the foreach value
      else if( $v == "value" ) {
	$str .= "{value}";
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
    if( is_array($this->_vars) && isset($this->_vars["$name"]) )
      return $this->_vars["$name"];
    else
      return "";
  }

  /**
   ** <b>private</b>: returns an expanded sub-template
   **
   ** @param string $template the name of the sub-template to be expanded, assumed to be contained in the templates directory
   ** @param mixed $value a string to be passed as {pval} to the sub-template or an array of indexed values to be passed to the sub-array
   ** @param string $key the key of the value to be passed as {pkey} to the sub-template (only used when $value is a string)
   ** @return the expanded sub-template
   **/
  function _parseSubtemplates ( $template, $value, $key = '' ) {
    $tpl = new zenTemplate($this->templateDir."/".$tplname);
    
    if( is_array($value) ) {
      // $value is an indexed array to be passed to the sub-template
      
      $tpl->values($value);
    } else {
      // $value/$key are a string pair to be passed as {pkey} and {pval}
      
      $tpl->values(array("pkey" => $key, "pval" => $value));
    }
    
    return $tpl->process();
  }
  
  var $_template; //the file we are using
  var $_zen;
  var $_text;  //the template data loaded and ready for parsing
  var $_vars;  //the variables to use for template parsing

}

?>
