<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * Converts databases schemas to xml, and xml to db schemas
 *
 * @package DB
 */
class ZenDBXML {

  /**
   * CONSTRUCTOR - prepare proper db specific functions
   *
   * @param string $dbobject is a ZenDatabase instance
   */
  function ZenDBXML( &$dbobject ) { 
    $this->_dbobj =& $dbobject;
    $this->_dbtype = $this->_db->getDbType();
    $this->_dbTypeInfo = new DbTypeInf( &$dbobject );
  }

  /* HIGH LEVEL METHODS */

  /**
   * Dumps database data to xml for storage, optionally gzip or zip data
   *
   * @param string $ouptut is directory to output xml data to
   * @param string $table [optional] dumps only one table
   * @param string $compress compression type (null, gzip or zip)
   * @return boolean true/false if succeeded
   */
  function dumpDatabaseData( $output, $table, $compress ) { }

  /**
   * Dumps database schema to xml for storage, optionally gzip or zip data
   *
   * @param string $ouptut is the file to write to
   * @param string $table [optional] dumps only one table
   * @param string $compress compression type (null, gzip or zip)
   * @return boolean true/false if succeeded
   */
  function dumpDatabaseSchema( $output, $table, $compress ) { }

  /**
   * Loads a schema from xml to the database
   *
   * @param string $xml is the xml file to load
   * @param boolean $drop will cause the load to drop each table before creation
   */
  function loadSchemaToDB( $xml, $drop = false ) { }
  

  /**
   * Loads data from xml to the database
   *
   * @param string $dir is the directory or filename where xml data will be loaded from
   * @param boolean $drop will cause the load to drop data from each table before loading
   */
  function loadDataToDB( $xml, $drop = false ) { }



  /* USEFUL METHODS */

  /**
   * Run sql statement
   *
   * @param string $sql is the sql to run
   * @return integer result of query(1 or 0 for insert, number for update/delete/etc)
   */
  function runSqlCommand( $sql ) { }


  /**
   * creates xml data from the provided database
   *
   * this is accomplished by creating a root ZenXNode object, then
   * populating it with the database information... upon completion
   * ZenXNode::toXML() will create the output xml text
   *
   * @param ZenDatabase $conn the db connection
   * @return string xml data ready for writing or parsing
   */
  function convertSchemaToXML( $conn ) { 

    //todo
    //todo obtain database schema
    //todo convert to an array
    //todo
    //todo run ZenXMLParser::createNodeFromArray()
    //todo
    //todo convert nodes to xml data

  }

  /**
   * creates a db schema from an xml file
   *
   * @param ZenXNode $xml is the parsed xml data
   * @return array of sql statements to create the db
   */
  function createSchemaFromXML( $xml ) { 
    
    //todo
    //todo read/parse xml
    //todo
    //todo use db/DbTypeInfo to create sql statements from xml
    //todo create a specification for this xml file
    //todo
    //todo escape data strings appropriately
    //todo use appropriate statement terminator
    //todo  
    //todo return xql information

  }

  /**
   * compares xml file to the current db and creates sql needed to alter db to match xml file
   *
   * @param ZenXNode $xml is the parsed xml data
   * @return array of sql statements to update db
   */
  function updateSchemaFromXML( $xml ) { 

    //todo
    //todo run convert schema to xml
    //todo
    //todo parse/read/compare the two xml files
    //todo create new xml node set with differences
    //todo 
    //todo run createSqlFromXML
    //todo
    //todo return sql code

  }

  /**
   * Dump database data into an xml format
   *
   * @param ZenDatabase $conn the db connection to load data to
   * @param mixed $criteria optional, can be a string(representing a table name to dump) or ZenQuery object(results dumped)
   * @return string of xml data ready for writing/parsing
   */
  function dumpDataToXML( $conn, $criteria = null ) {

    //todo    
    //todo determine dump criteria(a table, a query, or all)
    //todo
    //todo collect table information about dump data
    //todo
    //todo create array from data and convert to xml with
    //todo ZenXmlParser::createNodeFromArray()
    //todo
    //todo Convert node to xml
    //todo return results

  }

  /**
   * Create sql statements to update database from xml data file
   *
   * @param ZenXNode $xml is the parsed xml data
   * @return array of sql statements to execute
   */
  function loadXmlDataToSql( $xml ) {
    
    //todo
    //todo parse xml data
    //todo 
    //todo collect table information about xml data
    //todo 
    //todo create sql statements
    //todo
    //todo return sql array
  }
  


  /* VARIABLES */

  /** @var ZenDatabase $_dbobj a db connection to use (also provides db type, specs, etc) */
  var $_dbobj;

  /** @var DbTypeInfo $_dbc a DbTypeInfo* object specific to the database type */
  var $_dbc;

  /** @var string $_dbtype is the database type in use */
  var $_dbtype;

}

?>
