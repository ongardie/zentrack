<?php

/**
 * Drop this file in the web directory to run PHPUnit tests
 *
 * Documentation: {@link 
 * @package PHPUnit
 */

if (!defined('PHP_UNIT_INCLUDED')) 
{

define('PHP_UNIT_INCLUDED', true);

function errorHandler($errno, $errstr, $errfile, $errline) 
{
  global $ERROR_FOUND, $ERROR_CRITICAL;
  switch($errno) 
    {
    case E_USER_ERROR:
      echo "<span style='color:#660000'>Fatal error: $errstr</span><br>";
      echo "Skipping remaining tests for this unit...";
      $ERROR_FOUND    = true;
      $ERROR_CRITICAL = true;
      break;
    case E_USER_WARNING:
      echo "<span style='color:#660000'>$errstr</span><br>";
      $ERROR_FOUND = true;
      break;
    case E_WARNING:
      echo "PHP WARNING on line <b>$errline</b> of file <b>$errfile</b>:";
      echo "$errstr<br>";
      break;
    case E_NOTICE:
      echo "PHP NOTICE on line <b>$errline</b> of file <b>$errfile</b>:";
      echo "$errstr<br>";
      break;
    case E_ERROR:
      echo "PHP ERROR on line <b>$errline</b> of file <b>$errfile</b>";
      echo "$errstr<br>";
      echo "<br><b>Aborting...</b>";
      exit -1;
      break;
    default:
      echo "PHP Unkown error $errno: $errstr<br>\n";
      break;
    }
}

/**
 * Used to handle errors during phpUnit testing
 * @package PHPUnit
 */
class Assert {
  function assert($bool, $message = '') {
    if (!$bool) {
      if ($message == '') {
	$message = "Assertion failed.";
      }
      trigger_error($message, E_USER_ERROR);
    }
  }
  
  function equals($value1, $value2, $message = '') {
    if ($value1 != $value2) {
      if ($message == '') {
	$message = "Assertion failed: <b>'$value1' != '$value2'</b>";
      }
      trigger_error($message, E_USER_WARNING);
    }
  }
  
  function equalsTrue($bool, $message = '') {
    Assert::equals($bool, true, $message);
  }
  
  function equalsFalse($bool, $message = '') {
    Assert::equals($bool, false, $message);
  }
}

/**
 * All PHPUnit tests should extend this class
 *
 * Try calling the phpunit.php page for documentation on usage.
 *
 * @package PHPUnit
 */
class Test {
  /**
   * Call all methods starting with 'test'. $class is the name of the class.
   * Although not strictly necessary, it makes the output look better 
   * (properly capitalized).
   *
   * @param string $class is a reference to the class name
   * @param string $xml is an xml data file to get test data from
   */
  function run($class, $xml = false) {
    global $ERROR_FOUND, $ERROR_CRITICAL, $TESTS_COMPLETED,
      $TESTS_SKIPPED, $TESTS_TOTAL; // Yikes!
    if (strlen($class) > 4 && strtolower(substr($class, -4)) == 'test')
      {
	$class = substr($class, 0, strlen($class) - 4);
      }
    echo "\t<tr>\n";
    echo "\t  <th colspan=2><b>$class</b></th>\n";
    echo "\t</tr>\n";
    $ERROR_CRITICAL = false;
    $flipCss        = false;
    $methods        = get_class_methods($this);

    $xmlnode = null;
    if( $xml ) {
      $parser = new ZenXMLParser();
      $xmlnode =& $parser->parse($xml);
    }
    if( method_exists($this, "load") ) {
      if( $xmlnode ) {
	$child = $xmlnode->getChild('setup');
	if( $child ) { $this->load($child[0]); }
      }
      else {
	$this->load();
      }
    }

    foreach ($methods as $method) {
      // Don't continue running tests if something really bad happened.
      // That is, if Assert::assert evaluated to true.
      if ($ERROR_CRITICAL) {
	break;
      }
      // Run a test if this method applies
      if (strlen($method) > 4 && substr($method, 0, 4) == 'test') {
	$ERROR_FOUND = false;
	$node = null;
	if( $xmlnode ) {
	  $n = $xmlnode->getChild($method); 
	  if( $n ) {
	    $node = $n[0];
	  }
	}
	if( $node ) {
	  $sets = $node->getChildren();
	  foreach( $sets as $testname=>$valset ) {
	    foreach( $valset as $val ) {
	      $ERROR_FOUND = false;
	      $TESTS_TOTAL++;
	      $children = $val->getChild('param');
	      $parms = ZenXMLParser::getParmSet( $children );
	      $this->_openRow( substr($method,4).": <i>$testname</i>" );
	      $this->$method( $parms );
	      if( !$ERROR_FOUND ) { $TESTS_COMPLETED++; }
	      $this->_closeRow( $ERROR_FOUND );
	    }
	  }
	}
	else {
	  $TESTS_TOTAL++;
	  $this->_openRow( substr($method, 4) );
	  $this->$method();
	  if( !$ERROR_FOUND ) { $TESTS_COMPLETED++; }
	  $this->_closeRow( $ERROR_FOUND );
	}
      }
    }

    if( method_exists($this, "unload") ) {
      $this->unload();
    }
  }
    
  /** Print html for a new table row */
  function _openRow( $name ) {
    static $css;
    $css = ($css=='light')? 'dark' : 'light';
    echo "\t<tr>\n";
    echo "\t  <td class=$css width=300 nowrap valign=top>";
    echo "$name</td>\n";
    echo "\t  <td class=$css valign=top>";
  }

  /**  Print html to close data row */
  function _closeRow( $err ) {
    if (!$err) {
      echo "<b>OK</b>";
    }
    echo "\t  </td>\n";
    echo "\t</tr>\n";
  }

}

$directory  = isset($_GET['directory']) ? $_GET['directory'] : '';
$showdebug = isset($_GET['showdebug'])? $_GET['showdebug'] : '';
$dirValid   = ($directory != '' && is_dir($directory));

if ($dirValid) 
{
  $title = ': Results';
}
else 
{
  $title = ': Configuration'; 
}

/**
 * Generates a list of possible tests by listing
 * all subdirectories of the test directory
 * (where this file is located)
 */
 function getTestList() {
   $dir = dirname(__FILE__);
   $dh = opendir($dir);
   $list = array();
   while( $file = readdir($dh) ) {
     if( is_dir("$dir/$file") && strpos($file, '.') !== 0 && $file != 'CVS') {
       $list[] = "$dir/$file";
     }
   }
   return $list;
 }
?>
<html>
  <head>
    <title>PHP Unit Tester<?php echo $title ?></title>
    <style>
    body {
    	background-color: rgb(95%, 95%, 100%);
    	font-family: Verdana, Arial, Helvetica, sans-serif;
    	margin-left: 10%;
        margin-right: 10%;
    }
    
    h1, h2 {
    	text-align: center;
    }
    
    th {
    	background-color: rgb(0%, 0%, 0%);
        color: white;
        font-size: 15px;
        font-weight: bold;
    }
    
    td {
    	padding: 2px 10px 2px 10px;
        font-size: 13px;
    }

    table {
    	border: 1px solid black;
    }
    
    td.dark {
    	background-color: rgb(80%, 80%, 90%);
    }
    
    td.light {
    	background-color: rgb(90%, 90%, 100%);
    }
    
    a:link {
    	text-decoration: none;
        color: rgb(0%, 0%, 60%);
        font-weight: bold;
    }
    
    a:hover {
    	text-decoration: underline;
        color: rgb(0%, 0%, 70%);
    }
    
    a:visited {
    	color: rgb(0%, 0%, 80%);
    }
    </style>
  </head>
  
  <body>
    <h1>PHP Unit Tester<?php echo $title ?></h1>
  <form name='selectForm'>
    <b>Directory</b>: 
    <select name='directory' onChange='document.selectForm.submit()'>
<?
     foreach( getTestList() as $key ) {
       $val = basename($key);
       $sel = (basename($directory) == $val)? ' selected' : '';
       print "<option value='$key'$sel>$val</option>\n";
     }
?>
    </select>
    &nbsp;<input type='checkbox' name='showdebug' value='1' <?=$showdebug? 'checked':''?>> Debug
    &nbsp; <input type=submit value="Run Tests">
  </form>
<?php
if ($dirValid) 
{
  $errorHandler = set_error_handler("errorHandler");
  error_reporting (E_ALL);
  echo "    <table align=center border=0 cellpadding=0 cellspacing=0 ";
  echo "width=100%>\n";
  $TESTS_TOTAL     = 0;
  $TESTS_COMPLETED = 0;
  $handle          = opendir($directory);
  while (($file = readdir($handle)) !== false) {
    if (strlen($file) > 5 && substr($file, -3) == 'php') {
      include_once($directory . '/' . $file);
      $class = substr($file, 0, strlen($file) - 4);
      if (class_exists($class)) {
	$test = new $class;
	if (is_subclass_of($test, 'Test')) {
	  if( file_exists("$directory/$class.xml") ) {
	    $test->run($class,"$directory/$class.xml");
	  }
	  else {
	    $test->run($class);
	  }
	}
      }
    }
  }
  closedir($handle);
  if( strlen($errorHandler) )
    set_error_handler($errorHandler);
  echo "    </table>\n";
  echo "    <p>Successfully executed <b>$TESTS_COMPLETED</b> of ";
  echo "<b>$TESTS_TOTAL</b> tests</p>\n";
}
else 
{
?>
  <p>
    <b>Tip</b>: After setting the correct directory and clicking <b>Run Tests</b>, save 
    a bookmark to the resulting page. Opening that bookmark will immediately re-run all
	tests.
  </p>
  <h2>About the PHP Unit Tester</h2>
  <p>
    This small application can be used to automatically test PHP units. Although
	(very!) distantly related to <a href="http://www.junit.org">jUnit</a>, it is by no
	means as advanced as that particular package, nor is it intended to be. By 
    the way, if you're not into Object-Oriented Programming, haven't heard of
    <i>Extreme Programming</i>, or the term <i>Refactoring</i> means nothing to you, 
    this application is probably not for you.
  </p>
  <p>
    How does it work? Well, first put this file somewhere on your development 
	server. Then open it in your favorite browser (through the server), type in the 
	local path to the test units (e.g. <b>/data/www/tests</b>), and press 
    <b>Run Tests</b>. That's all!
  </p>
  <p>
    Once a valid directory has been set, this application reads all PHP-files
	(<b>*.php</b>) in that directory, and runs the tests in them. Thus, to add a
	test to your suite, simply put it in mentioned directory.
  </p>
  <p>
    Every test must be implemented in a class with the same name as the file it
	is in. Thus, class <b>FileTest</b> should be in <b>FileTest.php</b>. Also,
	the class must be a subclass of class <b>Test</b>. There's no need to include
	this class, as this application takes care of that.
  </p>
  <p>
    A basic test-class looks as follows (note, class <b>File</b> doesn't actually exist):
  </p>
  <pre><code>    require_once('File.php'); // This is the class we're testing
  
    class FileTest extends Test 
    {
        var $file;

        function FileTest() 
        {
            unset($this->file);
            $this->file = new File();
        }

	/**
	 * This optional method will be run if it exists before tests begin.
	 * if the optional <setup> tag exists in the optional xml file, then
	 * the values listed in <setup> will be passed here.  This is useful
	 * for constructing objects, opening db connections, etc before testing.
	 */
	function load( [$vals] ) 
	{
	  // do some load stuff here
        }

	/**
	 * This optional method will be run, if it exists, after all tests are
	 * completed.  It will be run even if an Assert::assert() call returns 
	 * false (causing the class to abort())
	 */
	function unload()
	{
	  // do unload stuff here
	}
		

	/**
	 * This method is assumed to have an entry in the optional xml file.  Thus
	 * it will be passed a list of values (from xml data) each time it is run.
	 */
        function testCreate( $vals ) 
        {
            Assert::assert(isset($this->file), "File object could not be instantiated");
        }

        function testOpen() 
        {
            $this->file->open('test.dat');
            Assert::equalsTrue($this->file->isOpened(), "File couldn't be opened");
        }
        
        function testReadChar() 
        {
            $char = '0';
            $char = $this->file->readChar();
            Assert::equals('a', $char);
        }
		
        function testClose() 
        {
            $this->file->close();
            Assert::equalsFalse($this->file->isOpened(), "File couldn't be closed");
        }
    }</code></pre>
  <p>
    In short, the rules are as follows:
  </p>
  <ul>
    <li>There's no need to call the parent constructor; it doesn't even exist.</li>
    <li>An optional xml file may be used to provide params to the method.  The xml file will
       	have the same name as the class (ClassNameTest.xml) and reside in the same folder.
    <li>An optional <b>load()</b> method may exist in the class, this method will be run before
        any tests.  If the optional xml file contains a node called &lt;setup&gt; then those
	parameters will be passed here.
    <li>A method starting with <b>test</b> is considered to be one of the tests to run.
    <ul>
       <li>If optional xml file is provided, and a node is found with the 
         same name as the function (must be in lower case) the test will be run once
	 for each set of params.  See the example below for more.
       <li>If no xml file is provided, then the test is run once, without any arguments.
    </ul>
    <li>If an optional <b>unload()</b> method is provided, it will be ran after all tests
        are completed.  This method will run even if Assert::assert() returns false
	(cancelling all further tests).
    <li>There should be no method with the name <b>run</b>. This is the <i>only</i>
        method defined in class <b>Test</b>, and it isn't meant to be overridden.</li>
    <li>Test methods are called in the order they are defined in the class. This allows
        you - for example - to set up some variable in one test-method that can be 
        reused in a second.</li>
    <li><b>Assert:assert</b> expects a boolean and an optional message string. If the 
        boolean evaluates to <b>false</b>, the test for that particular unit is 
        stopped, and the application continues with the next unit (if it exists).</li>
    <li><b>Assert::equals</b> expects two values and an optional message. If the two
        values aren't equal an error is printed, but all other tests for the unit will
        still be executed.</li>
    <li><b>Assert::equalsTrue</b> expects a value and an optional message. Its behavior 
        is like <b>Assert::equals</b>, with one of the values set to <b>true</b>.</li>
    <li><b>Assert::equalsFalse</b> is like <b>Assert::equalsTrue</b>, with <b>false</b>
        instead of <b>true</b>. (What a surprise...)
  </ul>
  <p><b>Optional XML File format</b></p>
<pre><code>
&lt;TestUnit&gt;
  &lt;!--
    If the optional 'setup' node is provided, then the class is assumed to
    contain a method named "load" which will be passed all the params
    contained in the setup node.

    The load() method will run before any tests are performed.
   --&gt;
  &lt;setup&gt;
    &lt;param name='variable1'&gt;value1&lt;/param&gt;
    &lt;param name='variable2'&gt;value2&lt;/param&gt;
    &lt;param name='variable3'&gt;value3&lt;/param&gt;
  &lt;/setup&gt;

  &lt;!--
    The rest of the nodes (anything not called setup) is assumed to be
    the name of a corresponding method in the class.  Note that the node
    name must be in lower case, due to reflection properties of php.

    The node may contain any number of parameter sets.  The method will
    be called once for each set of parameters placed here.
  --&gt;
  &lt;testmethod_a&gt;

     &lt;!-- the test is run once for each param set, add as many as you need --&gt;
     &lt;param_set_1&gt;
	&lt;!-- everything here will be passed to the function in an array, add as many as needed --&gt;
        &lt;param name='variable1'&gt;value1&lt;/param&gt;
	&lt;param name='variable2'&gt;value2&lt;/param&gt;
     &lt;/param_set_1&gt;

     &lt;param_set_2&gt;
        &lt;!-- the special property eval='true' will cause the value of the node to be
	     evaluated as php code just as if it ran with &lt;?php eval( value ) ?&gt; --&gt;
        &lt;param name='variable1' eval='true'&gt;null&lt;/param&gt;
	&lt;param name='variable2' eval='true'&gt;false&lt;/param&gt;
	&lt;param name='variable3' eval='true'&gt;magic_quotes_gpc()&lt;/param&gt;
     &lt;/param_set_2&gt;

  &lt;/testmethod_a&gt;

  &lt;!-- add a node for every method that should be passed params --&gt;

&lt;/TestUnit&gt;
</code></pre>
  </p>
  <p>
    As mentioned earlier, it's all very simple. At the same time I find it very useful. 
    If you want the application to do more, you are free to modify this code for your
	own personal needs. 
  </p>
  <p>
    Final note: the code for this application is by no means representative for the
    code I normally write! I hacked this thing together in about half an hour, so there
    there you go. (Normally, I would <i>never</i> use global variables! I swear!)
  </p>
  <p>
     Vincent Oostindi&euml;, 
     <a href="mailto:vincent@sunlight.tmfweb.nl">vincent@sunlight.tmfweb.nl</a>,
     March 2002.
  </p>
<?php
} // !$dirValid
?>

<br><br><br>
<?
  if( class_exists("Zen") && $showdebug ) {
    print "<p>------ DEBUG ------</p>";
    $list = Zen::getMessageList();
    print $list->outputHTML(true);
  }
?>


  </body>
</html>
<?php
} // !defined('PHP_UNIT_INCLUDED')
?>