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
   * @param string $xmlfile is the full path and name of the xml file which holds the database schema info
   */
  function ZenDBXML( &$dbobject, $xmlfile ) {     
    $this->_dbobj =& $dbobject;
    $this->_dbtype = $this->_db->getDbType();
    $this->_dbTypeInfo = new DbTypeInfo( &$dbobject );
    $this->_schema = new ZenDbSchema( $xmlfile, false );
  }

  /* HIGH LEVEL METHODS */

  /**
   * Dumps database data to xml for storage, optionally gzip or zip data
   * 
   * //todo
   *
   * @param string $ouptut is directory to output xml data to
   * @param string $table [optional] dumps only one table
   * @param string $compress compression type (null, gzip or zip)
   * @return boolean true/false if succeeded
   */
  function dumpDatabaseData( $output, $table, $compress ) { 
    if( $table ) { $tables = array( $this->_schema->getTableArray($table) ); }
    else { $tables = $this->_schema->listTables(); }
    foreach( $tables as $t ) {
      $text = "<dataDump>\n";
      $file = $output."/$t.xml";
      $query = Zen::getNewQuery();
      $query->table($t);
      $rows = $query->select();
      foreach($rows as $r) {
        $text .= "\t<dataRow>\n";
        foreach($r as $col=>$val) {
          $text .= "\t\t<$col>".htmlspecialchars($val)."</$col>\n";
        }
        $text .= "\t</dataRow>\n";
      }
      $text .= "</dataDump>\n";
      $this->_dumpToFile($ouptut, $text, $compress);
    }
  }

  /**
   * Loads xml data into database
   *
   * @param string $dir is the source directory where xml dump is stored
   * @param string $table if provided, then only this table will be loaded
   */
  function loadDatabaseData( $dir, $table = null ) {
    //todo
    //todo
    //todo implement this, check out simpleInsert and ZenQuery
    //todo remember to convert table names if using execute()
  }
  
  /**
   * Deletes all data from database.  This does not backup the data!  Use with care.
   *
   * @param string $table if provided, only deletes this table
   */
  function deleteDatabaseData( $table = null ) {
    //todo
    //todo
    //todo implement this, check out the ZenQuery to see if it will do
    //todo remember to convert table names if using execute()
  }
  

  /**
   * Dumps database schema to xml for storage, optionally gzip or zip data
   *
   * @param string $ouptut is the file to write to
   * @param string $table [optional] dumps only one table
   * @param string $compress compression type (null, gzip or zip)
   * @return boolean true/false if succeeded
   */
  function dumpDatabaseSchema( $output, $table, $compress ) {
    //todo
    //todo
    //todo
    //todo set this up to use adodb if possible, otherwise just
    //todo try to read the schema
  }

  /**
   * Loads a schema from xml to the database
   *
   * @param string $xmlfile is the xml file to load
   * @param boolean $drop will cause the load to drop each table before creation
   * @return int number of tables added successfully
   */
  function loadSchemaToDB( $xmlfile, $drop = false ) {
    $num = 0;
    $schema = new ZenDbSchema( $xmlfile, false ); 
    $tables = $schema->getAllTables();
    foreach($tables as $name=>$table) {
      $dbt = $this->_dbobj->makeTableName($name);
      if( $drop ) {
        //todo
        //todo
        //todo
        //todo add some error validation
        //todo
        $sql = $this->_dbTypeInfo->dropTableSyntax($dbt);
        $this->_dbobj->execute($sql);
      }
      $inheritedFields = $schema->getInheritedFields($name);
      if( is_array($inheritedFields) ) {
        foreach( $inheritedFields as $key=>$props ) {
          if( !isset($table['fields'][$key]) ) {
            $table['fields'][$key] = $props;
          }
        }
      }
      
      //todo
      //todo
      //todo add some error validation
      //todo
      $sql = $this->_dbTypeInfo->addTableSyntax($dbt, $table['fields'], 
                                                ($table['transactions'] == true));
      if( $this->_dbobj->execute($sql) ) { 
        $indices = $schema->getMergedIndices($name);
        if( $indices ) {
          foreach($indices as $index=>$columns) {
            $sql = $this->_dbTypeInfo->addIndexSyntax($index, $dbt, $columns, false);
            $res = $this->_dbobj->execute($sql);
            //todo
            //todo
            //todo do some error validation
          }
        }
        $num++;
      }
    }
    return $num;
  }

  /**
   * Compares existing database schema to new schema and updates as needed
   *
   * @params string $newxml is the full path and filename of the new xml schema to load
   */
  function updateDbSchema( $newxml ) {
    $updates = $this->compareXmlSchemas($newxml);
    foreach( $updates as $u ) {
      $tbl = $this->_dbobj->makeTableName($u['table']);
      switch($u['action']) {
      case "droptable":
        $sql = $this->_dbTypeInfo->dropTableSyntax( $tbl );
        break;
      case "addtable":
        $sql = $this->_dbTypeInfo->addTableSyntax($tbl, $u['columns'], $u['transactions']);
        break;
      case "dropcolumn":
        $sql = $this->_dbTypeInfo->dropColumnSyntax($tbl, $u['column']);
        break;
      case "addcolumn":
        $sql = $this->_dbTypeInfo->addColumnSyntax($tbl, $u['column'], $u['type'], $u['unique'],
                                                   $u['notnull'], $u['size']);
        break;
      case "dropindex":
        $sql = $this->_dbTypeInfo->dropIndexSyntax($u['index']);
        break;
      case "addindex":
        $sql = $this->_dbTypeInfo->addIndexSyntax($u['index'], $tbl, $u['columns'], false);
        break;
      }
      $res = $this->_dbobj->execute($sql);
      //todo
      //todo
      //todo
      //todo some error validation here
    }
  }

  /**
   * Compares an old and new xml schema and creates a list of updates
   * which will convert the old layout to the new layout
   *
   * @param string $newxml is the full path and filename to new xml schema info
   */
  function compareXmlSchemas( $newxml ) {
    $updates = array();
    // load all table and index info for the old and new schemas
    $oldschema = $this->_schema;
    $newschema = new ZenDbSchema( $newxml, false );
    $oldtables = $oldschema->listTables();
    $newtables = $newschema->listTables();
    // check the old table schema vs new, remove anything not in new schema
    foreach($oldschema as $name) {
      $ot = $oldschema->getMergedTableArray($name);
      $nt = $newschema->getMergedTableArray($name);
      if( !$nt ) {
        // remove outdated tables
        $updates[] = array('action' => 'droptable', 'table' => $name);
      }
      else {
        foreach($ot['fields'] as $col=>$vals) {
          if( !isset($nt[$name][$col]) ) {
            // remove outdated columns
            $updates[] = array('action' => 'dropcolumn', 'table' => $name, 
                               'column' => $col); 
          }
        }
      }
    }

    // check the new schema vs old, add anything not in old schema
    // also compare for changes and drop/add as necessary
    foreach($newschema as $name) {
      $ot = $oldschema->getMergedTableArray($name);
      $nt = $newschema->getMergedTableArray($name);
      if( !$ot ) {
        // add new tables
        $updates[] = array('action' => 'addtable', 'table' => $name,
                           'transactions' => $nt['has_transactions'], 
                           'columns'=>$nt['fields']);
      }
      else {
        foreach( $nt['fields'] as $field=>$props ) {
          if( isset($ot[$name][$field]) 
              && !ZenUtils::arrayEquals($props, $ot[$name][$field]) ) {
            // update existing fields which have changed
            // by deleting the outdated column and replacing it
            // with updated column
            $updates[] = array('action'=>'dropcolumn', 'table'=>$name, 
                               'column'=>$field);
            unset($ot[$name][$field]);
          }
          if( !isset($ot[$name][$field]) ) {
            // add new columns
            $updates[] = $props;
            $updates['table'] = $name;
            $updates['action'] = 'addcolumn';
          }          
        }
      }
    }

    // check old indices vs new and remove any not in new schema
    foreach( $oldtables as $name ) {
      $oldindices = $oldschema->getMergedIndices($name);
      if( !count($oldindices) ) { continue; }
      $newindices = $newschema->getMergedIndices($name);
      if( !count($newindices) ) {
        foreach($oldindices as $ind=>$cols) {
          $updates[] = array('action'=>'dropindex', 'index'=>$ind, 'table'=>$name);
        }
      }
    }

    // check new indices vs old and remove any not in old schema
    // also check for any changes and update as needed
    foreach( $newtables as $name ) {
      $oldindices = $oldschema->getMergedIndices($name);
      $newindices = $newschema->getMergedIndices($name);
      if( !count($newindices) ) { continue; }
      foreach( $newindices as $ind=>$cols ) {
        if( isset($oldindices[$ind]) 
            && !ZenUtils::arrayEquals($cols, $oldindices[$ind]) ) {
          // if the index has changed, remove the existing
          // column so that it can be recreated with new properties
          $updates[] = array('action'=>'dropindex', 'index'=>$ind, 'table'=>$name);
          unset($oldindices[$ind]);
        }
        if( !isset($oldindices[$ind]) ) {
          // add any index which doesn't exist in the old set
          $updates[] = array('action'=>'addindex', 'table'=>$name,
                             'index'=>$ind, 'columns'=>$cols);
        }                             
      }
    }

    // send back the complete list
    return $updates;
  }

  /**
   * Loads data from xml file into an array 
   *
   * @param string $file
   * @return array mapped data_row->array( (String)column -> (mixed)value )
   */
  function _loadDataFromXml( $file ) {
    //todo
    //todo
    //todo implement this
  }
  
  /**
   * Writes data to file, used to facilitate data streaming as needed
   *
   * @param string $file the output file
   * @param string $data is the data to write to file
   * @param boolean $compress compress output files (if available)
   * @param boolean $append if true, data is appended, otherwise file is overwritten
   */
  function _dumpToFile( $file, $data, $compress, $append = false ) {
    //todo
    //todo
    //todo
    //todo check the method for appending
    //todo add zip functionality
    if( !@file_exists($file) ) { return false; }
    $fp = fopen($file, ($append? 'w+' : 'w'));
    if( !$fp ) { return false; }
    fputs($fp, $data);
    fclose($fp);
  }

  /* VARIABLES */

  /** @var ZenDatabase $_dbobj a db connection to use (also provides db type, specs, etc) */
  var $_dbobj;

  /** @var DbTypeInfo $_dbc a DbTypeInfo* object specific to the database type */
  var $_dbc;

  /** @var string $_dbtype is the database type in use */
  var $_dbtype;

  /** @var string $_xmlfile is the xml file holding db schema info */
  var $_xmlfile;

}

?>
