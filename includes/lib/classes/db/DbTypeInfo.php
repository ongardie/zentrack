<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * Provides db specific information for data types and calls for create/drop/alter statements
 *
 * The db specific information is provided in xml files located in classes/db
 *
 * @package DB
 *
 */
class DbTypeInfo {

  /**
   * CONSTRUCTOR - load correct db type info from xml
   *
   * @param ZenDatabase $dbo is the database connection
   */
  function DbTypeInfo( $dbo ) { 
    $this->_dir = dirname(__FILE__);
    $this->_dbo = $dbo;
    $this->_load();
  }

  /**
   * @param string $type the element type to check
   * @return string representing location of element type (inline,external) or null if element not found
   */
  function getElementLocation( $type ) { 
    return isset($this->_locations[$type])? $this->_locations[$type] : null;
  }

  /**
   * creates sql needed to drop a table
   *
   * @param string $table
   * @return array of sql statements
   */
  function dropTableSyntax( $table ) { 
    return $this->getStatement("droptable", array('table',$table));
  }

  /**
   * creates sql needed to add a table
   *
   * @param string $table
   * @param array $columns array of (string) column syntax
   * @return array of sql statements
   */
  function addTableSyntax( $table, $columns ) { 
    return $this->getStatement('addtable', array('table'=>$table, 'columns'=>join(",",$columns)));
  }

  /**
   * creates sql needed to drop a column
   *
   * @param string $table
   * @param string $column
   * @return array of sql statements
   */
  function dropColumnSyntax( $table, $column ) { 
    return $this->getStatement('dropcolumn', array('table'=>$table, 'name'=>$column));
  }

  /**
   * Creates sql to add column inside a create table definition
   *
   * @param string $name of column
   * @param string $type data type
   * @param string $unique (true or false)
   * @param integer $length (if applicable) of column
   * @param string $required (true or false)
   * @return array of sql statements
   */
  function inlineColumnSyntax( $name, $type, $unique, $required, $length ) {
    $props = $this->getSqlProps('tablecolumn');
    $uniquetext = ($unique && isset($props['uniquelabel']))? $props['uniquelabel'] : '';
    $attrtext = ($required && isset($props['notnull']))? $props['notnull'] : '';
    $vals = array(
                  'name'    => $name,
                  'type'    => $this->makeTypeDef($type,$length),
                  'unique'  => $uniquetext,
                  'attr'    => $attrtext );
    return $this->getStatement('tablecolumn',$vals);
  }
  
  /**
   * creates sql needed to add a column to an existing table
   *
   * @param string $table
   * @param string $name of column
   * @param string $type data type
   * @param string $unique (true or false)
   * @param integer $length (if applicable) of column
   * @param string $required (true or false)
   * @return array of sql statements
   */
  function addColumnSyntax( $table, $name, $type, $unique, $required, $length ) { 
    $def = $this->inlineColumnSyntax($name, $type, $unique, $required, $length);
    return $this->getStatement('addcolumn', array('table'=>$table, 'def'=>$def));
  }
  
  /**
   * Delete data from a table
   *
   * @param string $table name of table
   * @param string $where is where criteria (not including WHERE) for the sql statement
   * @return string complete sql statement for delete
   */
  function deleteDataSyntax( $table, $where = null ) {
    if( $where ) {
      $where = "WHERE ".$where;
    }
    return $this->getStatement("delete", array("table"=>$table, "where"=>$where));
  }
  
  /**
   * creates an index on a table for various columns
   *
   * @param string $name name of the index
   * @param string $table
   * @param array $columns
   * @param boolean $unique
   * @return array of sql statements
   */
  function addIndexSyntax( $name, $table, $columns, $unique = false ) { 
    $props = $this->getSqlProps("index");    
    $unique_text = ($props['uniquelabel'] && $unique )? $props['uniquelabel'] : '';
    $vals = array('name'    => $name,
                  'table'   => $table,
                  'columns' => join(',',$columns),
                  'unique'  => $unique_text);
    return $this->getStatement('index',$vals);
  }
  
  /**
   * drops an index on a table
   *
   * @param string $table
   * @param string $name name of the index
   * @return string parsed for use or false if no drop index is required for this type(dropped with table)
   */
  function dropIndexSyntax( $table, $name ) { 
    $text = $this->getStatement("dropindex", array('table'=>$table, 'name'=>$name));
    return $text? $text : false;
  }
  
  /**
   * Returns the unparsed syntax statement for the given type
   *
   * @param string $type the statement type to retrieve
   * @return string containing unparsed statement or null if bad type
   */
  function getSyntax( $type ) {
    return isset($this->_sqlCriteria[$type])? $this->_sqlCriteria[$type]['syntax'] : null;
  }
  
  /**
   * Return statement with variables parsed
   *
   * @param string $type is the type of sqlInfo node to use
   * @param array $vals is an associative array of (string)param=>(string)val to parse into statement
   * @return string parsed syntax or null if not found
   */
  function getStatement( $type, $vals ) {
    $text = $this->getSyntax($type);
    if( !$text ) { return $text; }
    foreach($vals as $k=>$v) {
      $text = str_replace("%{$k}%", $v, $text);
    }
    return $text;
  }
  
  /**
   * Return properties for a sqlInfo node
   *
   * @param string $type is the type of sqlInfo node to check
   * @return array associative (string)name => (string)value or empty array if no properties exist
   */
  function getSqlProps( $type ) {
    return isset($this->_sqlCriteria[$type])? $this->_sqlCriteria[$type]['props'] : array();
  }

  /**
   * Create a data type definition for this database
   *
   * @param string $type is the data type to create
   * @param integer $length is the length of the field(only applicable for certain data types)
   * @return string ready for use in sql, false if type is bad or length was required and ommitted
   */
  function makeTypeDef( $type, $length = 0 ) {
    if( !isset($this->_dataTypes[$type]) ) {
      Zen::debug($this, "makeTypeDef", "Data type $type is invalid", 102, 2);
      return false;
    }

    // get the properties
    $props = $this->_dataTypes[$type]['props'];

    // if this element doesn't use a size, then just return the type
    if( !$props['size'] && !$props['max'] ) {
      return $props['type'];
    }

    if( $props['fixed'] == 'false' ) {
      // check the size attribute
      if( !$props['size'] && !$length ) {
        Zen::debug($this, "makeTypeDef", "Data type $type requires a length", 101, 2);
        return false;
      }
      if( $length > $props['max'] ) {
        Zen::debug($this, "makeTypeDef", "Maximum length exceeded for data type $type ($length)"
                   ."using max instead({$props['max']})", 123, 2);
      }
      // format and return the element
      $num = ($length)? $length : $props['size'];
    }
    else {
      $num = $props['max'];
    }
    return "{$props['type']}($num)";
  }

  /**
   * Returns a dbInfo property's value
   *
   * @param string $name name of dbInfo attribute to return
   * @return string value of requested property or null if doesn't exist
   */
  function getDbInfo( $name ) {
    return isset($this->_dbInfo[$name])? $this->_dbInfo[$name]['data'] : null;
  }

  /**
   * Parses xml data and loads properties for use
   *
   * @return boolean true if loaded successfully
   */
  function _load() {
    $success = true;

    // locate config file
    $file = $this->_dir."/".$this->_dbo->getDbType().".xml";
    if( !file_exists($file) ) {
      Zen::debug($this, "_load", "Config file $file not found", 21, 1);
      return false;
    }

    // parse xml data
    $data = join("",file($this->_dir."/".$this->_dbo->getDbType().".xml"));
    $xp = new ZenXMLParser();
    $root =& $xp->parse($data);

    // obtain the dbinfo params
    $dbinfo = $root->getChild("dbInfo",0);
    foreach($dbinfo->getChildren() as $k=>$v) {
      $this->_dbInfo[$k] = array('data'=>$v[0]->getData(), 'props'=>$v[0]->getProps());
    }
    // validate dbinfo
    foreach($this->required_dbInfoNodes as $key) {
      if( !isset($this->_dbInfo[$key]) ) {
        Zen::Debug($this, "_load", "dbInfo required node $key missing", 101, 2);
        $success = false;
      }
    }

    // obtain the data types
    $types = $root->getChild("dataTypes",0);
    foreach($types->getChild("dataType") as $v) {
      // set data type info
      $n = $v->getName();
      $d = $v->getData();
      // validate name
      if( isset($this->_dataTypes[$n]) || !$n ) {        
        $msg = $n? "Duplicate node $n detected" : "Name invalid/missing for dataType node";
        Zen::Debug($this, "_load", $msg, 103, 2);        
        $success = false;
      }
      $this->_dataTypes[$n] = $v->getProps();
      // validate data type properties
      foreach($this->required_dataTypeProps as $key) {
        if( !isset($this->_dataTypes[$n][$key]) ) {
          Zen::Debug($this, "_load", "Node $n missing required property $key", 101, 2);
          $success = false;
        }
      }
    }
    // validate data types all present
    foreach($this->required_dataTypeNodes as $key) {
      if( !isset($this->_dataTypes[$key]) ) {
        Zen::Debug($this, "_load", "dataTypes required node $key missing", 101, 2);
        $success = false;
      }
    }

    // get sqlInfo nodes
    $sql = $root->getChild("sqlInfo",0);

    foreach($sql->getChildren() as $childArray) {
      $child = $childArray[0];
      $n = $child->getName();
      $d = $child->getData();
      $p = $child->getProps();
      if( in_array($n,$this->_locations) && isset($p['location']) ) {        
        $this->_locations[$n] = $p['location'];
      }
      $this->_sqlCriteria[$n] = array('syntax'=>$d, 'props'=>$p);
    }
    // validate sqlInfo nodes
    foreach($this->required_sqlInfoNodes as $key) {
      if( !isset($this->_sqlCriteria[$n]) ) {
        Zen::Debug($this, "_load", "sqlInfo node $key missing", 101, 2);
        $success = false;
      }
    }
    
    return $success;
  }


  /*************************************
   **   SETTINGS
   ************************************/

  /** @var ZenDatabase the database connection to use */
  var $_dbo;

  /** @var array associative array of (String)name=>(Array)('data','props') for dbInfo */
  var $_dbInfo;

  /** @var array associative array of (String)name=>(Array)('syntax','props') for creating sql statements */
  var $_sqlCriteria;

  /** @var array associative array of (String)data_type=>(array)props:  specifies the properties for each data type */
  var $_dataTypes;

  /** @var string location of xml source files */
  var $_dir;

  /** @var boolean flag marks whether indexes appear external or inline with tables */
  var $_locations = array('primarykey'=>'inline', 'index'=>'inline');

  /** @var array the required dataTypeNodes */
  var $required_dataTypeNodes = array("value",     "string", 
                                      "maxstring", "text", 
                                      "byte",      "shortint", 
                                      "integer",   "decimal", 
                                      "long",      "primarykey",
                                      "email",     "date");

  /** @var array the required data types properties */
  var $required_dataTypeProps = array("type","size","max","fixed");
  
  /** @var array the required dbInfo nodes */
  var $required_dbInfoNodes = array("preferredCase");

  /** @var array the required sqlInfo nodes */
  var $required_sqlInfoNodes = array("endline",    "escapechar",
                                     "create",     "droptable",
                                     "primarykey", "index",
                                     "dropindex",  "addcolumn",
                                     "dropcolumn", "delete",
                                     "insert",     "update");
    


}

?>
