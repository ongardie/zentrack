<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** 
 * ZEN_EQ for ZenQuery: field EQUALS value
 */
define("ZEN_EQ", "=");

/** 
 * ZEN_LT for ZenQuery: field < value
 */
define("ZEN_LT", "<");

/** 
 * ZEN_LE for ZenQuery: field <= value
 */
define("ZEN_LE", "<=");

/** 
 * ZEN_GT for ZenQuery: field > value
 */
define("ZEN_GT", ">");

/** 
 * ZEN_GE for ZenQuery: field >= value
 */
define("ZEN_GE", ">=");

/** 
 * ZEN_IN for ZenQuery: field in ( value_list )
 */
define("ZEN_IN", "IN");

/** 
 * ZEN_BEGINS for ZenQuery: field begins with value ("value%")
 */
define("ZEN_BEGINS", "=%");

/** 
 * ZEN_ENDS for ZenQuery: field ends with value ("%value")
 */
define("ZEN_ENDS", "%=");

/** 
 * ZEN_CONTAINS for ZenQuery: field contains value ("%value%")
 */
define("ZEN_CONTAINS", "%=%");

/** 
 * Manages information concerning individual queries.
 *
 * @package DB
 * @author Mike Lively <mike@digitalsandwich.com>
 * @version 1.0
 */
class ZenQuery extends Zen {

  /**
   * Creates a new ZenQuery Object
   *
   * @access public
   * @since 1.0
   * @param object ZenDatabase The database object to bind this query object to.
   */
  function ZenQuery( &$dbobject ) {
    $this->Zen();
    $this->_dbobject =& $dbobject;
  }

  /**
   * Creates a correct table name from user input value
   *
   * @param string $name is the name of the table
   * @param string $field if provided, it is the name of a field and will be appended as such: table_name.field_name
   */
  function _fixName( $name, $field = null ) {
    return $this->_dbobject->makeTableName($name, $field);
  }

  /**
   * Adds a table to the query list
   *
   * @access public
   * @since 1.0
   * @param mixed $table the table(s) to be included
   */
  function table( $table ) {
    if (is_array($table)) {
      foreach($table as $t) {
	$this->_tables[] = $this->_fixName($t);
      }
      return true;
    }
    elseif (is_string($table)) {
      $this->_tables[] = $this->_fixName($table);
      return true;
    }
    else {
      $this->debug($this, 'table', 'Invalid Argument Passed: $table', 102, LVL_WARN);
      return false;
    }
  }

  /**
   * Adds a field to the select/insert/update list
   *
   * @access public
   * @since 1.0
   * @param mixed $field the column name to return/insert (can be an array for select statements only)
   * @param string $value the value to insert/update (not valid for selects)
   */
  function field( $field, $value = null, $table = null ) {
    if (is_array($field)) {
      foreach($field as $f) {
	$this->_fields[] = ($table)? $this->_fixName($table,$field) : $f;
      }
      return true;
    }
    elseif (is_string($field)) {
      if( $table )
	$field = $this->_fixName($table,$field);
      $this->_fields[] = $field;
      if (is_string($value) || is_numeric($value)) {
	$this->_vals[$field] = $value;
	return true;
      }
      elseif (isset($value)) {
	$this->debug($this, 'field', "Bad value: $value", 102, LVL_WARN);
	return false;
      }
    }
    else {
      $this->debug($this, 'field', "Bad field: $field", 102, LVL_WARN);
      return false;
    }
  }
  
  /**
   * Adds a field to the sorting clause (ORDER BY) for selects
   *
   * @access public
   * @since 1.0
   * @param mixed $field can be a string or an array of fields
   * @param mixed $descending can be a boolean or array
   */
  function sort( $field, $descending = false, $table = null ) {
    if (is_array($field)) {
      foreach ($field as $fieldIndex => $fieldName) {
	if( $table ) {
	  $fieldName = $this->_fixName($table,$fieldName);
	}
	if (is_array($descending)) {
	  $order = ($descending[$fieldIndex])?(' DESC'):(' ASC');
	}
	else {
	  $order = ($descending)?(' DESC'):(' ASC');
	}
	$this->_sorts[] = $fieldName . $order;
      }
    }
    else {
      if( $table )
	$field = $this->_fixName($table,$field);
      $order = ($descending)?(' DESC'):(' ASC');
      $this->_sorts[] = $field . $order;
    }
  }

  /**
   * Sets a condition for the WHERE clause. The $operator clause should be obtained from the constants defined by this class.
   *
   * @access public
   * @since 1.0
   * @param string $field the db field to match
   * @param string $operator is a condition like (equals, contains, etc)
   * @param string $value the value to be matched
   * @param string $table provide table if there is more than one choice for tables
   */
  function match( $field, $operator, $value, $table = null ) {
    if( $table )
      $field = $this->_fixName($table,$field);
    if ($whereClause = $this->_basicWhere($field, $value, $operator)) {
      $this->_wheres[] = '(' . $whereClause . ')';
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * Pass a ZenSearchParms object here to perform complex searches.
   *
   * Do not attempt to use this and use {@link match()} together.  This method will override
   * anything passed to the match() method.
   *
   * @param ZenSearchParms $parms
   * @return boolean true if valid parms provided
   */
  function search( $parms ) {
    if( !ZenUtils::isInstanceOf('ZenSearchParms', $parms) ) { return false; }
    $this->_searchParms = $parms->getParms();
    return true;
  }

  /**
   * Sets conditions for where clause that should be excluded from results. The $operator clause should be obtained from the constants defined by this class.
   *
   * @access public
   * @since 1.0
   * @param string $field the db field to match
   * @param string $value the value to be matched
   * @param string $operator is a condition like (equals, contains, etc)
   * @param string $table provide table if there is more than one choice for tables
   */
  function exclude( $field, $operator, $value, $table = null ) {
    if( $table )
      $field = $this->_fixName($table,$field);
    if ($whereClause = $this->_basicWhere($field, $value, $operator)) {
      $this->_wheres[] = '!(' . $whereClause . ')';
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * Sets the primary key field for this query.  This is only useful for inserts, and only works
   * if the table has already been set.
   *
   * @param string $key overrides the default 'tablename_id' if provided
   * @see ZenQuery::table()
   */
  function setPrimaryKey( $key = null ) {    
    if( !$key ) { $key = ZenDatabase::getPrimaryKey($this->_tables[0]); }
    $this->_key = $key;
    if( !in_array($key, $this->_fields) ) {
      $this->_fields[] = $key;
    }
    $this->_vals[$key] = $this->_dbobject->generateId($this->_tables[0]);
    Zen::debug($this, "setPrimaryKey", "Primary key set: {$key}->{$this->_vals[$key]}", 0, LVL_DEBUG);
    return $this->_vals[$key];
  }
  
  /**
   * Returns a basic where clause.
   *
   * If the where clause is valid then a simple where clause is returned. If it is invalid then a 
   * boolean false is returned.
   *
   * @access private
   * @since 1.0
   * @param string $field the db field to match
   * @param mixed $value the value to be matched (must pass array if operator is ZEN_IN, otherwise string)
   * @param string $operator is a condition like (equals, contains, etc)
   * @return mixed
   */
  function _basicWhere( $field, $value, $operator) {
    switch ($operator) {
    case ZEN_EQ:
    case ZEN_LT:
    case ZEN_LE:
    case ZEN_GT:
    case ZEN_GE:
      $whereClause = $field . " $operator " . $this->_dbobject->quote($value);
      break;
    case ZEN_IN:
      $whereClause = $field . ' IN(' . join(",",$this->_dbobject->quote($value)) . ')';
      break;
    case ZEN_BEGINS:
      $whereClause = $field . ' LIKE ' . $this->_dbobject->quote("$value%");
      break;
    case ZEN_ENDS:
      $whereClause = $field . ' LIKE ' . $this->_dbobject->quote("%$value");
      break;
    case ZEN_CONTAINS:
      $whereClause = $field . ' LIKE ' . $this->_dbobject->quote("%$value%");
      break;
    }
    if (isset($whereClause)) {
      return $whereClause;
    } else {
      $this->debug($this, '_basicWhere', 'No where clause added', 121, LVL_WARN);
      return false;
    }
  }

  /**
   * Joins two tables on the given field (or links appropriately.)
   *
   * @access public
   * @since 1.0
   * @param string $table is the table to be joined
   * @param string $field1 is the field used to match the tables
   * @param string $field2 is the field in the second table (optional), if omitted, field1 is used
   */
  function join( $table1, $table2, $field1, $field2 = null ) {
    if (!is_string($table1) || !is_string($table2)) {
      $this->debug($this, 'join', 'Invalid table', 102, LVL_ERROR);
      return false;
    }
    if (!is_string($field1)) {
      $this->debug($this, 'join', 'Invalid field', 102, LVL_ERROR);
      return false;
    }
    if( !isset($field2) ) { $field2 = $field1; }
    $this->_joins[] = array($table1, $table2, $field1, $field2);
    return true;
  }

  /**
   * Sets the maximum number of rows to return.
   *
   * @access public
   * @since 1.0
   * @param integer $limit is the maximum number to return
   * @param integer $offset is the row number to start returning from
   */
  function limit( $limit, $offset = 0 ) {    
    if (!is_int($limit)) {
      $this->debug($this, 'limit', 'Invalid limit', 102, LVL_WARN);
      return false;
    }
    if (!is_int($offset)) {
      $this->debug($this, 'limit', 'Invalid offset', 102, LVL_WARN);
      return false;
    }
    $this->_limit = $limit;
    $this->_offset = $offset;
    return true;
  }
  
  /**
   * Returns a single database value (rather than an array.)
   *
   * If there were no errors in the query the first column of the first row in the result set is 
   * returned. If there were errors, a boolean value of false is returned.
   *
   * @access public
   * @since 1.0
   * @param int $cacheTime The amount of time to leave the query in the cache.
   * @return mixed
   */
  function get($cacheTime = 0) {
    if (count($this->_fields) > 1) {
      $this->debug($this, 'get', 'This function may be called only when one value is requested.', 160, LVL_ERROR);
      return false;
    }
    if (count($this->_fields) < 1) {
      $this->debug($this, 'get', 'No columns were specified', 161, LVL_ERROR);
      return false;
    }
    if ($this->_limit != 1) {
      $this->debug($this, 'get', 'This query has been marked to return more than one row.'
                   .'Modifying query to truncate result set.', 0, LVL_NOTE);
      $this->_limit = 1;
    }
    $this->_queryType = 'SELECT';
    $query = $this->_buildQuery();
    
    if ($query === false) {
      $this->debug($this, 'get', '_buildQuery() failed', 103, LVL_ERROR);
      return false;
    }
    return $this->_dbobject->executeGetOne($query, $cacheTime);
  }

  /**
   * Performs a select statement and returns a single row of data
   *
   * @access public
   * @since 1.0
   * @param boolean $indexed whether results are returned in an associative (true) or plain array (false)
   * @param int $cacheTime The amount of time to leave the query in the cache.
   * @return array (empty array if query fails)
   */
  function selectRow($cacheTime = 0, $indexed = false) {
    $vals = $this->select( $cacheTime, $indexed );
    if( !count($vals) ) {
      return array();
    }
    else { return $vals[0]; }
  }

  /**
   * Performs a select statement and returns results with the given criteria.
   *
   * Returns an array containing the results from the query. If the query fails, it will return an empty array
   *
   * @access public
   * @since 1.0
   * @param boolean $indexed whether results are returned in an associative (true) or plain array (false)
   * @param int $cacheTime The amount of time to leave the query in the cache.
   * @return array of rows(array mapped (string)field->(mixed)value) (empty array if query fails)
   */
  function select($cacheTime = 0, $indexed = false) {
    $this->_dbobject->setFetchMode($indexed);
    $this->_queryType = 'SELECT';
    $result = $this->_execute($cacheTime);
    if ($result) {
      return $result->GetArray();
    }
    else { return array(); }
  }

  /**
   * Peforms an insert with the given criteria.
   *
   * Note that this only works properly properly 
   * if a primary key has been set.
   *
   * @access public
   * @since 1.0
   * @see ZenQuery::setPrimaryKey()
   * @param boolean $setPrimaryKey if true, will attempt to run {@link ZenQuery::setPrimaryKey()}
   * @return integer representing id of inserted row or false if none
   */
  function insert( $setPrimaryKey = false ) {
    if( $setPrimaryKey ) { $this->setPrimaryKey(); }
    $this->_queryType = 'INSERT';
    if( $this->_execute(false) ) {
      if( isset($this->_key) ) {
        return $this->_vals[$this->_key];
      }
      else {
        return true;
      }
    }
    else { return false; }
  } 
  
  /**
   * Performs an update with the given criteria.
   *
   * Returns the number of rows that were updated.
   *
   * @access public
   * @since 1.0
   * @return integer representing number of affected rows
   */
  function update() {
    $this->_queryType = 'UPDATE';
    $this->_execute(false);
    return $this->_dbobject->affectedRows();
  }

  /**
   * Performs a delete based on the given criteria.
   *
   * Returns the number of rows that were updated.
   *
   * @access public
   * @since 1.0
   * @return integer representing number of affected rows
   */
  function delete() {
    $this->_queryType = 'DELETE';
    $this->_execute(false);
    return $this->_dbobject->affectedRows();
  }

  /**
   * Performs a replace on the given id.
   *
   * Returns an integer value depicting what happened. If the value returned equals 0 then the query 
   * failed. If the value returned equals 1 then a row was updated. If the value equals 2 then a new 
   * row was added.
   *
   * @access public
   * @since 1.0
   * @param mixed $field the field to match on, if the value is set to array then all fields will be matched.
   * @return 0=failure, 1=updated, 2=inserted
   */
  function replace($field) {
    $table = $this->_tables[0];
    
    $fieldsArray = array();
    foreach ($this->_fields as $name) {
      $fieldsArray[$name] = $this->_dbobject->quote($this->_vals[$name]);
    }
    
    return $this->_dbobject->replace($table, $fieldsArray, $field);	
  }

  /**
   * Sends the query to the ZenDatabase object and executes query.
   *
   * Returns the results from the query.
   *
   * @access private
   * @since 1.0
   * @param int $cacheTime The amount of time to leave the query in the cache.
   * @return mixed
   */
  function _execute($cacheTime = 0) {
    // generate query
    $query = $this->_buildQuery();
    $this->_queryString = $query; //store for debugging
    if ($query === false) {
      $this->debug($this, '_execute', '_buildQuery() failed', LVL_ERROR);
      return false;
    }

    return $this->_dbobject->execute($query, $cacheTime, $this->_limit, $this->_offset);
  }

  /**
   * Returns the query string for debugging(only useful after calling {@link ZenQuery::execute()}
   */
  function getQueryString() {
    return $this->_queryString;
  }

  /**
   * Creates a field set clause for a SELECT statement based on the given parameters.
   *
   * Returns a string to be used to specify the set of fields to select. If no fields were specified 
   * it defaults to '*' (all fields.)
   *
   * @access private
   * @since 1.0
   * @return string
   */
  function _selectFieldsClause() {
    if (count($this->_fields) > 0) {
      return implode(', ', $this->_fields);
    }
    else {
      $this->debug($this, '_selectFieldsClause', 'No fields were specified. Defaulting to "*"', 104, LVL_NOTE);
      return '*';
    }
  }

  /**
   * Creates a field set to be updated into the database based on given parameters.
   *
   * Returns a string that can be used in the SET clause of an INSERT or UPDATE statement. If there
   * was an error building the statement then a value of false is returned.
   *
   * @access private
   * @since 1.0
   * @return mixed
   */
  function _setFieldsClause() {
    $setFields = array();
    if (count($this->_fields) > 0) {
      foreach ($this->_fields as $fieldName) {
	if (isset($this->_vals[$fieldName])) {
	  $setFields[] = "{$fieldName} = " . $this->_dbobject->quote($this->_vals[$fieldName]);
	}
      }
      return implode(', ', $setFields);
    }
    else {
      $this->debug($this, '_setFieldsClause', 'No fields were specified.', 101, LVL_ERROR);
	  return false;
    }
  }

  /**
   * Creates an array containing field names and values for insert statement
   *
   * @access private
   * @return array array( (String)field_names, (String)field_values )
   */
  function _insertFieldsClause() {
    if( !is_array($this->_vals) || count($this->_vals) < 1 ) {
      $this->debug($this, "_insertFieldsClause", "No fields/values found for insert", 101, LVL_ERROR);
      return false;
    }
    $keys = "";
    $vals = "";
    foreach($this->_vals as $key=>$val) {
      $keys .= $keys? ",$key" : $key;
      $vals .= ( $vals? ",":"" ).$this->_dbobject->quote($val);
    }
    return array($keys,$vals);
  }

  /**
   * Creates a table list based on the given parameters.
   *
   * Returns a string representing tables used in the query. Returns false if no tables have been 
   * specified.
   *
   * @access private
   * @since 1.0
   * @return mixed
   */
  function _tablesClause() {
    if (count($this->_tables) > 0) {
      return implode(", ",$this->_tables);
    }
    else {
      $this->debug($this, '_tablesClause', 'No tables were specified.', 101, LVL_ERROR);
      return false;
    }
  }
  
  /**
   * Creates a set of joins to be used in a select query.
   *
   * Returns a string representing table joins to be used in the query. If no joins are to be used, a
   * blank string will be returned.
   *
   * @access private
   * @since 1.0
   * @return string
   */
  function _joinsClause() {
    if (count($this->_joins) > 0) {
      foreach($this->_joins as $j) {
	$this->_wheres[] = "(".$this->_fixName($j[0],$j[2])." = ".$this->_fixName($j[1],$j[3]).")";
      }
    }
    else {
      $this->debug($this, "_joinsClause", "No joins found", LVL_DEBUG);
      return '';
    }
  }
  
  /**
   * Creates the set of where clauses to be used in a query.
   *
   * Returns a string representing WHERE clauses to be used in the query. If no where clauses are to 
   * be used an empty string is returned
   *
   * @access private
   * @since 1.0
   * @return string
   */
  function _whereClause() {
    if( $this->_searchParms ) {
      // open the clause
      $clause = 'WHERE ';
      // init the andor conditions
      $andors = array();
      // this says whether or not to add the andor condition 
      // for the next where statement
      $add = false;
      foreach($this->_searchParms as $s) {
        if( !is_array($s) ) {
          // this is closing tag
          $clause .= "$s ";
          $andor = array_pop($andors);
          // insure that a junction appears after the ')'
          $add = true;
        }
        else if( count($s) == 2 ) {
          // this is an opening tag and a new andor condition
          $clause .= "{$s[0]} ";
          $andor = $s[1];
          array_push($andors, $andor);
          // we don't want to put a junction after a '('
          $add = false;  
        }
        else {
          // this is a match set
          if( $s[3] ) { $s[0] = $this->_fixName($s[3],$s[0]); }
          if( $where = $this->_basicWhere($s[0], $s[2], $s[1]) ) {
            $clause .= $add? "$andor " : '';
            $clause .= $where.' ';
          }
          else {
            $this->debug($this, "_whereClause", 
                         "Faulty search param: $s[0], $s[1], $s[2], $s[3]", 
                         105, LVL_ERROR);
          }
          // we need a junction before we add any more values
          $add = true;
        }
      }
      return $clause;
    }
    else if (count($this->_wheres) > 0) {
      return 'WHERE ' . implode(' AND ', $this->_wheres);
    }
    else {
      $this->debug($this, "_whereClause", "No where clause generated", 0, LVL_DEBUG);
      return '';
    }
  }
  
  /**
   * Creates the ORDER BY clause.
   *
   * Returns a string representing the ORDER BY clause to be used in the query. If no order by 
   * clauses are to be used an empty string is returned.
   *
   * @access private
   * @since 1.0
   * @return string 
   */
  function _orderByClause() {
    if (count($this->_sorts) > 0) {
      return 'ORDER BY ' . implode(', ', $this->_sorts);
    }
    else {
      $this->debug($this, "_orderByClause", "No orderBy clause generated", LVL_DEBUG);
      return '';
    }
  }

  /**
   * Constructs a query based on parameters given to the object.
   *
   * Returns a string containing the query to be passed to the database server. If there was an error 
   * building the query then false is returned.
   *
   * @access private
   * @since 1.0
   * @return mixed
   */
  function _buildQuery() {
    $query = '';
    switch ($this->_queryType) {
    case 'SELECT':
      $query .= 'SELECT ' . $this->_selectFieldsClause();
      $tables = $this->_tablesClause();
      if ($tables === false) {
	return false;
      }
      $query .= " FROM $tables ";
      $query .= $this->_whereClause() . ' ';
      $query .= $this->_orderByClause() . ' ';
      break;
    case 'INSERT':
      $tables = $this->_tablesClause();
      if ($tables === false) {
	return false;
      }
      $vals = $this->_insertFieldsClause();
      if ($vals === false) {
	return false;
      }
      list($fields,$values) = $vals;
      $query .= 'INSERT INTO ' . $tables;
      $query .= " ($fields) VALUES($values) ";
      break;
    case 'UPDATE':
      $tables = $this->_tablesClause();
      if ($tables === false) {
	return false;
      }
      $fields = $this->_setFieldsClause();
      if ($fields === false) {
	return false;
      }
      $query .= "UPDATE $tables ";
      $query .= "SET $fields ";
      $query .= $this->_whereClause();
      break;
    case 'DELETE':
      $tables = $this->_tablesClause();
      if ($tables === false) {
	return false;
      }
      $query .= "DELETE FROM $tables ";
      $query .= $this->_whereClause();
      break;
    }
    return $query;
  }

  /**
   * Returns a list of params for use in creating the sql statement.
   *
   * Essentially returns all the private variables of this object for
   * use in constructing the select columns, where clause, sorting, etc.
   *
   * @access private
   * @since 1.0
   * @return array
   */
  function getParams() {
    return array(
		 'tables' => $this->_tables,
		 'tableJoins' => $this->_joins,
		 'fields' => $this->_fields,
		 'values' => $this->_vals,
		 'sorts' => $this->_sorts,
		 'whereClauses' => $this->_wheres,
		 'limit' => $this->_limit,
		 'offset' => $this->_offset,
		 'queryType' => $this->_queryType,
		 );
  }

  /** 
   * The database object to use for connections.
   *
   * @access private
   * @since 1.0
   * @var object ZenDatabase
   */
  var $_dbobject;

  /** 
   * The tables associated with the query.
   *
   * @access private
   * @since 1.0
   * @var array
   */
  var $_tables = array();

  /** 
   * The tables joined to the query.
   *
   * @access private
   * @since 1.0
   * @var array
   */
  var $_joins = array();

  /** 
   * The fields associated with the query.
   *
   * @access private
   * @since 1.0
   * @var array
   */
  var $_fields = array();

  /** 
   * The values to use with each field. Field names are used as the index.
   *
   * @access private
   * @since 1.0
   * @var array
   */
  var $_vals = array();

  /** 
   * The fields to use when sorting.
   *
   * @access private
   * @since 1.0
   * @var array
   */
  var $_sorts = array();

  /** 
   * The conditions to include in the where clauses.
   *
   * @access private
   * @since 1.0
   * @var array
   */
  var $_wheres = array();

  /**
   * An advanced set of matching conditions
   * @access private
   * @var array()
   */
  var $_searchParms = null;

  /**
   * The primary key (as declared by setPrimaryKey) or null if not set
   *
   * @var string
   */
  var $_key;

  /** 
   * The maximum number of records to return
   *
   * @access private
   * @since 1.0
   * @var int
   */
  var $_limit;

  /** 
   * The result row to start results from.
   *
   * @access private
   * @since 1.0
   * @var int
   */
  var $_offset;
  
  /** 
   * The type of query to be performed. Valid values are: SELECT, INSERT, UPDATE, or DELETE
   *
   * @access private
   * @since 1.0
   * @var string
   */
  var $_queryType;

  /**
   * @var the query, stored for debugging
   */
  var $_queryString;

}

?>
