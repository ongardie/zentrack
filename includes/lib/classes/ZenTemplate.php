<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

  /**
   *  TEMPLATE PROCESSING ENGINE
   *
   *  <b>Essentially, the template engine works as follows:</b>
   *
   *  <code>
   *  // get the template to process
   *  $tmp = new zenTemplate("/web/site/templates/template_name");
   *  // insert indexed array of values to be substituted
   *  $tmp->values($array_of_values);
   *  // get the results
   *  $text = $tmp->process();
   *  </code>
   *
   *  A template file will look similar to the following:
   *
   *  <pre>
   *  <h3>{title}</h3>
   *  <form name="{name}" action="{action}">
   *  {list:array_name:"<input type='text' name='"+index+"' value='"+value+"'"}
   *  </for>
   *  </pre>
   *
   * <b>Valid template entries are:</b>
   * <ul> 
   *  <li>{varname} - inserts value of varname, if the value is an array
   *                  <br>then the values will be iterated each time it is requested
   *  <li>{varname="default_value"} - inserts val of varname, or default if not found, default is a string
   *  <li>{zen:category:varname} - inserts value from database settings using {@link Zen::getSetting()}
   *  <li>{ini:category:varname} - inserts value from ini settings using {@link Zen::getIniVal()}
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
   *  <li>{helper:file_name} - runs a helper script located in includes/lib/helpers and inserts results
   *  <li>{script:file_name} - runs a script located in includes/users/code and inserts results
   * </ul>
   *
   * <b>How strings work:</b>
   * 
   * A string consists of two elements: variable names and string literals.  String literals are surrounded
   * by quotes (" "), and are printed exactly as they appear, variables are parsed into the value passed to the
   * template system.  a + is used to join variables and strings together.  Here are some examples:
   * 
   * <code>
   *  // assuming color = 'blue', fruit = 'apple'
   *  "I am "+color+"!"         //produces 'I am blue!'
   *  "I found a "+color+fruit  //produces 'I found a blueapple'
   *  "a "+color+" "+fruit      //produces 'a blue apple'
   *  "I am "+"color"           //produces 'I am color'
   * </code>
   * 
   * @package Utils
   */
class ZenTemplate {

  /**
   * invoke the template class
   *
   * @param string $template is the path to the template file to load
   * @param boolean $install_mode handle debug info, etc for installation mode
   */
  function ZenTemplate( $template, $install_mode = false ) {
    $this->_install = $install_mode;
    ZenUtils::safeDebug($this->_install, $this, "ZenTemplate", "initializing template '$template'", 0, LVL_NOTE);
    if( isset($GLOBALS) && isset($GLOBALS['templateDir']) ) {
      $this->_templateDir = $GLOBALS['templateDir'];
    }
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
    if( !file_exists($this->_template) && file_exists($this->_templateDir."/".$this->_template) ) {
      $this->_template = $this->_templateDir."/".$this->_template;
    }
    if( file_exists($this->_template) ) {
      $this->_text = file($this->_template);
    }
    else {
      ZenUtils::safeDebug($this->_install, $this, "_get", 
                          "Could not load template '{$this->_template}'", 21, LVL_ERROR);
      $this->_text = array("Template file {$this->_template} could not be found.");
    }
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
    return stripslashes(join("",$txt));
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
        // {zen:category:varname}
        $c = trim($parts[1]);
        $n = trim($parts[2]);
        ZenUtils::safeDebug($this->_install, $this, "_insert", 
                            "using {zen:category:varname} for '$text'", 0, LVL_DEBUG);
        return Zen::getSetting($c,$n);
      }
      case "ini":
      {
        // {ini:category:varname}
        $c = trim($parts[1]);
        $n = trim($parts[2]);
        ZenUtils::safeDebug($this->_install, $this, "_insert", 
                            "using {ini:category:varname} for '$text'", 0, LVL_DEBUG);
        return Zen::getIniVal($c,$n);
      }
      case "foreach":
      {
        // {foreach:varname:"text"+index+"more text"+value}
        // {foreach:varname:%sub-template%}
        
        ZenUtils::safeDebug($this->_install, $this, "_insert", 
                            "using {foreach:varname:...} for '$text'", 0, LVL_DEBUG);
        return $this->_parseForeach($parts);
      }
      case  "list":
      {
        // {list:varname:"text"+value+"text"}
        // {list:varname:%sub-template%}
        ZenUtils::safeDebug($this->_install, $this, "_insert", 
                            "using {list:varname:...} for '$text'", 0, LVL_DEBUG);        
        return $this->_parseList($parts);
      }
      case  "include":
      {
        // {include:template_name}
        $tmp = new zenTemplate(trim($parts[1]));
        $tmp->values( $this->_vars );
        ZenUtils::safeDebug($this->_install, $this, "_insert", 
                            "using {include:template_name} for '$text'", 0, LVL_DEBUG);        
        return $tmp->process();
      }
      case  "if":
      {
        // {if:field:"text to print"+field+"text to print"}
        // {if:field=something:"text to print"+field+"more text"}
        // {if:field:%sub-template%}
        // {if:field=something:%sub-template%}
        ZenUtils::safeDebug($this->_install, $this, "_insert", "using {if:field...:...} for '$text'", 0, LVL_DEBUG);        
        return $this->_parseIf($parts);
      }
      case "helper":
      case "script":
      {
        // {helper:file_name}
        // {script:file_name}
        ZenUtils::safeDebug($this->_install, $this, "_insert", "using {helper:file_name} for '$text'", 0, LVL_DEBUG);
        return $this->_parseScript($parts);        
      }
      }
    }
    // return something generic if we fall through
    ZenUtils::safeDebug($this->_install, $this, "_insert", "invalid tag: '$text'", 103, LVL_WARN);
    return "{invalid tag: $index}";
  }
  
  /**
   * <b>private</b>: parse a {foreach} call in a template
   *
   * @param array $parts the parts of the foreach call to be parsed
   * @return string the parsed {foreach} call
   */
  function _parseForeach($parts)
  {
    $vars = $this->_vars[ trim($parts[1]) ];
    if( is_array($vars) ) {
      $txt = "";
      // make the string to show
      $str = $this->_parseString($parts[2]);
      // loop the list and make output text
      foreach($vars as $k=>$v) {
        // determine if we are to process text or a template
        if (preg_match('/^%.+%$/', $parts[2])) {
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
      ZenUtils::safeDebug($this->_install, $this, "_parseForeach", 
                          "The variable requested [{$parts[1]}] was not a valid array", 0, 2);
      return "";
    }
  }
  
  /**
   * <b>private</b>: parse a {list} call in a template
   *
   * @param array $parts the parts of the list call to be parsed
   * @return string the parsed {list} call
   */
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
   * <b>private</b>: parse a {list} call in a template
   *
   * @param array $parts the parts of the if call to be parsed
   * @return string the parsed {if} call
   */
  function _parseIf() {
    $p = trim($parts[1]);
    // determine if the if condition is true
    if( strpos($p,"=") > 0 ) {
      // there is an equals clause
      list($key,$val) = explode("=",$parts[1],1);
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
        $tpl = new zenTemplate($this->_templateDir."/".$tplname);
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
   * <b>private</b>: parse a script helper or user script and insert results
   *
   * The script can be any executable file.  Any output from the file will be
   * printed into the template.  Note that additional entries to the tag will
   * be parsed as strings and passed to the executable as follows:
   *
   * <code>
   * // presume variable = 'one'
   * {helper:myhelper.php:"clear vals":variable:"mark_"+variable}
   * // executes: `myhelper.php 'clear vals' 'one' 'mark_one'
   * </code>
   *
   * @param string $parts is the array representing the {function:file_name} tag
   * @return string the return value of the script
   */
  function _parseScript( $parts ) {
    $tf = ($parts[0] == 'helper');
    $dir = ZenUtils::getIni('directories', ($tf? 'dir_lib':'dir_user') );
    $dir .= "/".($tf? 'code':'helpers');
    $output = array();
    $file = str_replace('..','',$parts[1]);
    $file = preg_replace("/[^0-9A-Za-z_-.]/", "", $file);
    if( !@file_exists("$dir/$file") ) {
      ZenUtils::safeDebug($this->_install, $this, "_parseScript", 
                          "$parts[0] script $dir/$file could not be found", 21, LVL_ERROR);
      return '';
    }
    $command = "$dir/$file";
    for($i=2; $i<count($parts); $i++) {
      $command .= " '".$this->_parseString($parts[$i])."'";
    }
    exec( $command, $output );
    return join("\n",$output);
  }

  /**
   * <b>private</b>: parse a value string and return the results
   *
   * this will replace variables with their values
   * and the special keywords index and value
   * with the text {index} and {value}
   *
   * the value string should be in the format:
   *  "some text "+a_variable+"some more text"+another_variable... etc.
   *
   * @param string $text the text string to parse
   * @return string the parsed data
   */
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
   * <b>private</b>: returns a value from the value set provided by the user
   *
   * If the value found is an array, then it will be iterated each time this is called.
   * The first time it will return element 0, the second time it will return element 1, etc.
   *
   * @param string $name the varname
   * @return string the value of the varname
   */
  function _getVar($name) {
    // find out if we have a default value
    if( strpos($name, "=") > 0 ) {
      list($name,$default) = explode('=',$name,1);
    }
    else { $default = null; }
    // parse the array or string
    if( is_array($this->_vars) && isset($this->_vars["$name"]) && is_array($this->_vars["$name"]) ) {
      // if it is an array, we iterate each time it is requested (get the next value)
      return $this->_vars["$name"][$this->_getIteratorIndex($name)];
    }
    else if( is_array($this->_vars) && isset($this->_vars["$name"]) ) {
      return $this->_vars["$name"];
    }
    else {
      return $default? $this->_parseString($default) : '';
    }
  }

  /**
   * <b>private</b>: returns an expanded sub-template
   *
   * @param string $template the name of the sub-template to be expanded, assumed to be contained in the templates directory
   * @param mixed $value a string to be passed as {pval} to the sub-template or an array of indexed values to be passed to the sub-array
   * @param string $key the key of the value to be passed as {pkey} to the sub-template (only used when $value is a string)
   * @return the expanded sub-template
   */
  function _parseSubtemplates ( $template, $value, $key = '' ) {
    $tpl = new zenTemplate($this->_templateDir."/".$tplname);
    
    if( is_array($value) ) {
      // $value is an indexed array to be passed to the sub-template
      
      $tpl->values($value);
    } else {
      // $value/$key are a string pair to be passed as {pkey} and {pval}
      
      $tpl->values(array("pkey" => $key, "pval" => $value));
    }
    
    return $tpl->process();
  }

  /**
   * Returns an index that represents the next value in a toggle set
   */
  function _getIteratorIndex( $key ) {
    // initialize iterator
    if( !isset($this->_arrayIteratorIndex["$key"]) ) {
      $this->_arrayIteratorIndex["$key"] = -1;
    }
    // increment iterator each time this is called
    $this->_arrayIteratorIndex["$key"]++;
    // reset iterator when count is reached
    if( $this->_arrayIteratorIndex["$key"] == count($this->_vars["$key"]) ) {
      $this->_arrayIteratorIndex["$key"] = 0;
    }
    // return the current iterator
    return $this->_arrayIteratorIndex["$key"];
  }

  /**
   * Set the default directory for retrieving templates from
   */
  function setDefaultTemplateDir( $newdir ) {
    $this->_templateDir = $newdir;
  }
  
  /** @var Default template directory */
  var $_templateDir;

  var $_template; //the file we are using
  var $_text;  //the template data loaded and ready for parsing
  var $_vars;  //the variables to use for template parsing

  /** @var specifies the current index of an array in the values */
  var $_arrayIteratorIndex = array();

}

?>
