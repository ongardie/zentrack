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
   *  &lt;h3&gt;{title}&lt;/h3&gt;
   *  &lt;form name="{name}" action="{action}"&gt;
   *  {list:array_name:"&lt;input type='text' name='"+index+"' value='"+value+"'>"}
   *  &lt;/form&gt;
   *  </pre>
   *
   * <b>Valid template entries are:</b>
   *<code>
   * {varname} // insert varname, if array, iterate each value, null if not found
   * {varname="default"} // inserts val of varname, or default if not found
   * {varname[key]} // inserts value of array varname indexed by key (varname[key]),
   *                // varname must be an associative array or null will be returned
   * {varname[key]="string"} // as above, but default returned instead of null if key not found
   * {zen:"category":"varname"} // inserts value from database settings using {@link Zen::getSetting()}
   * {ini:"category":"varname"} // inserts value from ini settings using {@link Zen::getIniVal()}
   * {foreach:varname:"text"+index+"more text"+value} // loops through key/value pairs, pritns string, vars index/value represent current iteration
   * {list:varname:"text"+value+"text"} // loops through array and prints string, special variable value represents current iteration
   * {include:"template_name"} // inserts another template into this one (all values available to this template are passed)
   * {if:field:"string"} // inserts string if field exists
   * {if:field="something":"string"} // inserts string if field equals parsed value of "something"
   * {ifnot:field:"string"} // inserts string if field does not exist
   * {ifnot:field="something":"string"} // inserts string if field does not equal parsed value of "something"
   * {function:function_name:"param1","param2",...} //run a global function, parse params and pass them to the function (any number)
   * {helper:"file_name":param1="value",param2="value",...} // run helper script (includes/lib/helpers), pass params, insert return result
   * {script:"file_name"} // runs script (includes/users/code) and insert return value
   * {form:"table":"template":field1="ftype",field2="ftype",...} // create form from database, types changed by final param(optional)
   * {modifier:"command"} // special condition for template parser, see below.
   * {tr:"string":vars} // translate a string of text to the selected language, vars is an optional variable or list of vars to pass to the string
   *</code>
   *
   * Note that all the properties listed above in "quotes" are strings. Usage of strings is
   * explained below.
   *
   * <b>How strings work:</b>
   * 
   * A string consists of two elements: variable names and string literals.  String literals are surrounded
   * by quotes (" "), and are printed exactly as they appear, variables are parsed into the value passed to the
   * template system.  a + is used to join variables and strings together.  Here are some examples:
   *
   * Note that listeral " and : characters can be included in template tags using &quot; and &#58; repectively.  
   * These will be reverted once the template tags have been parsed.
   *
   * Note that using %"string"% will insert parsed template (includes/lib/templates/..set../), the name is a string.
   * There cannot be any other text with the template (the string param must begin and end with %(template) symbols.
   *
   * Sub-templates recieve the special varaibles pkey and pval.  If this is a 
   * 
   *<code>
   * // assume the following are entered into our
   * // template values: 
   * //   color    => 'blue'
   * //   fruit    => 'apple'
   * //   somevals => array('somekey'=>'happy')
   *
   * "I am "+color+"!"            // produces 'I am blue!'
   * "I found a "+color+fruit     // produces 'I found a blueapple'
   * "a "+color+" "+fruit         // produces 'a blue apple'
   * 2.50                         // produces '2.5'
   * "2.50"                       // produces '2.50'
   * somevals[somekey]+" day"     // produces 'happy day'
   * %"some_template.template"%   // parses and returns results of some_template.template
   * %color+".template"%          // parses and returns results of blue.template
   * "I am a "+%"template_name"%  // causes an error!
   *</code>
   *
   * <b>Comments in templates:</b>
   * 
   * Comments can be provided using normal html <!--    --> tags.  These tags cannot be nested!  All html comments
   * will be stripped before rendering page.
   * 
   * <b>Special Template Modifiers</b>
   *
   * Using the {modifier:command} option, the template parser behavior can be altered. The valid commands are:
   *<code>
   * {modifier:"stripEmptyLines"} // remove empty lines (extra carriage returns)
   * {modifier:"stripAllReturns"} // remove all carriage returns
   *</code>
   *
   * @package Utils
   */
class ZenTemplate {

  /**
   * invoke the template class
   *
   * @param string $template is the path to the template file to load
   */
  function ZenTemplate( $template ) {
    ZenUtils::safeDebug($this, "ZenTemplate", "initializing template '$template'", 0, LVL_NOTE);
    if( isset($GLOBALS) && isset($GLOBALS['templateDir']) ) {
      $this->_templateDir = $GLOBALS['templateDir'];
    }
    else {
      $this->_templateDir = ZenUtils::getIni('directories','dir_templates')
        +"/"+ZenUtils::getIni('layout','template_set');
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
   * Sets a special modifier flag that will affect template output
   *
   */
  function setModifier($mod) {
    $this->_modifiers[] = $mod;
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
      $text = join("",file($this->_template));
      $text = preg_replace("/<!--.*-->/", "", $text);
      $this->_text = explode("\n",$text);
    }
    else {
      ZenUtils::safeDebug($this, "_get", 
                          "Could not load template '{$this->_template}'", 21, LVL_ERROR);
      $this->_text = array("Template file {$this->_template} could not be found.");
    }
  }

  /**
   * Parse the contents of the template and insert values
   *
   * @access private
   * @return string parsed contents
   */
  function _parse() {
    $txt = $this->_text;
    for($i=0; $i<count($txt); $i++) {
      $txt[$i] = preg_replace("@[{]([^}]+)[}]@e", "''.\$this->_insert(\"\\1\").''",$txt[$i]);
    }
    $text = stripslashes(join("",$txt)); 
    $this->_runMods($text);
    return $text;
  }

  /**
   * Read any modifiers and alter output accordingly
   *
   * @param string $text
   * @return string
   */
  function _runMods($text) {
    foreach($this->_modifiers as $m) {
      switch($m) {
      case "stripEmptyLines":
        $text = preg_replace("/\n\n/", "\n", $text);
        break;
      case "stripAllReturns":
        $text = preg_replace("/[\n\r]/", "", $text);
        break;
      default:
        ZenUtils::safeDebug($this, "_parseMods", "$m was an invalid modifier", LVL_WARN);
        break;
      }
    }
    return $text;
  }

  /**
   * Parse the inserts in the template and return text for replacement
   *
   * @access private
   * @param string $text text to be replaced
   * @return string text to insert
   */
  function _insert( $text ) {
    // parse tags and fix literal : chars
    $parts = explode(":", $text);
    $parts = preg_replace('/&#58;/', ':', $parts);
    $index = strtolower(trim($parts[0]));
    for($i=1; $i<count($parts); $i++) {
      $parts[$i] = trim($parts[$i]);
    }
    if( count($parts) == 1 ) {
      // {varname} - inserts value of varname
      return $this->_getVar($index);
    }    
    else {
      switch($index) {
      case "modifier":
      {
        // {modifier:some_command}
        ZenUtils::safeDebug($this, "_insert", 
                            "using {modifier:some_command} for '$text'", 0, LVL_DEBUG);
        return $this->_parseMofifier($parts);        
      }
      case "zen":
      {
        // {zen:category:varname}
        $c = $this->_parseString($parts[1]);
        $n = $this->_parseString($parts[2]);
        ZenUtils::safeDebug($this, "_insert", 
                            "using {zen:category:varname} for '$text'", 0, LVL_DEBUG);
        return Zen::getSetting($c,$n);
      }
      case "ini":
      {
        // {ini:category:varname}
        $c = $this->_parseString($parts[1]);
        $n = $this->_parseString($parts[2]);
        ZenUtils::safeDebug($this, "_insert", 
                            "using {ini:category:varname} for '$text'", 0, LVL_DEBUG);
        return Zen::getIniVal($c,$n);
      }
      case "foreach":
      {
        // {foreach:varname:"text"+index+"more text"+value}
        // {foreach:varname:%sub-template%}
        
        ZenUtils::safeDebug($this, "_insert", 
                            "using {foreach:varname:...} for '$text'", 0, LVL_DEBUG);
        return $this->_parseForeach($parts);
      }
      case  "list":
      {
        // {list:varname:"text"+value+"text"}
        // {list:varname:%sub-template%}
        ZenUtils::safeDebug($this, "_insert", 
                            "using {list:varname:...} for '$text'", 0, LVL_DEBUG);        
        return $this->_parseList($parts);
      }
      case  "include":
      {
        // {include:template_name}
        $tmp = new zenTemplate($this->_parseString($parts[1]));
        $tmp->values( $this->_vars );
        ZenUtils::safeDebug($this, "_insert", 
                            "using {include:template_name} for '$text'", 0, LVL_DEBUG);        
        return $tmp->process();
      }
      case  "if":
      {
        // {if:field:"text to print"+field+"text to print"}
        // {if:field=something:"text to print"+field+"more text"}
        // {if:field:%sub-template%}
        // {if:field=something:%sub-template%}
        ZenUtils::safeDebug($this, "_insert", "using {if:field...:...} for '$text'", 0, LVL_DEBUG);        
        return $this->_parseIf($parts);
      }
      case "ifnot":
      {
        // {ifnot:field:"text"}
        // {ifnot:field:%sub-template%}
        ZenUtils::safeDebug($this, "_insert", "using {ifnot:field...:...} for '$text'", 0, LVL_DEBUG);        
        return $this->_parseIfnot($parts);        
      }
      case "helper":
      case "script":
      {
        // {helper:file_name}
        // {script:file_name}
        ZenUtils::safeDebug($this, "_insert", "using {script|helper:file_name} for '$text'", 0, LVL_DEBUG);
        return $this->_parseScript($parts);     
      }
      case "form":
      {
        // {form:table_name:fields}
        ZenUtils::safeDebug($this, "_insert", "using {form:table_name:fields} for '$text'", 0, LVL_DEBUG);
        return $this->_parseForm($parts);
      }
      case "tr":
      {
        // {tr:"string"}
        ZenUtils::safeDebug($this, "_insert", "using {tr:string} for '$text'", 0, LVL_DEBUG);
        return $this->_tr($parts);        
      }
      }
      
    }
    // return something generic if we fall through
    ZenUtils::safeDebug($this, "_insert", "invalid tag: '$text'", 103, LVL_WARN);
    return "{invalid tag: $index}";
  }

  /**
   * Parse a {form} call in a template
   *
   * @access private
   * @return string the parsed text
   */
  function _parseForm( $parts ) {
    $form = new ZenFormGenerator($this->_parseString($parts[1]), 
                                 $this->_parseString($parts[2]));
    if( $parts[3] ) {
      $set = explode(",",$parts[3]);
      foreach( $set as $entry ) {
        list($key,$val) = explode("=",$entry);
        $form->modifyField( $key, array("ftype"=>$this->_parseString($val)) );
      }
    }
    return $form->render();
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
      // loop the list and make output text
      foreach($vars as $k=>$v) {
        // make the string to show
        if( $this->_isSub($parts[2]) ) {
          $str = $this->_parseString($parts[2], $v, $k);
        }
      }
      return $txt;
    }
    else {
      ZenUtils::safeDebug($this, "_parseForeach", 
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
      // create the output text
      foreach($vars as $v) {
        // parse the string
        if( $this->_isSub($parts[2]) ) {
          $str = $this->_parseString($parts[2], $v);
        }
        //return the text
        $txt .= str_replace("{value}", $v, $str);
      }
      return $txt;
    }
    else {
      return "";
    }
  }
  
  /**
   * <b>private</b>: parse an {if} call in a template
   *
   * @param array $parts the parts of the if call to be parsed
   * @return string
   */
  function _parseIf() {
    $p = trim($parts[1]);
    // determine if the if condition is true
    if( strpos($p,"=") > 0 ) {
      // there is an equals clause
      list($key,$val) = explode("=",$parts[1],1);
      $key = trim($key);
      $val = trim($val);
      $tf = ($this->_getVar($key) == $this->_parseString($val));
    }
    else {
      $var = $this->_getVar($p);
      $tf = ( (is_array($var) && count($var)) || (strlen($var) > 0) );
    }
    // execute the query if we met if condition
    if( $tf ) {
      // return text
      return $this->_parseString($parts[2]);
    }
    else {
      return "";
    }
  }  

  /**
   * <b>private</b>: parse an {ifnot} call in a template
   *
   * @param $parts the parts of the {ifnot} call
   * @return string
   */
  function _parseIfnot( $parts ) {
    $p = trim($parts[1]);
    // determine if the if condition is true
    if( strpos($p,"=") > 0 ) {
      // there is an equals clause
      list($key,$val) = explode("=",$parts[1],1);
      $key = trim($key);
      $val = trim($val);
      $tf = ($this->_getVar($key) != $this->_parseString($val));
    }
    else {
      $var = $this->_getVar($p);
      $tf = ( !is_array($var) || (is_array($var) && !count($var)) || (strlen($var) < 1) );
    }
    // execute the query if we met if condition
    if( $tf ) {
      // return text
      return $this->_parseString($parts[2]);
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
    $file = $this->_parseString($parts[1]);
    $file = str_replace('..','',$file);
    $file = preg_replace("/[^0-9A-Za-z_-.]/", "", $file);
    if( !@file_exists("$dir/$file") ) {
      ZenUtils::safeDebug($this, "_parseScript", 
                          "$parts[0] script $dir/$file could not be found", 21, LVL_ERROR);
      return '';
    }
    $command = "$dir/$file";
    for($i=2; $i<count($parts); $i++) {
      $command .= " ".$this->_parseString($parts[$i]);
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
   * @param string $value the value if we are iterating a list or foreach (if blank, $this->_vals will be used)
   * @param string $key the key if we are iterating a list or foreach (do not pass a key if there is no value!)
   * @return string the parsed data
   */
  function _parseString( $text, $value = null, $key = '' ) {
    $text = str_replace('\\"', '"', $text);
    // deal with subtemplates
    if (preg_match('/^%(.+)%$/', $parts[2], $matches)) {
      // if the whole entry is a template, then return it
      // parse values and try to create special pkey and pval params 
      $vals = $this->_vars;
      if( $key ) { $vals['pkey'] = $key; }
      if( $value ) { $vals['pval'] = $value; }
      return $this->_parseSubtemplate($matches[1], $vals);
    }
    // parse the string to print
    $vals = explode("+",trim($text));
    $str = "";
    foreach($vals as $v) {
      $v = trim($v);
      // this is a string
      if( strpos($v,'"') === 0 || is_numeric($v) ) {
	$str .= preg_replace('/^"/', "", preg_replace('/"$/', "", $v)); 
      }
      // this is the foreach key   
      else if( $v == "index" ) {
	$str .= $key;
      }
      // this is the foreach value
      else if( $v == "value" ) {
	$str .= $value;
      }
      // this is another variable
      else {
	$str .= $this->_getVar($v);
      }
    }
    // fix return chars
    $str = str_replace('\n', "\n", $str);
    $str = str_replace('\t', "\t", $str);
    // fix html entities
    $str = str_replace('&quot;', '"', $str);
    $str = str_replace('&#34;', '"', $str);
    $str = str_replace('&amp;', '&', $str);
    $str = str_replace('&#38;', '&', $str);
    return $str;
  }

  /**
   * <b>private</b>: deal with special modifiers that affect template parsing
   *
   * @param array $parts
   */
  function _parseModifier( $parts ) {
    $this->setModifier($this->_parseString($parts[1]));
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
      list($name,$default) = explode('=',$name,2);
      $default = $this->_parseString($default);
    }
    else { $default = null; }
    // parse the array or string
    if( preg_match("/^([a-zA-Z0-9_]+)\[([a-zA-Z0-9_]+)]$/", $name, $matches) ) {
      $name = $matches[1];
      $key = $matches[2];
      if( is_array($this->_vars) && isset($this->_vars["$name"]) && is_array($this->_vars["$name"])
          && isset($this->_vars["$name"]["$key"]) ) { return $this->_vars["$name"]["$key"]; }
      else { return $default; }
    }
    else if( is_array($this->_vars) && isset($this->_vars["$name"]) && is_array($this->_vars["$name"]) ) {
      // if it is an array, we iterate each time it is requested (get the next value)
      return $this->_vars["$name"][$this->_getIteratorIndex($name)];
    }
    else if( is_array($this->_vars) && isset($this->_vars["$name"]) ) {
      return $this->_vars["$name"];
    }
    else {
      return $default;
    }
  }

  /**
   * <b>private</b>: returns an expanded sub-template
   *
   * @param string $template the name of the sub-template to be expanded, assumed to be contained in the templates directory
   * @param array $values is the values to be provided to subtemplate, if this is an iteration, this should contain special
   *                      variables 'pkey' and 'pval', which represent the current iteration key/value pair
   * @return the expanded sub-template
   */
  function _parseSubtemplate( $template, $values ) {
    $template = $this->_parseString($template);
    $tpl = new zenTemplate($this->_templateDir."/".$template);        
    $tpl->values($values);   
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
   * Translate an entry
   */
  function _tr( $parts ) {
    return ZenUtils::translate($parts[1], ($parts[2]? $parts[2]:null) );
  }

  /**
   * Set the default directory for retrieving templates from
   */
  function setDefaultTemplateDir( $newdir ) {
    $this->_templateDir = $newdir;
  }
  
  /** @var String default template directory */
  var $_templateDir;

  /** @var Array special modifiers for template processing */
  var $_modifiers;

  var $_template; //the file we are using
  var $_text;  //the template data loaded and ready for parsing
  var $_vars;  //the variables to use for template parsing

  /** @var specifies the current index of an array in the values */
  var $_arrayIteratorIndex = array();

}

?>
