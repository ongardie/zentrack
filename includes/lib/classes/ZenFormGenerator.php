<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenFormGenerator class.  Requires Zen.php
 * @package Zen
 */

/**
 * ZenFormGenerator is used to create html forms from database
 * schema information.
 *
 * The template rendering form can expect to recieve the following input values:
 * <ul>
 *   <li><b>name</b> (string)the form name
 *   <li><b>action</b> (string)the form action
 *   <li><b>method</b> (string)the post method
 *   <li><b>odd</b> (boolean)whether there is an odd number or even number of fields
 *   <li><b>fields</b> (array) contains field info as outlined in {@link ZenDbSchema::getTableArray()}
 *     <br>Note that a field might contain the special type "break", which means this is a break in the fields,
 *     <br>to be anticipated and dealt with by the template.  The value of the special "break" field will be
 *     <br>"" or a title to display in the break line.
 * </ul>
 * 
 * @package Utils 
 */
class ZenFormGenerator extends Zen {

  /**
   * CONSTRUCTOR: Create a ZenFormGenerator
   *
   * @param ZenMetaTable $table is the meta info for the table used to create form (note that you probably want
   *         to get this from ZenMetaDb and not from ZenDbSchema!)
   * @param string $template the template file to use for creating form output
   */
  function ZenFormGenerator($table, $template) {
    ZenUtils::prep("ZenMetaField");
    ZenUtils::prep("ZenTemplate");
    ZenUtils::safeDebug('ZenFormGenerator', 'constructor', 
                        "template=".$template.", table=".$table->name(),
                        0, LVL_DEBUG);
    $this->_vals = array();
    $this->_table = $table;
    $this->_key = ZenUtils::getPrimaryKey($table->name());
    $this->setFormProp('title',$table->name());
    $this->setFormProp('description','');
    $this->setFormProp('showdescription', true);
    $this->setFormProp('submit','Send');
    $this->_template = $template;
    $this->_name = 'generatedForm';
    $this->_action = $_SERVER['SCRIPT_NAME'];
    $this->_method = 'POST';
    $this->_ids = array();
    $this->_rows = array();
    $this->_props = array();
  }


  /**
   * Load data into this form element from search parms (criteria)
   *
   * The $sortOrder param is mapped (string)field -> (boolean)descending
   * For instance, if you want to sort a table on name ASC, id DESC, you
   * would use array( "name"=>false, "id"=>true )
   *
   * @param ZenSearchParms $searchParms
   * @param array $sortOrder sort the results on the associative array (see description)
   * @param integer $limit maximum number of entries to load
   * @param integer $offset offset the entries (for next/last paging)
   * @return integer number of rows loaded
   */
  function loadFromParms( $searchParms, $sortOrder = null, $limit = 0, $offset = 0 ) {
    $this->_list = new ZenList();
    $this->_list->loadAbstract( $this->_table->name() );
    $this->_list->criteria($searchParms);
    if( $sortOrder ) {
      $this->_list->sort($sortOrder);
    }
    $this->_list->load($limit, $offset);
    $this->_ids = $this->_list->listIds();
  }

  /**
   * Load a row or several rows of data into this form element
   *
   * @param mixed $rowids primary key or array of primary keys for data to load
   * @return boolean if row loaded successfully
   */
  function loadData( $rowids ) {
    $this->_ids = is_array($rowids)? $rowids : array($rowids);
    $this->_list = new ZenList();
    $this->_list->loadAbstract( $this->_table->name() );
    $this->_list->criteriaIdArray($this->_ids);
    $this->_list->load();
  }

  /**
   * Set the name of the form
   *
   * @param string $name
   */
  function setFormName($name) { $this->_name = $name; }
 
  /**
   * Set the form action, defaults to $_SERVER['SCRIPT_NAME']
   *
   * @param string $action
   */
  function setFormAction($action) { $this->_action = $action; }
  
  /**
   * Set the form post method (GET or POST), defaults to POST
   *
   * @param string $method
   */
  function setPostMethod($method) { $this->_method = $method; }
  
  /**
   * Merge another template into this one.  Any conflicting fields
   * will be ignored (i.e. this form object will be preferred)
   *
   * @param ZenFormGenerator $secondForm
   */
  function merge( $secondForm ) {
    foreach($secondForm->listFields() as $f) {
      $this->_table->addMetaField( $secondForm->getMetaField($f) );
    }
  }

  /**
   * Add a new field to the form
   *
   * @param array $parms must match the parameters for ZenMetaField
   * @return boolean
   */
  function addNewField( $params ) {
    $field = new ZenMetaField($params);
    return $this->_table->addMetaField($field);
  }
  
  /**
   * Edit one or more properties of a field to appear on the form.
   *
   * The field properties correspond to the values as described in
   * {@link ZenDbSchema::getTableArray()}.
   *
   * Notes:
   * <br>The size element refers to the maximum input length for the field
   * <br>For ftype='checkbox', if defualt value != null, checkbox defaults to checked
   *
   * Also see {@link setFieldProp()} below for more options
   *
   * @param string $fname the form field name
   * @param array $props mapped (String)property -> (mixed)value
   */
  function modifyField( $fname, $props ) {
    $field = $this->_table->getMetaField($fname);
    if( $field == null ) { return null; }
    foreach( $props as $field=>$val ) {
      $field->setProp($field, $val);
    }
    return $this->_table->updateMetaField($field);
  }

  /**
   * Set a special form property for the field
   *
   * The following special properties exist for form fields:
   * <ul>
   *  <li><b>len</b> - the size of the input element
   *  <li><b>checkval</b> - the value to give a checkbox (defaults to 1)
   *  <li><b>vals</b> - if type is select, option, or helper, vals contains
   *       the valid choices (generated from criteria and reference values, 
   *       setting this overrides the existing values)
   *  <li><b>onBlur</b> - onBlur event handler
   *  <li><b>onClick</b> - onClick event handler
   *  <li><b>onChange</b> - onChange event handler
   *  <li><b>onMouseOver</b> - onMouseOver event handler
   *  <li><b>onMouseOut</b> - onMouseOut event handler
   *  <li><b>other</b> - things like class='..' and disabled attributes can be entered here
   *        (this should hardly ever be necessary to use)
   *  <li><b>multiple</b> - if this is a select field, and multiple is set to an integer, 
   *      then this select will allow multiple entries up to the maximum.
   * </ul>
   *
   * The following properties are reserved and may not be altered:
   * <ul>
   *   <li>settext - dynamically generated text from helpers or scripts
   *   <li>choices - choices available to a select option (see {@link _generateChoices()})
   * </ul>
   *
   * @param string $field form field name
   * @param string $prop special property
   * @param mixed $value
   * @return boolean
   */
  function setFieldProp($field, $property, $value) {
    if( in_array($field, $this->_specialProps) && $this->getMetaField($field) != null ) {
      if( !isset($this->_props[$field]) ) {
        $this->_props[$field] = array();
      }
      $this->_props[$field][$property] = $value;
      return true;
    }
    return false;
  }

  /**
   * Return an array containing the names of fields for this form
   */
  function listFields() {
    return $this->_table->listFields();
  }

  /**
   * Return a ZenMetaField object representing field
   *
   * @param string $field name of field
   * @return ZenMetaField
   */
  function getMetaField($field) {
    return $this->_table->getMetaField($field);
  }

  /**
   * Set a property for this form which can be used by template
   *
   * Any property can be added here, and will be availble to the template
   * when it is parsed.
   *
   * There are several standard properties:
   * <ul>
   *  <li><b>title</b> - the title of the form
   *  <li><b>description</b> - a description containing information or instructions
   *         for users which will appear on form.
   * </ul>
   *
   * There are also several reserved properties which cannot be set or accessed externally,
   * since they are dynamically generated during form creation:
   * <ul>
   *   <li>name - name property of the &lt;form&gt; element
   *   <li>action - action property of the &lt;form&gt; element
   *   <li>method - method property of the &lt;form&gt; element
   *   <li>rows - the generated data rows to display
   *   <li>hiddenfields - the form fields which are hidden from view
   *   <li>jsvals - special array for automatic js validation
   *   <li>showdescription - should field descriptions be printed on page (in addition to overlib)
   *   <li>table - name of database table
   *   <li>template - name of template in use
   * </ul>
   *
   * @param string $name
   * @param mixed $val
   */
  function setFormProp($name, $val) {
    $this->_vals[$name] = $val;
  }

  /**
   * Render the html form for display
   *
   * @return string containing html output
   */
  function render() {
    $markName = "ZenFormGenerator->Render(".$this->_table->name().")";
    // store performance times if possible
    ZenUtils::mark($markName);

    // generate values to pass to form
    $vals = $this->_vals;
    $vals["name"] = $this->_name;
    $vals["action"] = $this->_action;
    $vals["method"] = $this->_method;
    $vals["rows"] = array();

    if( count($this->_ids) ) {
      // if there is data, create a row for each id with
      // the corresponding fields and values loaded up
      foreach($this->_ids as $val) {
        $vals['rows'][] = $this->_genDataRow($val);
      }
    }
    else {
      // if there is no data, load a single blank row
      $vals['rows'][] = $this->_genDataRow(-1);
    }
    
    //ZenUtils::printArray($vals);//debug

    // render the form
    $template = new ZenTemplate();
    $template->assign($vals);
    $res = $template->fetch($this->_template);
    ZenUtils::unmark($markName);
    return $res;
  }

  /**
   * Generate a data row from the loaded ZenList for this rowid
   *
   * @param integer $rowid -1 for empty row
   */
  function _genDataRow( $rowid ) {
    $data = null;
    if( $this->_list && $rowid >= 0 ) {
      $data = $this->_list->get($rowid);
    }
    $row = array( "fields"=>array(), "hidden"=>array(), "jsvals"=>array() );
    foreach($this->_table->listFields() as $f) {
      // generate the field array
      $field = $this->_genFieldProps($f, $data);
      
      // skip field if needed
      if( $field['ftype'] == 'skip' ) { continue; }
      
      // add in special properties for enhanced fields
      $field = $this->_processSpecialFtypes($field);
      
      // format date strings
      if( $field['type'] == 'date' ) {
        $field['default'] = strlen($field['default'])?
          Zen::showDate($field['default']) : '';
      }
      // add the field to the appropriate array
      if( $field['ftype'] == 'hidden' ) {
        $row['hidden'][] = $field;
      }
      else {
        $row['fields'][] = $field;
        $row['jsvals'][] = array( $field['name'],
                                   ($field['required']? 1 : 0),
                                   $field['type'], 
                                   $field['ftype'],
                                   $field['label'],
                                   ($field['settext']? $field['settext'] : '') );
      }
    }
    return $row;
  }
  
  /**
   * Generate an array containing properties for this field.
   * Modify the field by altering any values manually set during
   * this objects life.
   *
   * @access private
   * @param string $name name of the field
   * @param ZenDataType $row the row data to use, if any
   * @return array
   */
  function _genFieldProps( $name, $row = null ) {
    // start with the meta info, if this is a field
    $metafield = $this->_table->getMetaField($name);    
    $field = is_object($metafield)?
      $metafield->getFieldArray() : array();

    // load value from row data, if any
    if( $row != null ) {
      $field['default'] = $row->getField($name);
    }

    // the required value is specially determines, it
    // isn't simply the entry for the data
    $field['required'] = $metafield->isRequired();

    // reduce notices/warnings
    $checkvals = array('default', 'description', 'len',
                       'cols', 'rows', 'settext',
                       'Blur', 'Change', 'Click', 'MouseOver', 'MouseOut',
                       'options', 'settext', 'other');
    for($i=0; $i<count($checkvals); $i++) {
      $k = $checkvals[$i];
      if( !isset($field[$k]) ) { $field[$k] = null; }
    }

    // assign customized form vals
    if( isset($this->_props[$name]) ) {
      foreach($this->_props[$name] as $key=>$val) {
        $field[$key] = $val;
      }
    }
    return $field;
  }

  /**
   * Create special properties needed for enhanced field types.
   *
   * If the field type passed is setting, the special field
   * 'id' must be provided to allow for retrieving the
   * field data.
   *
   * @access private
   * @param array $field the field data array
   * @return array the same array with new properties added
   */
  function _processSpecialFtypes( $field ) {
    switch( $field['ftype'] ) {
    case 'setting':
      ZenUtils::safeDebug($this, '_processSpecialFtypes',
                          "ftype 'setting' requires special processing!",
                          105, LVL_ERROR);
      break;
    case 'checkbox':
      if( !isset($field['checkval']) ) { $field['checkval'] = 1; }
      break;
    case 'helper':
      $field['settext'] = $this->_getHelperResult($field);
      break;
    case 'radio':
    case 'select':
    case 'checklist':
      $field['choices'] = $this->_generateArgs($field);
      break;
    case 'searchbox':
    case 'popselect':
      $ref = explode('.', $field['reference']);
      $fxn = $field['ftype'] == 'searchbox'? 'searchBox' : 'popSelect';
      if( !isset($field['showfield']) ) $field['showfield'] = $ref[1];
      $l = str_replace("'", "\\'", $field['label']);
      $field['Click'] = "{$fxn}(this, '{$l}', "
        ."'{$ref[0]}', '{$ref[1]}', '{$field['showfield']}', "
        ."'{$field['table']}', '{$field['name']}')";
      break;
    case 'yesno':
      $field['ftype'] = 'select';
      $field['choices'] = array( array('value'=>1,'label'=>'Yes'), 
                                 array('value'=>0,'label'=>'No'));
      break;
    case 'datebox':
      $field['settext'] = 
        ZenUtils::dateFormatToDisplay(Zen::getSetting('dates','date_format_short'));
      break;
    case 'colorbox':
      $field['click'] = "colorBox(this, '{$field['label']}')";
      break;
    }
    return $field;
  }

  /**
   * Generate arguments from field criteria and reference info to be
   * used for choices and settext params.
   *
   * @access private
   * @param array $field properties of the field
   * @return array this will return an array containing
   *         the keys 'value', 'label', 'selected', and 'style'.. 
   *         Note that there is nothing to force the helper/plugin
   *          methods to do return a proper array.
   */
  function _generateArgs($field) {
    // if there is no criteria to process, there are no arguments
    // to be passed
    if( !isset($field['criteria']) && !isset($field['reference']) ) { 
      ZenUtils::safeDebug($this, "_generateArgs", "Field {$field['name']}: criteria "
                          ."or reference required for field type {$field['type']}", 
                          101, LVL_ERROR);
      return null; 
    }
    if( !isset($field['criteria']) ) {
      return $this->_getArgsFromRef($field);
    }

    // if there is criteria, then we will
    // generate the list from this
    switch($field['criteria'][0]) { 
    case "filter":
      {
        return $this->_genFilterArgs($field);
      }
    case "list":
      {
        return $this->_genListArgs($field);
      }
    case "standard":
      {
        // a standard list is defined in lib/inc/standard_criteria.php
        // we will just look in $GLOBALS (where they are stored) and
        // extract the correct list
        if( !isset($GLOBALS['criteriaLists']) ) {
          ZenUtils::safeDebug($this, "_generateArgs", "Criteria lists not found!", 122, LVL_ERROR);
          return null;
        }
        $k = $field['criteria'][1];
        $list = $GLOBALS['criteriaLists'][$k];
        // we will overflow to the zenlist, since they
        // do pretty much the same thing
      }
    case "zenlist":
      {
        $def = $field['default'];
        if( $field['type'] == 'zenlist' ) {
          // for a zenlist, we are simply going
          // to load the data type list from the Zen
          $list = Zen::loadDataTypeArray($field['criteria'][1]);
        }
        if( is_array($list) ) {
          // convert our list into a usable format
          // with selected and style attributes
          $args = array();
          foreach($list as $id=>$name) {
            $args[] = $this->_genArg($id, $name, $def);
          }
          return $args;
        }
        return false;
      }
    case "helper":
      {
        return $this->_genHelperArgs($field);
      }
    default:
      return false;
    }
  }

  /**
   * Generate arguments for filter type criteria
   *
   * @return generally, this is an array containing ( label, value, selected, style )
   *                    although the helper and plugin methods could return whatever
   *                    they please (possibly a string, object, etc)
   */
  function _genFilterArgs($field) {
    $def = $field['default'];
    // the reference tag tells us which table and field we
    // are going to use for data
    list($table,$fk_id) = explode('.',$field['reference']);       
    if( is_numeric($field['criteria'][1]) ) {
      ZenUtils::prep("ZenFilter");
      // if we get a filter with just an id, it refers
      // to a filter_id in the filter table, so we will
      // simply retrieve it and use it for our filter parms
      $filter = new ZenFilter($field['criteria'][1]);
      $parms = $filter->createSearchParms();          
    }
    else {
      ZenUtils::prep("ZenSearchParms");
      // if we get a filter with params, we will
      // generate a ZenSearchParms object
      // ourselves from the params provided
      $parms = new ZenSearchParms('AND');
      $parts = explode(',',$field['criteria'][1]);
      foreach($parts as $p) {
        // the parts of $p represent
        // $fk-foriegn table field, $m-match or exclude, 
        // $o-operator(ZEN_EQ), $f-local field
        list($fk,$m,$o,$f) = explode(":",$p);
        // get the field value, it will be used as our
        // match parameter
        $f2 = $this->getMetaField($f);
        $v = $f2->getProp('default');
        // set the match/exclude condition, constant($o)
        // converts the operator string to the correct
        // constant value
        $parms->$m($fk, constant($o), $v, $table);
      }
    }
    return $this->_genArgsFromRef($field, $parms);
  }

  /**
   * Generate arguments from reference tag(in the case that there is no criteria)
   *
   * @param array $field
   * @param ZenSearchParms $parms search parameters, if coming from filter method
   * @return array
   */
  function _genArgsFromRef($field, $parms = null) {
    // if there is no criteria
    // then we will use the reference
    // id and create a list accordingly
    list($table,$fk_id) = explode('.', $field['reference']);
    $nf = $this->_genNameField($field,$table);
    $query = Zen::getNewQuery();
    $query->table($table);
    $query->field($fk_id);
    if( $nf ) { $query->field($nf); }
    if( $parms ) { $query->search($parms); }
    $vals = $query->select(Zen::getCacheTime(),true);
    if( is_array($vals) && count($vals) ) {
      // convert the values from the query
      // into proper args we can use
      $args = array();
      foreach($vals as $v) {
        $args[] = $this->_genArg($v[$fk_id], 
                                 ($nf? $v[$nf]:$v[$fk_id]), $def);
      }
      return $args;      
    }
    else { return array(); }
  }

  /**
   * Determines field to use for label
   *
   * @param array $field is the current field
   * @param string $table is the reference table
   * @return string or null(in case of null, just use the fkey)
   */
  function _genNameField($field, $table) {
    // the namefield is a field in the table to display
    // if there isn't a name field, the table is assumed
    // to have a field_name field.  If it does not, then
    // we will simply go with the pk field
    if( $field['namefield'] ) {
      $nf = $field['namefield'];
    }
    else {
      $metaTable = Zen::getMetaData(ZenUtils::classNameFromTable($table));
      if( in_array("field_name",$metaTable->listFields()) ) {
        $nf = 'field_name';
      }
      else { $nf = null; }
    }
    return $nf;
  }
  
  /**
   * Generate arguments for list type criteria
   */
  function _genListArgs($field) {
    $def = $field['default'];
    $args = array();
    $parts = explode(",",$field['criteria'][1]);
    // for lists, we will split the criteria on
    // commas, then look for entries with keys
    // ("[key]value") and plain entries "value"
    foreach($parts as $p) {
      if( preg_match('/^\[([^[]+)\](.*)$/', $p, $matches) ) {
        $k = $matches[1];
        $args[] = $this->_genArg($matches[1],$matches[2],$def);
      }
      else {
        $args[] = $this->_genArg($p,$p,$def);
      }
    }
    return $args;
  }

  /**
   * Generate string from helper type criteria
   */
  function _getHelperResult($field) {
    $def = $field['default'];
    $parms = array();
    $parts = explode(",", $field['criteria'][1]);
    foreach($parts as $p) {
      $pts = explode(":",$p);
      $key = $pts[0];
      switch( $pts[1] ) {
      case null:
        $val = null;
        break;
      case preg_match('/^"(.*)"$/', $pts[1], $matches):
        // this is a string
        $val = $matches[1];
        break;
      case 'ini':
        // ini property
        $val = ZenUtils::getIni($pts[2],$pts[3]);
        break;
      case 'setting':
        // database setting
        $val = Zen::getSetting($pts[2],$pts[3]);
        break;
      default:
        ZenUtils::safeDebug($this, '_genHelperArgs', 
                            "The text $p was not a valid arg entry", 103, LVL_ERROR);
        $val = null;
        break;
      }
      $parms[$key] = $val;
    }
    $parms['field'] = $field;
    $parms['template'] = $this->_template;
    $helper = $this->_table->name()."_{$f}_helper";
    return ZenUtils::runHelper($helper, $parms);
  }

  /**
   * Generate argument from key/val pairs
   *
   * @param string $val
   * @param string $label
   * @param string $default
   * @param string $style
   * @return array
   */
  function _genArg($val, $label, $default, $style = null) {
    return array("label" => $label,
                 "value" => $val,
                 "selected" => ($default && $default == $val),
                 "style" => $style);
  }

  /** @var ZenMetaTable $_table */
  var $_table;

  /** @var string $_key the primary key for this table */
  var $_key;

  /** 
   * @var string $_template the template design used to render form 
   */
  var $_template;

  /** @var string $_name the name of the form */
  var $_name;

  /** @var string $_action the form action */
  var $_action;
  
  /** @var string $_method the form post method */
  var $_method = 'POST';

  /** 
   * @var array $_vals values to pass to template, 
   * mapped (string)name->(mixed)value 
   */
  var $_vals;

  /** @var array $_rows the data rows to display (if any) */
  var $_rows;

  /** 
   * @var array $_props special form field properties, 
   * mapped (string)field->array( (string)prop->(mixed)value ) 
   */
  var $_props;

  /** 
   * @var integer $_ids the row id in database loaded 
   * into this form (or null) 
   */
  var $_ids;

  /** 
   * @var ZenList $_list a list containing all the data rows 
   * for this form's output (populated on demand) 
   */
  var $_list;

}

?>
