<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * Provides db specific information for data types and calls for create/drop/alter statements
 *
 * The db specific information is provided in xml files located in classes/db
 *
 * @package DB
 *
 */
class ZenDbTypeInfo {

  /**
   * CONSTRUCTOR - load correct db type info from xml
   *
   * @param ZenDatabase $dbo is the database connection
   */
  function ZenDbTypeInfo( &$dbo ) { 
    $this->_dir = dirname(__FILE__);
    $this->_dbo =& $dbo;
    $t = $this->_dbo->getDbType();
    $this->_type = ZenDbTypeInfo::mapFromAdoType($t);
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
    return $this->getStatement("droptable", array('table'=>$table));
  }

  /**
   * creates sql needed to add a table
   *
   * @param string $table
   * @param array $columns array of (string) column syntax
   * @param boolean $transactions if true, this table will accept transactions
   * @return array containing (String)sql_statements, the first is guaranteed to be the table create, others are supporting keys, etc.
   */
  function addTableSyntax( $table, $columns, $transactions ) {
    $columnText = "";
    $pkinfo = $this->getSqlProps('primarykey');
    $pkinline = ($pkinfo['location'] == 'inline');
    $stmts = array( null ); //set first element, since our table command will go here
    $keys = "";
    // create column info
    foreach($columns as $c) {
      $pk = ($c['type'] == 'primarykey');
      $keyname = $this->genKeyName($table, $c['name'], $c['type']);
      $new = array();
      if( $columnText ) { $columnText .= ", "; }
      $columnText .= $this->inlineColumnSyntax($c['name'], $c['type'], 
                                               $c['unique'], $c['notnull'], 
                                               $c['size'], $keyname,
                                               $c['default'], ($pk && $pkinline) );
      if( $pk && !$pkinline ) {
        $txt = $this->getStatement('primarykey', array('keyname'=>$keyname, 'column'=>$c['name'], 'table'=>$table));
        if( $pkinfo['location'] == 'internal' ) {
          $keys .= ", ".$txt;
        }
        else {
          $stmts[] = $txt;
        }
      }
    }
    $columnText .= $keys;
    $stmts[0] = $this->getStatement('create', 
                               array('table'=>$table, 'columns'=>$columnText), 
                               $transactions);
    return $stmts;
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
   * @param string $required (true or false)
   * @param integer $length (if applicable) of column
   * @param string $keyname provide to create a primary key field (some databases need to name the constraint)
   * @param string $default the default value for column (will be quoted)
   * @return array of sql statements
   */
  function inlineColumnSyntax( $name, $type, $unique, $required, $length, $keyname, $default = null ) {
    $props = $this->getSqlProps('tablecolumn');
    $uniquetext = ($unique && isset($props['uniquelabel']))? $props['uniquelabel'] : '';
    $attrtext = "";
    if( strlen($default) ) {
      if( $default == 'NOW' ) {
        $default = $this->getSyntax('now');
      }
      if( strlen($default) ) {
        $deftxt = str_replace("%keyname%", $keyname, $props['default'])." ";
        $attrtext .= str_replace("%default%", $this->_dbo->quote($default,$type), $deftxt);
      }
    }
    if( $type == 'primarykey' ) {
      $pk = $this->getSqlProps('primarykey');
      if( $pk['location'] == 'inline' ) {
        $attrtext .= $this->getStatement('primarykey',array($keyname));
      }
    }
    else if( $required && isset($props['notnull']) ) {
      $attrtext .= str_replace("%keyname%", $keyname, $props['notnull']);
    }
    else if( strpos($this->_type, 'mssql')===0 && !strlen($default) ) {
      // for mssql, default is not null, so we must explicity state for
      // consistency with our design
      $attrtext .= ' NULL ';
    }
    $vals = array(
                  'name'     => $name,
                  'datatype' => $this->makeTypeDef($type,$length),
                  'attr'     => $attrtext );
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
   * @param string $default the default value for column (will be quoted)
   * @return array of sql statements
   */
  function addColumnSyntax( $table, $name, $type, $unique, $required, $length, $default = null ) {
    $def = $this->inlineColumnSyntax($name, $type, $unique, $required, $length, 
                                     $this->getKeyName($table,$name,$type), $default);
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
   * @param string $transaction_enabled tells whether this table will use transactions
   * @return string parsed syntax or null if not found
   */
  function getStatement( $type, $vals, $transaction_enabled = false ) {
    $text = $this->getSyntax($type);
    if( !$text ) { 
      ZenUtils::safeDebug($this,'getStatement',"Type $type is not defined", 221, LVL_ERROR);
      return 'ERROR'; 
    }
    foreach($vals as $k=>$v) {
      $text = str_replace("%$k%", $v, $text);
    }
    if( $type == "addtable" && $transaction_enabled == true 
        && $this->getSyntax('transaction_table') ) { $text .= " ".$this->getSyntax('transaction_table'); }
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
      ZenUtils::safeDebug($this, "makeTypeDef", "Data type $type is invalid", 102, LVL_WARN);
      return 'NOTYPE';
    }

    // get the properties
    $props = $this->_dataTypes[$type];

    // if this element doesn't use a size, then just return the type
    if( !$props['size'] && !$props['max'] ) {
      return $props['type'];
    }

    if( $props['fixed'] == 'false' ) {
      // check the size attribute
      if( !$props['size'] && !$length ) {
        ZenUtils::safeDebug($this, "makeTypeDef", "Data type $type requires a length", 101, LVL_WARN);
        return 'NOSIZE';
      }
      if( $length > $props['max'] ) {
        ZenUtils::safeDebug($this, "makeTypeDef", "Maximum length exceeded for data type $type ($length)"
                   ."using max instead({$props['max']})", 123, LVL_WARN);
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
    $file = $this->_dir."/db/".$this->_type.".xml";
    if( !file_exists($file) ) {
      ZenUtils::safeDebug($this, "_load", "Config file $file not found", 21, LVL_ERROR);
      return false;
    }

    // parse xml data
    $data = join("",file($file));
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
        Zen::Debug($this, "_load", "dbInfo required node $key missing", 101, LVL_ERROR);
        $success = false;
      }
    }

    // obtain the data types
    $types = $root->getChild("dataTypes",0);
    foreach($types->getChild("dataType") as $v) {
      // set data type info
      $n = $v->getProperty('name');
      $d = $v->getData();
      // validate name
      if( isset($this->_dataTypes[$n]) || !$n ) {        
        $msg = $n? "Duplicate node $n detected" : "Name invalid/missing for dataType node";
        Zen::Debug($this, "_load", $msg, 103, LVL_WARN);
        $success = false;
      }
      $this->_dataTypes[$n] = $v->getProps();
      // validate data type properties
      foreach($this->required_dataTypeProps as $key) {
        if( !isset($this->_dataTypes[$n][$key]) ) {
          Zen::Debug($this, "_load", "Node $n missing required property $key", 101, LVL_ERROR);
          $success = false;
        }
      }
    }
    // validate data types all present
    foreach($this->required_dataTypeNodes as $key) {
      if( !isset($this->_dataTypes[$key]) ) {
        Zen::Debug($this, "_load", "dataTypes required node $key missing", 101, LVL_ERROR);
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
        Zen::Debug($this, "_load", "sqlInfo node $key missing", 101, LVL_ERROR);
        $success = false;
      }
    }
    return $success;
  }

  /**
   * STATIC: Generate a key name from table/column/type values
   *
   * @static
   * @param string $table name of table
   * @param string $column name of column
   * @param string $type type of column
   */
  function genKeyName($table, $column, $type) {
    return ($type=='primarykey'? "pk_" : "idx_").substr($table,0,3)."_".substr($column,0,3);
  }

  /**
   * STATIC: maps adodb types to human readable names
   *
   * @static
   * @param string $type any adodb type or zen dbtype
   * @return string a human readable string or 'Unknown' if not found
   */
  function getNameFromType( $type ) {
    $typesToNames = array(
                          "oracle"   => "Oracle 8i/9i",
                          "mssql"    => "Microsoft SQL Server",
                          "postgres" => "PostgreSQL",
                          "mysql"    => "MySql"
                          );
    $t = ZenDbTypeInfo::mapFromAdoType( $type );
    return isset($typesToNames[$t])? $typesToNames[$t] : "Unknown";
  }

  /**
   * STATIC: Returns the zen alias used for this database type based
   * on the adodb alias from the zen.ini file.
   *
   * @static
   * @param string $adodbType
   * @return string
   */
  function mapFromAdoType( $adodbType ) {
    $type_aliases = array(
                          "oci8"      => "oracle",
                          "oci8po"    => "oracle",
                          "mssqlpo"   => "mssql",
                          "postgres7" => "postgres",
                          "mysqlt"    => "mysql");
    return isset($type_aliases[$adodbType])? $type_aliases[$adodbType] : $adodbType;
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
    
  /** @var string the type of db we are using (aliased) */
  var $_type;

}

?>
