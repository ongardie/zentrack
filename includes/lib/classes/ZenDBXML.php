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
  }


  /* USEFUL METHODS */

  /**
   * creates xml data from the provided database
   *
   * this is accomplished by creating a root ZenXNode object, then
   * populating it with the database information... upon completion
   * ZenXNode::toXML() will create the output xml text
   *
   * @return string xml data ready for writing or parsing
   */
  function convertSchemaToXML() { }

  /**
   * creates a db schema from an xml file
   *
   * @param string $filename containing xml data
   * @return array of sql statements to create the db
   */
  function createSqlFromXML() { }

  /**
   * compares xml file to the current db and creates sql needed to alter db to match xml file
   *
   * @param string $filename the xml data
   * @return array of sql statements to update db
   */
  function updateSqlFromXML() { }


  /* VARIABLES */

  /** @var ZenDatabase $_dbobj a db connection to use (also provides db type, specs, etc) */
  var $_dbobj;

  /** @var DbTypeInfo $_dbc a DbTypeInfo* object specific to the database type */
  var $_dbc;

  /** @var string $_dbtype is the database type in use */
  var $_dbtype;

}

?>
