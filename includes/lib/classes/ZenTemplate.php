<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

/**
 * Contains the template processing engine
 * @package Utils
 */

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
   * 
   * {varname} // insert varname, if array, iterate each value, null if not found
   * {varname="default"} // inserts val of varname, or default if not found
   * {varname[key]} // inserts value of array varname indexed by key ($varname[key]),
   *                // varname must be an associative array or null will be returned
   * {varname[key]="string"} // as above, but default returned instead of null if key not found
   * {var:"var1":"var2"} // evaluates var1 and var2(optional) and returns value of variable named var1 (or var1[var2] if included) (see {@link _getVar2()})
   * {iterate:"var"} // evaluates var(assumed to evaluate to the name of an array) and returns the next value (see {@link _getVar()}) 
   * {zen:"category":"varname"} // inserts value from database settings using {@link Zen::getSetting()}
   * {ini:"category":"varname"} // inserts value from ini settings using {@link Zen::getIniVal()}
   * {foreach:varname:"text"+index+"more text"+value} // loops through key/value pairs, pritns string, vars index/value represent current iteration
   * {list:varname:"text"+value+"text"} // loops through array and prints string, special variable value represents current iteration
   * {join:varname:"jointext"} // joins values of an array using "jointext" as the delimiter/separator
   * {include:"template_name"} // inserts another template into this one (all values available to this template are passed)
   * {if:field:"string"} // inserts string if field exists
   * {if:field="something":"string"} // inserts string if field equals parsed value of "something"
   * {ifnot:field:"string"} // inserts string if field does not exist
   * {ifnot:field="something":"string"} // inserts string if field does not equal parsed value of "something"
   * {function:function_name:"param1","param2",...} //run a global function, parse params and pass them to the function (any number)
   * {helper:"file_name":param1="value",param2="value",...} // run helper script (includes/lib/helpers), pass params, insert return result
   * {user:"file_name"} // runs user function (includes/users/user_functions.php) and insert return value
   * {form:"table":"template":"rowid":params} // create form from database, see {@link _parseForm()}
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
   * Note that including an array in a string, such as "some text"+arrayName+" more text" will result
   * in an iteration just as if {iterate:arrayName} were called (since this is probably more intuitive than
   * printing "Array" out, which is what happens if an array is literally included in a string).
   *
   * Sub-templates recieve the special variables pkey and pval.
   * 
   *<code>
   * 
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
   *</code>
   *
   * <b>Nesting tags in strings</b>
   *
   * Template tags can be nested in string parameters (and only string parameters) using parenthesis and semicolons.  
   * The format for this is: <sample>{outer_tag:"a string with an "+(inner_tag;"parm"+intvar;parm2)+" in it"}</sample>
   *
   * These cannot be nested recursively!  Only one-deep nesting is allowed.  If you include another nested tag
   * in a nested tag, you will be sad.
   *
   * Note additionally that semicolons ";" and parenthesis ")" appearing in the nested tag text 
   * will cause confusion and parsing errors.
   *
   * Examples:
   * <code>
   * // assume the following are our template vals:
   * //   colors = array("red", "green", "blue")
   * //   bool = true
   * //   nums = array("one", "two", "three")
   * //   str = "happy"
   *
   * {if:bool=true:(include;"another_template")}
   *   // includes and parses "another_template"
   *
   * {list:colors:"It is "+value+(if;value="green";"!!")}
   *   // result:
   *   //   It is red
   *   //   It is green!!
   *   //   It is blue
   *
   * {list:colors:value+"... "+(join;nums;",")+(ifnot;value="blue";" and...")}
   *   // result:
   *   //   red... 1,2,3 and...
   *   //   green... 1,2,3 and...
   *   //   blue... 1,2,3
   * </code>
   *
   * <b>Special values index, value, pkey, and pval</b>
   * 
   * When iterating over a list or foreach, the special values 'index' and 'value' contain the key/value pair.  The
   * key is only used in foreach pairs, and the value can be a string or an array.  If a subtemplate is included
   * then the values are passed as pkey and pval (to avoid any confusion with iterations in the subtemplate.
   *
   * Examples:
   * <code>
   * // iteration of key/value pairs
   * $values["colors"] = array( "white"=>"white", "black"=>"green", "red"=>"yellow" );
   * // iteration of arrays (each pass, 'value' will be an array)
   * $values["menus"] = array( array("he","was","large","cat"), array("she","was","small","dog") );
   *
   * // put values into template
   * $template->values( $values );
   *
   * // inside the template:
   * 
   * {list:colors:"I have a "+index+" rabbit with "+value+" ears"}
   *
   * // result is:
   * //    I have a white rabbit with white ears
   * //    I have a black rabbit with green ears
   * //    I have a red rabit with yellow ears
   *
   * {list:menus:"I said '"+value+" "+value+" a "+value+", "+colors[red]+" "+value}
   *
   * // result is:
   * //    I said 'he was a large yellow cat'
   * //    I said 'she was a small yellow dog'
   *
   * {foreach:colors:%"another_template"%}
   *
   * // in our other template, let's say we have:
   * 
   * {foreach:menus:"When "+value+" was "+pkey+", "+value+" was "+pval}
   *
   * // result is:
   * //    When he was white, she was white
   * //    When he was black, she was green
   * //    When he was red, she was yellow
   * </code>
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
   * 
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
    ZenUtils::mark("ZenTemplate->init($template)");
    ZenUtils::safeDebug($this, "ZenTemplate", "initializing template '$template'", 0, LVL_NOTE);
    if( isset($GLOBALS) && isset($GLOBALS['templateDir']) ) {
      ZenUtils::safeDebug($this, "ZenTemplate", "template dir set to {$GLOBALS['templateDir']}", 0, LVL_DEBUG);
      $this->_templateDir = $GLOBALS['templateDir'];
    }
    else {
      $this->_templateDir = ZenUtils::getIni('directories','dir_templates')
        ."/".ZenUtils::getIni('layout','template_set');
      ZenUtils::safeDebug($this, "ZenTemplate", "template dir set to {$this->_templateDir} (manually)", 0, LVL_DEBUG);
    }
    $this->_template = $template;
    $this->_modifiers = array();
    $this->_get();
    ZenUtils::unmark("ZenTemplate->init($template)");
  }

  /**
   * Load variables into the template engine for parsing.  There
   * are several reserved values, which should not be set:
   * <ul>
   *   <li>pkey - parent key (used by subtemplates)
   *   <li>pval - parent value (used by subtemplates)
   *   <li>index - the current iteration index
   *   <li>value - the current iteration value
   * </ul>
   * 
   * @param array $vars indexed array of "name" => "value" pairs
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
    ZenUtils::mark("ZenTemplate->process(".$this->_template.")");
    $t = $this->_parse();
    ZenUtils::unmark("ZenTemplate->process(".$this->_template.")");
    return $t;
  }

  /**
   * <b>private</b>: get the template file and convert it to a text string
   */
  function _get() {
    if( !file_exists($this->_template) 
        && file_exists($this->_templateDir."/".$this->_template) ) {
      $this->_template = $this->_templateDir."/".$this->_template;
    }
    if( file_exists($this->_template) ) {
      $this->_text = join("",file($this->_template));
      $this->_text = preg_replace("/<!--.*-->/sm", "", $this->_text);
    }
    else {
      ZenUtils::safeDebug($this, "_get", 
                          "Could not load template '{$this->_template}'", 21, LVL_ERROR);
      $this->_text = "Template file {$this->_template} could not be found.";
    }
  }

  /**
   * Parse the contents of the template and insert values
   *
   * @access private
   * @return string parsed contents
   */
  function _parse() {
    $txtArray = explode("\n",$this->_text);
    for($i=0; $i<count($txtArray); $i++) {
      $txtArray[$i] = preg_replace("@[{]([^}]+)[}]@e", "''.\$this->_insert(\"\\1\").''",$txtArray[$i]);
    }
    $text = stripslashes(join("\n",$txtArray)); 
    $this->_runMods($text);
    $mtch = array( '/&#123;/', '/&#125;/', '/&amp;/', '/&#38;/' );
    $repl = array( '{',        '}',        '&',       '&'       );
    return preg_replace($mtch, $repl, $text);
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
   * @param string $key if this is called from an iteration, this contains current key
   * @param mixed $val if this is called from an iteration, this contains current value
   * @return string text to insert
   */
  function _insert( $text, $key = null, $val = null ) {
    // parse tags and fix literal : chars
    $parts = explode(":", $text);
    $parts = preg_replace('/&#58;/', ':', $parts);
    for($i=0; $i<count($parts); $i++) {
      $parts[$i] = trim($parts[$i]);
    }
    $index = strtolower($parts[0]);
    if( count($parts) == 1 ) {
      // {varname} - inserts value of varname
      return $this->_getVar($index);
    }    
    else {
      $it = false;
      switch($index) {
      case "iterate":
      {
        // {iterate:var}
        ZenUtils::safeDebug($this, "_insert", 
                            "using {iterate:var} for '$text'", 0, LVL_DEBUG);
        return $this->_getVar($parts[1], true);
      }
      case "var":
      {
        // {var:array:key}
        ZenUtils::safeDebug($this, "_insert", 
                            "using {var:array:key} for '$text'", 0, LVL_DEBUG);
        return $this->_getVar2($parts[1],$parts[2]);
      }
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
        $c = $this->_parseString($parts[1], $val, $key);
        $n = $this->_parseString($parts[2], $val, $key);
        ZenUtils::safeDebug($this, "_insert", 
                            "using {zen:category:varname} for '$text'", 0, LVL_DEBUG);
        return Zen::getSetting($c,$n);
      }
      case "ini":
      {
        // {ini:category:varname}
        $c = $this->_parseString($parts[1], $val, $key);
        $n = $this->_parseString($parts[2], $val, $key);
        ZenUtils::safeDebug($this, "_insert", 
                            "using {ini:category:varname} for '$text'", 0, LVL_DEBUG);
        return ZenUtils::getIni($c,$n);
      }
      case "foreach":
      {
        // {foreach:varname:"text"+index+"more text"+value}
        ZenUtils::safeDebug($this, "_insert", 
                            "using {foreach:varname:...} for '$text'", 0, LVL_DEBUG);
        return $this->_parseForeach($parts);
      }
      case  "list":
      {
        // {list:varname:"text"+value+"text"}
        ZenUtils::safeDebug($this, "_insert", 
                            "using {list:varname:...} for '$text'", 0, LVL_DEBUG);        
        return $this->_parseList($parts);
      }
      case  "include":
      {
        // {include:template_name}
        ZenUtils::safeDebug($this, "_insert", 
                            "using {include:template_name} for '$text'", 0, LVL_DEBUG);        
        $valset = $this->_vars;
        if( $key || $val ) {
          $valset['pkey'] = $key;
          $valset['pval'] = $val;        
        }
        return $this->_parseSubtemplate($parts[1], $valset);
      }
      case  "if":
      {
        // {if:field:"text to print"+field+"text to print"}
        // {if:field=something:"text to print"+field+"more text"}
        ZenUtils::safeDebug($this, "_insert", "using {if:field...:...} for '$text'", 0, LVL_DEBUG);        
        return $this->_parseIf($parts);
      }
      case "ifnot":
      {
        // {ifnot:field:"text"}
        // {ifnot:field="something":"text"}
        ZenUtils::safeDebug($this, "_insert", "using {ifnot:field...:...} for '$text'", 0, LVL_DEBUG);        
        return $this->_parseIfnot($parts);        
      }
      case "helper":
      case "script":
      {
        // {helper:file_name}
        // {user:file_name}
        ZenUtils::safeDebug($this, "_insert", "using {user|helper:function:args} for '$text'", 0, LVL_DEBUG);
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
        // {tr:"string":values}
        ZenUtils::safeDebug($this, "_insert", "using {tr:string:values} for '$text'", 0, LVL_DEBUG);
        return $this->_tr($parts);        
      }
      default:
      {
        // return text 'as-is' if we fall through (maybe it's not supposed to be a tag)
        ZenUtils::safeDebug($this, "_insert", "invalid tag: '$text'", 103, LVL_WARN);
        return $text;
      }
      }//end switch()

    }
  }

  /**
   * Parse a {form} call in a template
   *
   * The format is: {form:table:template:rowid:types}, where:
   * <ul>
   *  <li><b>table</b> - (string)db table to load form info from
   *  <li><b>template</b> - (string)template to display form
   *  <li><b>rowid</b> - (string,optional) if provided, this row of data will be loaded into the form
   *  <li><b>types</b> - (comma delimited,optional) provides a means to override the form field type for each field
   *               <br>the types formatted like param1="select",param2="text",...etc...
   * </ul>
   *
   * @access private
   * @return string the parsed text
   */
  function _parseForm( $parts ) {
    $form = new ZenFormGenerator($this->_parseString($parts[1]), 
                                 $this->_parseString($parts[2]));
    if( isset($parts[3]) ) {
      $form->loadData($this->_parseString($parts[3]));
    }
    if( isset($parts[4]) ) {
      $set = explode(",",$parts[4]);
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
    $vars = $this->_getVar($parts[1]);
    if( is_array($vars) ) {
      $txt = "";
      // loop the list and make output text
      foreach($vars as $k=>$v) {
        // make the string to show
        $txt .= $this->_parseString($parts[2], $v, $k);
      }
      return $txt;
    }
    else {
      ZenUtils::safeDebug($this, "_parseForeach", 
                          "The variable requested [{$parts[1]}] was not a valid array", 
                          105, LVL_WARN);
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
        $txt .= $this->_parseString($parts[2], $v);
      }
      return $txt;
    }
    else {
      ZenUtils::safeDebug($this, "_parseList",
                          "The requested list ({$parts[1]}) was not a valid array",
                          105, LVL_WARN);
      return "";
    }
  }
  
  /**
   * <b>private</b>: parse an {if} call in a template
   *
   * @param array $parts the parts of the if call to be parsed
   * @return string
   */
  function _parseIf( $parts ) {
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
   * <b>private</b>: parse a helper or user function and insert results
   *
   * The script can be any executable file.  Any output from the file will be
   * printed into the template.  Note that additional entries to the tag will
   * be parsed as strings and passed to the executable as follows:
   *
   * <code>
   * // presume args contains whatever the function needs to do its job
   * {helper:helper_function:args}
   * {user:user_function:args}
   * </code>
   *
   * @param string $parts is the array representing the {function:file_name} tag
   * @return string the return value of the script
   */
  function _parseScript( $parts ) {
    if( $parts[0] == 'helper' ) {
      return ZenUtils::runHelper($parts[1], $this->_parseString($parts[2]));
    }
    else {
      return ZenUtils::runUserScript($parts[1], $this->_parseString($parts[2]));
    }
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

    // parse the string to print
    $it = 0;
    $str = "";
    for($i=0; $i < strlen($text); ) {
      // find the next segment we want to examine
      $j = strpos( $text, '+', $i );
      if( $j <= 0 ) { $j = strlen($text)+1; }
      
      // determine what we have
      $s = trim(substr($text, $i, $j-$i));
      if( $s == 'index' ) {
        // this is the foreach key
        $str .= $key;
      }
      else if( $s == 'value' ) {
        // this is the foreach value
        // include the array index or variable (if not an array)
	$str .= is_array($value)? $value[$it++] : $value;
        if( is_array($value) && $it == count($value) ) {
          // reset the iterator
          $it = 0;
        }
      }
      else if( strpos($s, '"') === 0 ) {
        // this is a string, strip the quotes
        $str .= substr($s, 1, -1);
      }
      else if( strpos($s, '(') === 0 ) {
        // this is a nested tag
        // replace any : chars with html entity
        // reformat the ; chars into : and parse
        $j = strpos( $text, ')', $i )+1;
        if( $j <= 0 ) { $j = strlen($text)+1; }
        $s = trim(substr($text, $i, $j-$i));
        $tag = str_replace(':', '&#58;', substr($s,1,-1));
        $tag = str_replace(';', ':', $tag);
        $str .= $this->_insert($tag, $key, $value);
      }
      else {
        // assume this is a variable
	$t = $this->_getVar($s);
        // if we get a variable which is an array
        // included at this point, we can assume
        // that the user wants a variable from it
        // and not the array itself, so we will
        // use the iteration value (rather than
        // printing 'Array' to the screen)
        if( is_array($t) ) {
          $t = $this->_getVar($s,true);
        }
        $str .= $t;
      }
      $i = $j+1;
    }

    // fix return chars
    $match = array('/\n/', '/\t/', '/&#43;/');
    $repl  = array(  "\n",   "\t", '+');
    //$str = str_replace('&quot;', '"', $str);
    //$str = str_replace('&#34;', '"', $str);
    return str_replace($match, $repl, $str);
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
   * If the value found is an array and $iteratue is true(if this was called
   * by an {iterate:"var"} component, then it will be iterated each time this is called.
   *
   * The first time it will return element 0, the second time it will return
   * element 1, and so on.
   *
   * @param string $name the varname
   * @param string $iterate 
   * @return string the value of the varname
   */
  function _getVar($name, $iterate = false) {
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
    else if( $iterate && 
             is_array($this->_vars) && isset($this->_vars["$name"]) 
             && is_array($this->_vars["$name"]) ) {
      // if it is an array, we iterate each time it is requested (get the next value)
      return $this->_vars["$name"][$this->_getIteratorIndex($name)];
    }
    else if( is_array($this->_vars) && isset($this->_vars["$name"]) ) {
      return $this->_vars["$name"];
    }
    return $default;
  }
  
  /**
   * Parses complex array requirements and returns value. The parameters for this are
   * evaluated as strings expected to represent variables, then the value is retrieved.
   *
   * Examples:
   * <code>
   *
   * $A = "happy";
   * $letter = "A";
   * $vals = array( "A" => "Apple", "B" => "Boy", "C" => "Cake" );
   * $morevals = array( "vals" => $vals, "happy" => "yep, sure am" );
   * 
   * {var:"letter"} // "$letter" = 'A' 
   * {var:letter}   // $$letter = $A = 'happy'
   * {var:"vals["+letter+"]"} // $vals[$letter] = $vals['A'] = 'Apple'
   * {var:"morevals["+letter+"]"} // $morevals[$$letter] = $morevals[$A] = 'yep, sure am'
   * {var:"vals":"B"} // $vals['B'] = 'Boy'
   * {var:"morevals[vals]":letter} // $morevals['vals'][$letter] = $morevals['vals']['A'] = 'Apple'
   * {var:"morevals[vals]":"A" // $morevals['vals']['A'] -> 'Apple'
   * {var:"vals[letter]"} // $vals["letter"] = null!
   * {var:"vals":B}   // $vals[$B] = null!
   * {var:vals[C]}  // ${"$vals['C']"} = $Cake = null!
   * </code>
   *
   * @param string $var1 evaluates to name of a variable
   * @param string $var2 if provided, evaluates to key in array specified by var1
   * @return mixed value
   */
  function _getVar2($var1, $var2) {
    $val1 = $this->_parseString($var1);
    $val2 = $this->_parseString($var2);
    return $this->_getVar("{$val1}[{$val2}]");
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
    return ZenUtils::translate($this->_parseString($parts[1]), (isset($parts[2])? $this->_parseString($parts[2]):null) );
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
