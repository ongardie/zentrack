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
   * @param boolean $devmode zen.ini->develop mode parameter, affects how tables are created/loaded
   */
  function ZenDBXML( &$dbobject, $xmlfile, $devmode ) {
    $this->_dbobj =& $dbobject;
    $this->_dbtype = $this->_dbobj->getDbType();
    $this->_dbTypeInfo = new DbTypeInfo( $dbobject );
    $this->_schema = new ZenDbSchema( $xmlfile, false, $devmode );
  }

  /* HIGH LEVEL METHODS */

  /**
   * Dumps database data to xml for storage, optionally gzip or zip data
   * 
   * //todo
   *
   * @param string $ouptut is directory to output xml data to
   * @param mixed $table [optional] (string)table or (array)tables to dump, otherwise all
   * @param string $compress set compression type (null-none, gzip, zip)
   * @return array [0]files attempted, [1]files successfully dumped
   */
  function dumpDatabaseData( $output, $table = null, $compress = null ) { 
    if( $table ) { $tables = is_array($table)? $table : array($table); }
    else { $tables = $this->_schema->listTables(); }
    $results = array(0,0);
    foreach( $tables as $t ) {
      $table = $this->_schema->getTableArray($t);
      $t = strtolower($t);
      // do not query abstract tables
      if( $table['is_abstract'] ) { continue; }

      $rows = Zen::simpleQuery($t);
      if( !count($rows) ) {
        ZenUtils::safeDebug($this, 'dumpDatabaseData', "$t contains no data, skipped", 0, LVL_INFO);
        continue;
      }
      else {
        ZenUtils::safeDebug($this, 'dumpDatabaseData', "$t: backing up ".count($rows)." rows of data", 0, LVL_INFO);
      }

      $results[0]++;
      $text = "<dataDump>\n";
      $file = $output."/$t.xml";
      foreach($rows as $r) {
        $text .= "  <dataRow>\n";
        foreach($r as $col=>$val) {
          $text .= "    <$col>".htmlspecialchars($val)."</$col>\n";
        }
        $text .= "  </dataRow>\n";
      }
      $text .= "</dataDump>\n";
      if( !$this->_dumpToFile($file, $text, $compress) ) {
        ZenUtils::safeDebug($this, 'dumpDatabaseData', "Unable to dump $t!", 220, LVL_ERROR);
      }
      else { 
        $results[1]++; 
      }
    }
    return $results;
  }

  /**
   * Loads xml data into database.  This will load all files in the source
   * directory ending with .xml or .gz, but not the database.xml file 
   * (this is the schema file).
   *
   * <p>Note that this function will also update the counters for each table
   * that it loads data into so that they will be current with the new rowids.
   *
   * @param string $dir is the source directory where xml dump is stored
   * @param array $tables if provided, then these tables will be loaded
   * @param boolean $drop if true, drops data from table before loading new data
   * @return array [0]tables attempted, [1]tables successfully loaded
   */
  function loadDatabaseData( $dir, $tables = null, $drop = true ) {
    $nums = array(0,0);
    $dh = opendir($dir);
    if( !$dh ) { 
      ZenUtils::safeDebug($this, 'loadDatabaseData', "Invalid directory: $dir", 105, LVL_ERROR);
      return false; 
    }
    $files = array();
    while( ($file = readdir($dh)) == true ) {
      if( !strpos($file, '.') === 0 && $file != 'database.xml' && preg_match('/\.(zip|gz|xml)$/', $file) ) {
        $files[] = $file;
      }
      else if( !strpos($file, '.')===0 ) {
        ZenUtils::safeDebug($this, 'loadDatabaseData', "Invalid file: $file, skipping", 
                            25, LVL_WARN);
      }
    }
    if( $tables ) {
      $newfiles = array();
      foreach($files as $f) {
        $n = preg_replace('/[.][a-zA-Z0-9]+$/', '', $f);
        if( in_array($n, $tables) ) {
          $newfiles[] = $f;
        }
      }
      $files = $newfiles;
    }
    $nums[0] = count($files);
    $max_ids = array();
    foreach($files as $f) {
      $rows = $this->_loadDataFromXML("$dir/$file");
      $table = substr($f, 0, strpos($f, '.'));
      $this->msg("L $table");
      if( $rows ) {
        $count = 0;
        $row = 1;
        foreach($rows as $r) {
          $newid = Zen::simpleInsert($table, $r);
          if( !$newid ) {
            ZenUtils::safeDebug($this, 'loadDatabaseData', 
                                "Insert $row of ".count($rows)." failed for table $table", 
                                26, LVL_ERROR);
          }
          else { 
            if( !isset($max_ids[$table]) || $newid > $max_ids[$table] ) {
              $max_ids[$table] = $newid;
            }
            $count++; 
          }
        }
        if( $count == count($rows) ) { $nums[1]++; }
      }
    }
    // update the table_ids so that we don't run into a calamity
    // when an attempt is made to do an insert in the future
    foreach($max_ids as $table=>$max) {
      $curr = $this->_dbobj->generateID($table);
      if( $curr <= $max_ids ) {
        $update = "UPDATE ".$this->_dbobj->makeTableName('TABLE_IDS')
          ." SET current_id = current_id + 1 where name_of_table = '$table'";
        if( !$this->_dbobj->execute($update) ) {
          ZenUtils::safeDebug($this, 'loadDatabaseData', 
                              "Unable to update primary key value for table $table", 
                              200, LVL_WARN);
        }
      }
    }
    return $nums;
  }
  
  /**
   * Deletes all data from database.  This does not backup the data!  Use with care.
   *
   * @param string $table if provided, only deletes this table
   * @return array [0]number of deletes attempted, [1]number of deletes successful
   */
  function deleteDatabaseData( $table = null ) {
    $tables = $table? array($table) : $this->_schema->listTables();
    $nums = array(count($tables), 0);
    foreach($tables as $t) {
      $query = Zen::getNewQuery();
      $query->table($t);
      if( $query->delete() ) { 
        $nums[1]++; 
        $this->msg("T $t");
      }
      else { 
        ZenUtils::safeDebug($this, 'deleteDatabaseData',
                            "Could not truncate $t", 220, LVL_ERROR);
      }
    }
    return $nums;
  }
  
  /**
   * Loads a schema from xml to the database.  The schema passed in the constructor of
   * this object will be used for constructing new db.
   *
   * @param boolean $drop will cause the load to drop each table before creation
   * @return array [0]number of adds attempted, [1]number of adds succeeded
   */
  function createDbSchema( $drop = false ) {
    $num = array(0,0);
    $tables = $this->_schema->getAllTables();
    foreach($tables as $name=>$table) {
      // do not create abstract tables
      if( $table['is_abstract'] ) { continue; }

      $num[0]++;

      // drop tables before creating
      $dbt = $this->_dbobj->makeTableName($name);
      if( $drop ) {
        $sql = $this->_dbTypeInfo->dropTableSyntax($dbt);
        if( !$this->_dbobj->execute($sql) ) {
          ZenUtils::safeDebug($this, 'createDbSchema', 
                              "Table $name not dropped(probably ok)", 00, LVL_NOTE);           
        }
        else {
          $this->msg("D $dbt dropped");
        }
      }

      // assign abstract fields and create
      $inheritedFields = $this->_schema->getInheritedFields($name);
      if( is_array($inheritedFields) ) {
        foreach( $inheritedFields as $key=>$props ) {
          if( !isset($table['fields'][$key]) ) {
            $table['fields'][$key] = $props;
          }
        }
      }

      $sql_stmts = $this->_dbTypeInfo->addTableSyntax($dbt, $table['fields'], 
                                                      ($table['has_transactions'] == true));
      if( $this->_dbobj->execute($sql_stmts[0]) ) {
        $this->msg("C $dbt created");
        // run special sql associated with table
        // (may create sequences, indexes, or primary
        // keys)
        for($i=1; $i<count($sql_stmts); $i++) {
          if( !$this->_dbobj->execute($sql_stmts[$i]) ) {
            ZenUtils::safeDebug($this, 'createDbSchema', "Unable to create special table param: $sql", 
                                220, LVL_ERROR);
          }
        }
        // create indices for table
        $indices = $this->_schema->getMergedIndices($name);
        if( count($indices) ) {
          foreach($indices as $index=>$columns) {
            $sql = $this->_dbTypeInfo->addIndexSyntax($index, $dbt, $columns, false);
            if( !$this->_dbobj->execute($sql) ) {
              ZenUtils::safeDebug($this, 'createDbSchema', 
                                  "Unable to create index: $index", 220, LVL_WARN); 
            }
          }
        }
        $num[1]++;
      }
      else {
        ZenUtils::safeDebug($this, 'createDbSchema', "Unable to create table: $name", 
                            220, LVL_ERROR);
      }
    }
    return $num;
  }

  /**
   * Drop tables from database.  This does not create a backup, use with caution!!
   *
   * @param mixed $tables is array of tables or single table to drop (all if not specified)
   * @return array [0]number of drops attempted, [1]number of drops succeeded
   */
  function dropDbSchema( $tables = null ) {
    $num = array(0,0);
    if( $tables ) { $tables = is_array($tables)? $tables : array($tables); }
    else { $tables = $this->_schema->listTables(); }
    foreach($tables as $name) {
      $table = $this->_schema->getTableArray($name);
      if( $table['is_abstract'] ) { continue; } // skip abstract tables
      $num[0]++;
      $dbt = $this->_dbobj->makeTableName($name);
      $sql = $this->_dbTypeInfo->dropTableSyntax($dbt);
      if( !$this->_dbobj->execute($sql) ) {
        ZenUtils::safeDebug($this, 'dropDbSchema', 
                            "Unable to drop table: $name", 220, LVL_ERROR);
      }
      else { 
        $this->msg("D $dbt");
        $num[1]++; 
      }
    }
    return $num;
  }

  /**
   * Compares existing database schema to new schema and updates as needed
   *
   * @params string $newxml is the full path and filename of the new xml schema to load
   * @return array [0]number of updates attempted, [1]number successfully completed
   */
  function updateDbSchema( $newxml ) {
    $res = array(0,0);
    $updates = $this->compareXmlSchemas($newxml);
    foreach( $updates as $u ) {
      $res[0]++;
      $tbl = $this->_dbobj->makeTableName($u['table']);
      switch($u['action']) {
      case "droptable":
        $sql = $this->_dbTypeInfo->dropTableSyntax( $tbl );
        break;
      case "addtable":
        $sql = $this->_dbTypeInfo->addTableSyntax($tbl, $u['columns'], $u['has_transactions']);
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
      if( !$this->_dbobj->execute($sql) ) {
        ZenUtils::safeDebug($this, 'updateDbSchema', "{$u['action']}->{$u['table']} failed: $sql", 
                            220, LVL_ERROR);
      }
      else { 
        $this->msg("U {$u['action']}->{$u['table']}");
        $res[1]++; 
      }
    }
    return $res;
  }

  /**
   * Reads and executes the sql statements needed to synchronize data in an upgraded schema
   *
   * @params string $newxml is the new xml schema from which the statements will be retrieved
   * @return array [0]attempts, [1]successes
   */
  function synchronizeUpgradedDbData( $newxml ) {
    $queries = $this->getUpgradeQueries( $newxml );
    $nums = array( count($queries), 0 );
    foreach($queries as $q) {
      if( !$this->_dbobj->execute($sql) ) {
        ZenUtils::safeDebug($this, 'updateDbSchema', "Sql failed: $sql", 
                            220, LVL_ERROR);
      }
      else { $nums[1]++; }
    }
    return $nums;
  }

  /**
   * Returns all upgrade queries which are associated with a database schema
   *
   * @param string $xmlfile the xml schema to examine
   */
  function getUpgradeQueries($xmlfile) {
    $newschema = new ZenDbSchema( $xmlfile, false );
    return $newschema->getUpgradeQueries();
  }

  /**
   * Compares an old and new xml schema and creates a list of updates
   * which will convert the old layout to the new layout
   *
   * @param string $newxml is the full path and filename to new xml schema info
   * @return array containing list of updates to perform
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
   * Loads data from xml file into an array.  This can read gzipped files
   *
   * @param string $file
   * @return array mapped data_row->array( (String)column -> (mixed)value )
   */
  function _loadDataFromXml( $file ) {
    // read gzipped files
    if( preg_match('/.gz$/', $file) ) {
      if( !function_exists('gzopen') ) {
        ZenUtils::safeDebug($this, '_loadDataFromXml',
                            "ZLib doesn't appear to be compiled into php, unable to read gzipped files!",
                            22, LVL_ERROR);
        return false;
      }
      $file = join('',gzfile($file));
    }
    else if( preg_match('/.zip$', $file) ) {
      die("zip format not implemented!");
      //todo
      //todo
      //todo
    }

    // parse xml data
    $parser = new ZenXMLParser();
    $root =& $parser->parse($file);

    // obtain all <dataRow> nodes
    $vals = $root->getChild('dataRow');

    // load dataRow vals into array
    $rows = array();
    $i=0;
    foreach($vals as $v) {
      $set = $v->toArray(true);
      foreach( $set['children'] as $key=>$val ) {
        $rows[$i][$key] = $val['data'];
      }
    }

    //todo
    //todo undo htmlentities
    //todo
    //todo

    // return vals
    return $rows;
  }
  
  /**
   * Writes data to file, used to facilitate data streaming as needed
   *
   * @param string $file the output file
   * @param string $data is the data to write to file
   * @param string $compress null-do not compress, zip-zip compression, gzip-gzip compression
   * @param boolean $append if true, data is appended, otherwise file is overwritten
   */
  function _dumpToFile( $file, $data, $compress, $append = false ) {
    $dir = dirname($file);
    if( !@is_dir($dir) ) { 
      ZenUtils::safeDebug($this, '_dumpToFile', "Invalid directory: $dir", 22, LVL_WARN);
      return false; 
    }
    // strip off leading . for users like me who try to put the extension
    if( $compress ) { $compress = str_replace('.','',$compress); }
    // read gz compression
    if( $compress == 'gzip' ) {
      //todo
      //todo add zip compression
      //todo
      //todo
      $gz = function_exists('gzopen');
      if( !$gz ) {
        ZenUtils::safeDebug($this, '_dumpToFile', 
                            "Looks like ZLib isn't compiled into php, unable to compress file",
                            22, LVL_INFO);
      }
    }
    else if( $compress == 'zip' ) {
      die("zip compression not implemented");
      //todo
      //todo
      //todo
      //todo
    }
    $fp = $gz? gzopen($file.".gz", ($append? 'a9' : 'w9')) : fopen($file, ($append? 'a' : 'w'));
    if( !$fp ) { 
      ZenUtils::safeDebug($this, '_dumpToFile', "Couldn't open file pointer: $file", 22, LVL_WARN);
      return false; 
    }
    fputs($fp, $data);
    fclose($fp);
    $this->msg("B $file".($gz? ".gz":''));
    return true;
  }

  /**
   * Since we will use this method mainly with the install script, wrap debug output and print
   * in a special format for use by install prog
   */
  function msg( $txt ) {
    if( $GLOBALS['installMode'] > 0 ) {
      print "   $txt\n";
    }
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

  /** @var ZenDbSchema $_schema holds the schema for the database */
  var $_schema;

}

?>
