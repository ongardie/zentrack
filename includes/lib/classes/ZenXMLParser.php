<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

 /**
  * Takes a string of xml data and parses it, creating ZenXNode objects 
  *
  * @package Utils
  * @see ZenXNode
  */
 class ZenXMLParser {

  /** 
   * @var object $_parser holds the xml parser object 
   */
  var $_parser;

  /** 
   * @var object $_current holds the current ZenXNode object
   */ 
  var $_current;

  /**
   * creates the xparser object
   */
  function ZenXMLParser() {
  }

  /**
   * parses the xml string
   *
   * @param string $xmlstring the xml text to be parsed or a file reference
   * @return ZenXNode xnode object containing root xml node
   */
  function &parse($xmlstring="") {
    if( strpos($xmlstring,"\n") === false && @file_exists($xmlstring) ) {
      $xmlstring = join("",file($xmlstring));
    }
    // set up a new XML parser to do all the work for us
    $this->_parser = xml_parser_create();
    xml_set_object($this->_parser, $this);
    xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, false);
    xml_set_element_handler($this->_parser, "startElement", "endElement");
    xml_set_character_data_handler($this->_parser, "characterData");
    
    // parse the data and free the parser...
    xml_parse($this->_parser, $xmlstring);
    xml_parser_free($this->_parser);	
    
    return $this->_current;
  }

  /**
   * used by the xml parser object to indicate a new node is being opened
   */
  function startElement($parser, $name, $attrs) {
    $node =& new ZenXNode( $this->_current, $name, $attrs );
    $this->_current =& $node;
  }
  
  /**
   * used by the xml parser object to indicate a node is closing
   */
  function endElement($parser, $name) {
    $this->_current->final();
    if( $this->_current->getParent() != null ) {
      $this->_current =& $this->_current->getParent();      
    }      
  }

  /**
   * used by the xml parser to attach data to a node
   */
  function characterData($parser, $data) {
    $this->_current->data( $data );
  }

  /** 
   * STATIC: Process a set of parm tags from an array of xml param nodes
   *
   * The parm tags must have a name="" attribute, which
   * will be used to create the index for the return values
   *
   * and may optionally include an eval='true' attribute, which
   * will cause the node data to be run with $param = eval(..data..)
   * (thus it must include valid php code)
   *
   * @var array $node is an array of nodes recieved from {@link ZenXNode->getChild('param')}
   */
  function getParmSet( $node ) {
    $parms = array();
    if( is_array($node) ) {
      foreach($node as $parm) {
        $key = $parm->getProperty('name');
        if( $parm->getProperty('eval') == 'true' ) {
          $val = $parm->getData();
          eval("\$parms[\$key] = $val;");
        }
        else {
          // add element to existing array
          if( isset($parms[$key]) && is_array($parms[$key]) ) {
            $parms[$key][] = $parm->getData();
          }
          // create an array from element
          else if( isset($parms[$key]) ) {
            $parms[$key] = array($parms[$key], $parm->getData());
          }
          // just add element
          else {
            $parms[$key] = $parm->getData();
          }
        }
      }
    }
    return $parms;
  }

}


/**
 * contains a single xml node of data
 *
 * @package Utils
 */
class ZenXNode {
  /**
   * initiate a node object
   *
   * @param reference $parent a reference to the parent ZenXNode object (null if root)
   * @param string $name the name of this node
   * @param array $attributes a list of the attributes from the name tag
   */
  function ZenXNode( &$parent, $name, $attributes ) {
    $this->_name = $name;
    $this->_props = is_array($attributes)? $attributes : array();
    $this->_data = "";
    $this->_children = array();
    $this->_parent =& $parent;
  }
  
  /**
   * add data to this node object
   *
   * @param string $data to be added to this node
   */
  function data( $data ) {
    $this->_data .= $data;
  }

  /**
   * assigns another node object as a child of this one
   *
   * @param reference $child reference to the child object
   */
  function child( &$child ) {
    $n = $child->getName();
    $this->_children["$n"][] =& $child;
  }

  /**
   * indicates that we are done adding data to this node, performs cleanup
   */
  function final() {
    $this->_data = trim($this->_data);
    if( $this->_parent )
      $this->_parent->child($this);
  }

  /**
   * prints out the node and all child nodes to the screen
   * this is intended for debugging
   */
  function show() {
    $pad = "style='margin-left:20px'";
    print "<li><span style='color:#009900'><b>".strtoupper($this->_name)."</b></span></li>\n";
    print "<ul $pad>\n";
    if( count($this->_props) ) {
      print "<li>Properties</li><ul $pad>\n";
      foreach($this->_props as $k=>$v) {
        print "<li>$k: $v</li>\n";
      }
      print "</ul>\n";
    }
    if( $this->getData() ) {
      print "<li>Data: ".htmlentities($this->getData())."</li>\n";
    }
    if( count($this->getChildren()) ) {
      print "<li>Children</li><ul $pad>\n";
      foreach($this->getChildren() as $set) {
        if( is_array($set) ) {
          foreach($set as $val) {
            $val->show();
          }
        }
      }
      print "</ul>\n";
    }
    print "</ul>\n";
  }

  /**
   * creates xml output from the indexed array provided
   *
   * @return string containing the xml data
   */
  function toXML( $indent = 0 ) { 
    // format the text
    $tabs = str_repeat('   ',$indent);
    // get this nodes attributes
    $name = $this->getName();
    $children = $this->getChildren();
    $props = $this->getProps();    
    $data = $this->getData();
    // print the tag
    $text = "$tabs<$name";
    // print properties
    foreach($props as $key=>$val) {
      $text .= " $key=\"$val\"";
    }
    if( !count($children) && !strlen($data) ) {
      $text .= "/>\n";
    }
    else {
      // show the node data and children
      $text .= ">";
      if( strlen($data) ) {
	$text .= $data;
      }
      if( count($children) ) {
        $text .= "\n";
        foreach($this->getChildren() as $c) {
          foreach($c as $child) {
            $text .= $child->toXML( $indent+1 );
          }
        }
        $text .= $tabs;
      }
      // close the node tag
      $text .= "</$name>\n";
    }
    return $text;
  }

  /**
   * converts the node and its children to an associative array
   *
   * <b>About compress parameter:</b>
   *
   * The compress parameter controls how deeply the arrays are structured for the children nodes and 
   * is greatly useful in envirnments where most of the nodes will be unique (where it is not intuitive
   * to have to iterate through a bunch of lists which only contain one entry).  
   *
   * If this parameter is false, then all child nodes contain an array of nodes.  If true, then only child
   * nodes which have more than one match will be in an array.  Example return value follows(note
   * differences in the 'orange' node and how it is converted to an array):
   *
   * <code>
   *   //XML DATA:
   *   <fruit type='colored'>
   *      <orange>orange of course</orange>
   *      <apple>red</apple>
   *      <apple>green</apple>
   *   </fruit>
   *   
   *   //$fruitNode->toArray(true) returns:
   *   Array
   *   (
   *       [name] => fruit
   *       [properties] => Array
   *       (
   *               [type] => colored
   *       )
   *       [data] => 
   *       [children] => Array
   *       (
   *               [orange] => Array
   *               (
   *                       [name] => orange
   *                       [properties] => Array()
   *                       [data] => orange of course
   *                       [children] => Array()
   *               )
   *               [apple] => Array
   *               (
   *                       [0] => Array
   *                       (
   *                               [name] => apple
   *                               [properties] => Array()
   *                               [data] => red
   *                               [children] => Array()
   *                       )
   *   
   *                       [1] => Array
   *                       (
   *                               [name] => apple
   *                               [properties] => Array()
   *                               [data] => green
   *                               [children] => Array()
   *                       )
   *               )
   *       )
   *   )
   *
   *   //$fruitNode->toArray(false) returns:
   *   Array
   *   (
   *       [name] => fruit
   *       [properties] => Array
   *           (
   *               [type] => colored
   *           )
   *       [data] => 
   *       [children] => Array
   *           (
   *               [orange] => Array
   *                   (
   *                       [0] => Array
   *                           (
   *                               [name] => orange
   *                               [properties] => Array()
   *                               [data] => orange of course
   *                               [children] => Array()
   *                           )
   *                   )
   *               [apple] => Array
   *                   (
   *                       [0] => Array
   *                           (
   *                               [name] => apple
   *                               [properties] => Array()
   *                               [data] => red
   *                               [children] => Array()
   *                           )
   *                       [1] => Array
   *                           (
   *                               [name] => apple
   *                               [properties] => Array()
   *                               [data] => green
   *                               [children] => Array()
   *                           )
   *                   )
   *           )
   *   )
   *   
   *
   * </code>
   *
   * @param boolean $compress see description for details
   * @return array containing node and all children
   */
  function toArray( $compress = false ) {
    $vals = array("name"=>$this->getName(),"properties"=>$this->getProps(),"data"=>$this->getData());
    $vals["children"] = array();
    foreach($this->getChildren() as $k=>$v) {
      if( is_array($v) ) {
	foreach($v as $val) {
          if( $compress && !isset($vals["children"]["$k"]) ) {
            $vals["children"]["$k"] = $val->toArray( $compress );
          }
          else if( $compress && !isset($vals["children"]["$k"][0]) ) {
            $vals["children"]["$k"] = array( $vals["children"]["$k"], $val->toArray( $compress ) );
          }
          else {
            $vals["children"]["$k"][] = $val->toArray( $compress ); 
          }
	}
      }
    }
    return $vals;
  }

  /**
   * Creates a ZenXNode object from an array (this is a recursive call, sub-elements are created as children)
   *
   * This is how to create xml or schema data from an array.  The input array should be structured as follows:
   *
   * <pre>
   *   nodeArray
   *       props => [optional]array(..prop elements, indexed..)
   *       name  => "name"
   *       data  => [optional]"data"
   *       children => [optional]array( "key" = array(child arrays, same structure), "key"... )
   * </pre>
   *
   * Note that the children array is in the format: 
   * <code>children = array( "Key1" = array( nodeArrayA, nodeArrayB, nodeArrayC ), "Key2"... ), 
   * where the nodeArrays are structured exactly like this enclosing nodeArray
   *
   * @param array $vals represents the data structure to move to xml, see comments for more
   * @return ZenXNode returns the root node
   */
  function createNodeFromArray( &$parent, $vals ) {
    // create a new node, store parent reference
    $node = new ZenXNode( &$parent, $vals['name'], $vals['props'] );
    // add data if applicable
    if( isset($vals['data']) ) {
      $node->data( $vals['data'] );
    }
    // create child objects if applicable
    if( isset($vals['children']) && is_array($vals['children']) ) {
      foreach($vals['children'] as $k=>$nodes) {
        for($i=0; $i<count($nodes); $i++) {
          // create child and store reference in this node
          $node->child( $this->createNodeFromArray(&$node, $nodes[$i]) );
        }
      }
    }
    // return a reference to this object
    return $node;
  }

  /**
   * STATIC: Parses and xml file and returns the root ZenXNode 
   *
   * @param string $xmlFile the path/filename to load
   * @return ZenXNode results or null if unable to load/parse
   */
  function createNodeFromFile( $xmlFile ) {
    if( !@file_exists($xmlFile) ) {
      Zen::debug('ZenXMLParser', 'createNodeFromFile', 'Unable to load $xmlFile', 21, LVL_ERROR);
      return null;
    }
    $xml = join("",file($xmlFile));
    $parser = new ZenXMLParser();
    return $parser->parse($xml);
  } 

  /** 
   * @return string name of the node 
   */
  function getName() { return $this->_name; }

  /** 
   * @return ZenXNode parent object of this node or null (if this is root)
   */
  function getParent() { return $this->_parent; }

  /** 
   * @return String any data contained in this node: <code><node>...data...</node></code>
   */
  function getData() { return $this->_data; }

  /** 
   * @return array properties from this node: <code><node property="prop..."></code>
   */
  function getProps() { return $this->_props; }

  /** 
   * Returns the children of each node... note that the value of each array element is also an array, since
   * there may be more than one child node with the same name
   *
   * @return array associative array of (string)name => array(ZenXNode) objects representing children of this node
   */
  function getChildren() { return $this->_children; }

  /** 
   * Returns a child object by name
   *
   * @param string $child the name of the child object to retrieve
   * @param integer $index [optional] if provided, returns only the specific ZenXNode, otherwise array of matches
   * @return mixed a single child ZenXNode, if the index is provided, or the array of children mathing this name
   */
  function getChild( $child, $index = null ) { 
    if( isset($this->_children["$child"]) ) {
      return strlen($index)? $this->_children[$child][$index] : $this->_children[$child]; 
    }
    else { return null; }
  }

  /** 
   *
   * @param string $prop is name of property to retrieve
   * @return String value of a node property or null if not set
   */
  function getProperty( $prop ) {
    if( isset($this->_props["$prop"]) )
      return $this->_props["$prop"];
    else 
      return null;
  }

  /** @var string $_name the name of this node */
  var $_name;

  /** @var ZXNode $_parent a reference to the parent of this node */
  var $_parent;

  /** @var string $_data any data from this node tag */
  var $_data;

  /** @var array $_props associative array of (String)name => (String)value for the properties for the node tag */
  var $_props;

  /** @var array $_children associative array of (String)name => ZenXNode references to child nodes of this one */
  var $_children;

}

?>
