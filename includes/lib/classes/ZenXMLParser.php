<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

 /**
  * takes a string of xml data and parses it, creating ZenXNode objects 
  *
  * @see ZenXNode
  * @package Utils
  */
 class ZenXMLParser {

  /** @var object $_parser holds the xml parser object */
  var $_parser;

  /** @var object $_current holds the current ZenXNode object */ 
  var $_current;

  /**
   * creates the xparser object
   */
  function ZenXMLParser() {
  }

  /**
   * parses the xml string
   *
   * @param string $xmlstring the xml text to be parsed
   * @return ZenXNode xnode object containing root xml node
   */
  function parse($xmlstring="") {
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
}


/**
 * contains a single xml node of data
 *
 * @package zen
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
   * @return array containing node and all children
   */
  function toArray() {
    $vals = array("name"=>$this->getName(),"properties"=>$this->getProps(),"data"=>$this->getData());
    $vals["children"] = array();
    foreach($this->getChildren() as $k=>$v) {
      if( is_array($v) ) {
	foreach($v as $val) {
	  $vals["children"]["$k"][] = $val->toArray(); 
	}
      }
    }
    return $vals;
  }

  /** returns the name of this node */
  function getName() { return $this->_name; }

  /** returns a reference to the parent node of this node */
  function getParent() { return $this->_parent; }

  /** returns any data contained in this node: <node>...data...</node> */
  function getData() { return $this->_data; }

  /** returns properties from this node: <node property="prop..."> */
  function getProps() { return $this->_props; }

  /** returns child nodes from this node */
  function getChildren() { return $this->_children; }

  /** returns a single child node by name */
  function getChild( $child ) { 
    if( isset($this->_children["$child"]) )
      return $this->_children["$child"]; 
  }

  /** returns a single property by name */
  function getProperty( $prop ) {
    if( isset($this->_props["$prop"]) )
      return $this->_props["$prop"];
  }

  /** @var string $_name the name of this node */
  var $_name;

  /** @var ZXNode $_parent a reference to the parent of this node */
  var $_parent;

  /** @var string $_data any data from this node tag */
  var $_data;

  /** @var array $_props the properties for the node tag */
  var $_props;

  /** @var array $_children references to child nodes of this one */
  var $_children;

}

?>
